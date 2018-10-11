<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\ResearchPapers; 
use App\Authors;
use App\Keyword;

class ACMScrapeController extends Controller
{
	public function scraper($url,$term)
	{
		$css_selector = "div.details>div.title>a";
		$client = new Client();
		$crawler = $client->request('GET', $url);
		$css_selector1 = "div.details>div.source>span.publicationDate";

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
            //Scrape dates
			$dates = array();
			$dates = $crawler->filter($css_selector1)
			->each(function ($node) {
				return $node->text();
			});
            ////Arrays for Scraping         
			$abstract   = array();
			$authors    = array();
			$doi = array();

			$abstract_selector = "div.details>div.abstract"; 
			$abstract = $crawler->filter($abstract_selector)->each(function($node){return $node->text();});

            //Counter for loops.
			$counter = 0; 
			$j = 0;

			$count = count($abstract);
			for($i = 0 ; $i < $count; $i++)
			{
				$link = $crawler->selectLink($headings[$i])->link();
				$subpage = $client->click($link);

                //Selector for Authors
				$author_selector = "div#divmain>table>tr>td>table>tr>td>a";
				$authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});
				if (empty($authors[$i])) 
				{
					$authors[$i] = array('N/A');
				}
                //Scrape Doi
				$doi_selector = "div#divmain>table>tr>td>table:nth-child(3)>tr>td>table>tr:nth-child(5)>td>span>a";
				$doi[$i] = $subpage->filter($doi_selector)->each(function($node){return $node->attr('href');});
                //Code for finding empty array in the scraped data
				if (empty($doi[$i])) 
				{
					$doi[$i] = array("N\A"); 
				}

			}
			$index = 0;
			$authors1 = array();
			foreach ($authors as $key) 
			{
				$authors1[$index] = $key;
				$index++;    
			}
             //Extract Scraped Data from array in an array (2D => 1D)
			$index = 0;
			$doi_link = array();
			foreach ($doi as $key) 
			{
				foreach ($key as $key1 ) 
				{
					$doi_link[$index] = $key1;
					$index++;
				}
			}
			$loop = count($abstract);
			for($i = 0; $i < $loop; $i++)
			{
				$duplicates = ResearchPapers::where('title', $headings[$i]) ->get();
				$counter = count($duplicates);
				if ($counter == 0) 
				{

					$ResearchPaper = new ResearchPapers();
					$ResearchPaper->title = $headings[$i];
					$ResearchPaper->abstract = $abstract[$i];
					$ResearchPaper->paperlinks = 'https://dl.acm.org/'.$links[$i];
					$pos = strpos($dates[$i], '2',1);
					$substr_date=substr($dates[$i], $pos,4);                  
					$ResearchPaper->dates = $substr_date;
					$ResearchPaper->doi = $doi_link[$i];
					$ResearchPaper->research_areas = $term;
					$ResearchPaper->websites = "ACM";
					$ResearchPaper->save();
					$duplicates2 = Keyword::where('keywords', $term)->where('researchpaper_id',$ResearchPaper->id) ->get();
					$counter2 = count($duplicates2);
					if ($counter2 == 0) 
					{
						$Keyword = new Keyword();
						$Keyword->researchpaper_id = $ResearchPaper->id;
						$Keyword->keywords = $term;
						$Keyword->save(); 
					}
					else
					{
						echo "You already crawled these keywords".$i."<br>";
					}

					$duplicates1 = Authors::where('authors', $authors1[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
					$counter1 = count($duplicates1);
					if ($counter1 == 0) 
					{
						$str = implode(",",$authors1[$i]);
						$str1 = str_replace(",Stanford University", "", $str);
						$str2 = str_replace(",Bibliometrics", "", $str1);
						$str3 = str_replace(",DEEM'18", "", $str2);
						$str4 = str_replace(",ACM", "", $str3);
						$str5 = str_replace(",table of contents", "", $str4);
						$str6 = str_replace(",University of California Irvine", "", $str5);
						$str7 = str_replace(",TASLP Homepage", "", $str6);
						$str8 = str_replace("Get this Article,", "", $str7);
						$str9 = str_replace(",archive", "", $str8);
						$str10 = str_replace(",Brown University, USA", "", $str9);
						$Author = new Authors();
						$Author->researchpaper_id = $ResearchPaper->id;
						$Author->authors = $str10;
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
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Machine+Learning&Go.x=-1&Go.y=3";

		$this->scraper($url,$term);
	}

 	//Recomendation Systems
	public function recommendation()
	{
		$term = "Recommendation Systems";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?query=(Recommendation%20Systems)&within=owners.owner=HOSTED&filtered=&dte=&bfr=";

		$this->scraper($url,$term);
	}

    //Database Management Systems
	public function dbms()
	{
		$term = "Database Management Systems";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=_score&query=%28Database+Management+Systems%29&Go.x=0&Go.y=0";

	    $this->scraper($url,$term);
	}

    //Artificial Intelligence
	public function artificial()
	{
		$term = "Artificial Intelligence";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=_score&query=%28Artificial+Intelligence%29&Go.x=0&Go.y=0";

	    $this->scraper($url,$term);
	}

	//RFID
	public function rfid()
	{
		$term = "RFID";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Rfid&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}

	//Data Mining
	public function datamining()
	{
		$term = "Data Mining";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Data+Mining&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}

	//Image Processing
	public function image()
	{
		$term = "Image Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Image+Processing&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}
	//Internet Of things
	public function iot()
	{
		$term = "Internet of Things";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Internet+Of+Things&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}

	//Natural Language Processing
	public function nlp()
	{
		$term = "Natural Language Processing";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Natural+Language+Processing&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}
	//Computer Vision
	public function cv()
	{
		$term = "Computer Vision";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Computer+Vision&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}

	//Data Mining
	public function dataminig()
	{
		$term = "Data Mining";
		$term1 = str_replace(' ', '+', $term);
		$url = "https://dl.acm.org/results.cfm?within=owners.owner%3DHOSTED&srt=publicationDate&query=Data+Mining&Go.x=-1&Go.y=3";

        $this->scraper($url,$term);
	}

}
