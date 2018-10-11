<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\ResearchPapers; 
use App\Authors;
use App\Keyword;

class PubController extends Controller
{
	public function scraper($url,$term)
	{
		$css_selector = "div>p.title>a";
		$client = new Client();
		$crawler = $client->request('GET', $url);

		$status_code = $client->getResponse()->getStatus();
		if ($status_code==200) 
		{
            //Scrape Headings
			$headings= array();
			$headings = $crawler->filter($css_selector)
			->each(function ($node) {
				return $node->text();
			});
			//Scrape Links
			$links = array();
			$links = $crawler->filter($css_selector)
			->each(function ($node) {
				return $node->attr('href');
			});
            //Scrape DOI
			$doi = array();
			$doi_selector = "div>div>div.r_f>a";
			$doi = $crawler->filter($doi_selector)
			->each(function ($node) {
				return $node->attr('href');
			});
            //Arrays for Scraping         
			$abstract   = array();
			$authors    = array();
			$dates      = array();
			$keywords   = array();
			$doi        = array();

            //Arrays after Scraping and remove empty indexing and reindexing arrays
			$headings1  = array();
			$abstract1  = array();
			$authors1   = array();
			$links1     = array();
			$doi1       = array();

            //Counter for loops.
			$count = count($headings);

			for($i = 0 ; $i < $count; $i++)
			{
                //Click on links to open subpage.
				$link = $crawler->selectLink($headings[$i])->link();
				$subpage = $client->click($link);

                //Scrape Abstract
				$abstract_selector = "div.abstr>div>p:nth-child(1)";
				$abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
				if(empty($abstract[$i]))
				{
					$abstract[$i] = array("Abstract is not Available");
				}
                //Scrape Date
				$date_selector = "div.cit";
				$dates[$i] = $subpage->filter($date_selector)->each(function($node){return $node->text();});
				if(empty($dates[$i]))
				{
					$dates[$i] = array("N\A");
				}
                //Scrape DOI
				$doi_selector = "div.aux>div.resc>dl>dd:nth-last-child(1)>a";
				$doi[$i] = $subpage->filter($doi_selector)->each(function($node){return $node->attr('href');});
				if(empty($doi[$i]))
				{
					$doi[$i] = array("N\A");
				}

                //Scrape Keywords
				$keyword_selector = "div.keywords>p";
				$keywords[$i] = $subpage->filter($keyword_selector)->each(function($node){return $node->text();});
				if(empty($keywords[$i]))
				{
					$keywords[$i] = array($term);
				}

                //Explode multiple keywords from entire rows
				$index = 0;
				$keyword_exp = array();
				foreach ($keywords as $key) 
				{
					foreach ($key as $key1 )
					{
						$keyword_exp[$index] = explode(";", $key1);
					}
					$index++;
				}

                //Scrape Authors
				$author_selector = "div.auths>a";
				$authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});

                //Code for finding empty array in the scraped data
				if (empty($authors[$i])) 
				{
					$authors[$j] = array("N/A");
				}
			}

			$headings1 = array_values($headings);
			$abstract1 = array_values($abstract);
			$authors1  = array_values($authors);
			$links1    = array_values($links);
			$dates1    = array_values($dates);
			$doi1      = array_values($doi);
			$keywords1 = array_values($keywords);
			
            //Extract Scraped Data from array in an array (2D => 1D)
			$index = 0;
			$abstract_list = array();
			foreach ($abstract1 as $key) 
			{
				foreach ($key as $key1 ) 
				{
					$abstract_list[$index] = $key1;
					$index++;
				}
			}

			$index1 = 0;
			$date_list = array();
			foreach ($dates1 as $key) 
			{
				foreach ($key as $key1 ) 
				{
					$pos = strpos($key1, "20");
					$date_list[$index1] = substr($key1, $pos, 4);
					$index1++;
				}
			}
			$index2 = 0;
			$keyword_list = array();
			foreach ($keyword_exp as $key) 
			{
				foreach ($key as $key1 )
				{
					$keyword_list[$index2] = implode($key, ", ");
				}
				$index2++;
			}

			$index3 = 0;
			$doi_list = array();
			foreach ($doi1 as $key) 
			{
				foreach ($key as $key1 )
				{
					$doi_list[$index3] = str_replace("//", "https://", $key1);
					$index3++;
				}
			}

			$index = 0;
			$authors_list = array();
			foreach ($authors1 as $key) 
			{
				$authors_list[$index] = $key;
				$index++;    
			}


            //All the Scraped Data store in database
			$loop = count($headings1);
			for($i = 0; $i < $loop; $i++)
			{
				$duplicates = ResearchPapers::where('title', $headings1[$i]) ->get();
				$counter = count($duplicates);
				if ($counter == 0) 
				{
					$ResearchPaper = new ResearchPapers();
					$ResearchPaper->title = $headings1[$i];
					$ResearchPaper->abstract = $abstract_list[$i];
					$ResearchPaper->paperlinks = 'https://www.ncbi.nlm.nih.gov'.$links1[$i];
					$ResearchPaper->dates = $date_list[$i];
					$ResearchPaper->doi = $doi_list[$i];
                    $ResearchPaper->research_areas = $term;
                    $ResearchPaper->websites = "Pubmed";
					$ResearchPaper->save();
					$duplicates2 = Keyword::where('keywords', $keyword_list[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
	                  $counter2 = count($duplicates2);
	                  if ($counter2 == 0) 
		                  {
		                    $Keyword = new Keyword();
		                    $Keyword->researchpaper_id = $ResearchPaper->id;
		                    $Keyword->keywords = $keyword_list[$i];
		                    $Keyword->save(); 
		                   }
	                  else
	                  {
	                    echo "You already crawled these keywords".$i."<br>";
	                  }
					$duplicates1 = Authors::where('authors', $authors1[$i]) ->get();
					$counter1 = count($duplicates1);
					if ($counter1 == 0) 
	                  {
	                    $str = implode(",",$authors1[$i]);
	                    $Author = new Authors();
	                    $Author->researchpaper_id = $ResearchPaper->id;
	                    $Author->authors = $str;
	                    $Author->save(); 
	                  } 
					else
					{
						echo "You already crawled these authors".$i."<br>";
					}

				}

				else
				{
					echo "You already crawled this data".$i."<br>";
				}
			}

			echo "Data successfully crawled" . "<br>";
		}
	}
	public function machine()
	{
		$term = "Machine Learning";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=machine+learning";

		$this->scraper($url,$term);
	}

	public function artificial()
	{
		$term = "Artificial Intelligence";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=artificial+intelligence";

        $this->scraper($url,$term);
	}

	public function dbms()
	{
		$term = "Database Management System";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=database+management+system";

        $this->scraper($url,$term);
	}

	public function recommendation()
	{
		$term = "Recommendation System";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=Recommendation+System";

        $this->scraper($url,$term);
	}

	//rfid
	public function rfid()
	{
		$term = "RFID";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=rfid";

        $this->scraper($url,$term);
	}

	//IOT
	public function iot()
	{
		$term = "Internet of Things";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=internet+of+things";

		$this->scraper($url,$term);
	}

	//Image Processing
	public function image()
	{
		$term = "Image Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=image+processing";

        $this->scraper($url,$term);
	}

	//computer Vision
	public function cv()
	{
		$term = "Computer Vision";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=computer+vision";

        $this->scraper($url,$term);
	}

	//NLP
	public function nlp()
	{
		$term = "Natural Language Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=natural+language+processing";

        $this->scraper($url,$term);
	}

	//Data Mining
	public function datamining()
	{
		$term = "Data Mining";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=data+mining";

        $this->scraper($url,$term);
	}
}
