<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\ResearchPapers; 
use App\Authors;
use App\Keyword;


class EricController extends Controller
{
	public function scraper($url,$term)
	{
		//CSS selector for urls and headings.
		$css_selector = "div>div>div.r_t>a";
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
			$links= array();
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
            ////Arrays for Scraping         
			$abstract   = array();
			$authors    = array();
			$keywords    = array();
			$dates = array();

			$count = count($headings);
			
			for($i = 0 ; $i < $count; $i++)
			{
				$link = $crawler->selectLink($headings[$i])->link();
				$subpage = $client->click($link);
				
				$abstract_selector = "div.abstract";
				$abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
				if (empty($abstract[$i])) 
				{
					$abstract[$i] = array('Abstract is not available');
				}

				$date_selector = "div#r_colR>div>div:nth-child(3)";
				$dates[$i] = $subpage->filter($date_selector)->each(function($node){return $node->text();});
				if (empty($dates[$i])) 
				{
					$dates[$i] = array('N/A');
				}
				$keyword_selector = "div.keywords>a";
				$keywords[$i] = $subpage->filter($keyword_selector)->each(function($node){return $node->text();});
				if (empty($keywords[$i])) 
				{
					$keywords[$i] = array($term);
				}

                //Selector for Authors
				$author_selector = "div.r_a>div:nth-child(1)";
				$authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});
				if (empty($authors[$i])) 
				{
					$authors[$i] = array('N/A');
				}
				
			}
			$abstract1 = array();
			$index = 0;
			foreach ($abstract as $key) 
			{
				foreach ($key as $key1) 
				{
					$abstract1[$index] = $key1;
					$index++;
				}
			}
			$authors1 = array();
			$index = 0;
			foreach ($authors as $key) 
			{
				foreach ($key as $key1) 
				{
					$authors1[$index] = $key1;
					$index++;
				}
			}
			$dates1 = array();
			$index = 0;
			foreach ($dates as $key) 
			{
				foreach ($key as $key1) 
				{
					$pos = strpos($key1, '2',1);
					$substr=substr($key1, $pos,4);
					$dates1[$index] = $substr;
					$index++;
				}
			}	
			$keywords1 = array();
			$index = 0;
			foreach ($keywords as $key) 
			{
				
				$keywords1[$index] = $key;
				$index++;
				
			}
			$loop = count($headings);

			for($i = 0; $i < $loop; $i++)
			{
				$duplicates = ResearchPapers::where('title', $headings[$i]) ->get();
				$counter = count($duplicates);
				if ($counter == 0) 
				{
					$ResearchPaper = new ResearchPapers();
					$ResearchPaper->title = $headings[$i];
					$ResearchPaper->abstract = $abstract1[$i];
					$ResearchPaper->paperlinks = 'https://eric.ed.gov/'.$links[$i];
					$ResearchPaper->dates = $dates1[$i];
					$ResearchPaper->doi = $doi[$i];
					$ResearchPaper->research_areas = $term;
					$ResearchPaper->websites = "Eric";
					$ResearchPaper->save();

					$duplicates2 = Keyword::where('keywords', $keywords1[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
					$counter2 = count($duplicates2);
					if ($counter2 == 0) 
					{
						$keywords2 = implode(",", $keywords1[$i]);
						$Keyword = new Keyword();
						$Keyword->researchpaper_id = $ResearchPaper->id;
						$Keyword->keywords = $keywords2;
						$Keyword->save(); 

					}	
					else
					{
						echo "You already crawled these keywords".$i."<br>";
					}
					$duplicates1 = Authors::where('authors', $authors[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
					$counter1 = count($duplicates1);
					if ($counter1 == 0) 
					{
						
						$Author = new Authors();
						$Author->researchpaper_id = $ResearchPaper->id;
						$Author->authors = $authors1[$i];
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
		else
		{
			dd('Check Your Internet Connection');
		}
	}
	//Database management System
	public function dbms()
	{
		$term = "Database Management System";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=database+management+system&ft=on";

		$this->scraper($url,$term);
	}

    //Machine Learning
	public function machine()
	{
		
	 	$term = "Machine Learning";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=Machine+Learning&ft=on";

        $data = $this->scraper($url,$term);
	}

	//Recommendation System
	public function recommendation()
	{
		
		$term = "Recommendation System";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=Recommendation+Systems&ft=on";

        $data = $this->scraper($url,$term);
	}

	//Artificial Intelligence
	public function artificial()
	{
		
		$term = "Artificial Intelligence";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=Artificial+Intelligence&ft=on";

        $data = $this->scraper($url,$term);
	}

	//RFID
	public function rfid()
	{
		$term = "RFID";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=rfid&ft=on";

        $data = $this->scraper($url,$term);
	}

	//IOT
	public function iot()
	{
		$term = "Internet of Things";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=internent+of+things&ft=on";

        $data = $this->scraper($url,$term);
	}

	//Imageprocessing
	public function image()
	{	
		$term = "Image Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=image+processing&ft=on";

        $data = $this->scraper($url,$term);
	}

	//computer vision
	public function cv()
	{
		$term = "Computer Vision";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=computer+vision&ft=on";

        $data = $this->scraper($url,$term);
	}

	//nlp
	public function nlp()
	{
		$term = "Natural Language Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=natural+language+processing&ft=on";

        $data = $this->scraper($url,$term);
	}

	//Data Mining
	public function datamining()
	{	
		$term = "Data Mining";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=data+mining&ft=on";

        $data = $this->scraper($url,$term);
    }

}
