<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\ResearchPapers;
use DB;
use View;
use App\NotAvailable;
use App\NotAvailAdvance;
use App\Keyword;  
use Goutte\Client;
use App\Authors;
use Session;
use Redirect;

class NotAvailController extends Controller
{

	public function index()
	{
		$term = NotAvailable::latest()->pluck('search_keywords')->first();
		$term1 = str_replace(' ', '+', $term);
		$url = "https://eric.ed.gov/?q=".$term1."&ft=on";
		
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
			if (count($headings)==0) 
			{
				return redirect()->route('notavailsearch.show',$term1)->with('m','1')->with([ 'terms' => $term]);
			}
			else
			{
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

    		    //Arrays after Scraping and remove empty indexing and reindexing array.
				$headings1  = array();
				$abstract1  = array();
				$authors1   = array();
				$links1     = array();
				$dates1 =array();
				$keywords1 =array();
				$doi1       = array();


				for($i = 0 ; $i < $count-1; $i++)
				{
					$link = $crawler->selectLink($headings[$i])->link();
					$subpage = $client->click($link);

					$abstract_selector = "div.abstract";
					$abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
					if (empty($abstract[$i])) 
					{
						$abstract[$i] = array('Abstract is not Available');
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

				$doi1      = array_values($doi);
				$headings1 = array_values($headings);
				$abstract1 = array_values($abstract);
				$authors1  = array_values($authors);
				$links1    = array_values($links);
				$dates1    = array_values($dates);
				$keywords1 = array_values($keywords);


				$abstract2 = array();
				$index = 0;
				foreach ($abstract1 as $key) 
				{
					foreach ($key as $key1) 
					{
						$abstract2[$index] = $key1;
						$index++;
					}
				}
				$authors2 = array();
				$index = 0;
				foreach ($authors1 as $key) 
				{
					foreach ($key as $key1) {
						$authors2[$index] = $key1;
						$index++;
					}
				}
				$dates2 = array();
				$index = 0;
				foreach ($dates1 as $key) 
				{
					foreach ($key as $key1) 
					{
						$pos = strpos($key1, '2',1);
						$substr=substr($key1, $pos,4);
						$dates2[$index] = $substr;
						$index++;
					}
				}	
				$keywords2 = array();
				$index = 0;
				foreach ($keywords1 as $key) 
				{

					$keywords2[$index] = $key;
					$index++;

				}
				$loop = count($headings1);
				for($i = 0; $i < $loop-1; $i++)
				{
					$duplicates = ResearchPapers::where('title', $headings1[$i]) ->get();
					$counter = count($duplicates);
					if ($counter == 0) 
					{
						$ResearchPaper = new ResearchPapers();
						$ResearchPaper->title = $headings1[$i];
						$ResearchPaper->abstract = substr($abstract2[$i],0,7000);
						$ResearchPaper->paperlinks = 'https://eric.ed.gov/'.$links1[$i];
						$ResearchPaper->dates = $dates2[$i];
						$ResearchPaper->doi = $doi1[$i];
						$ResearchPaper->research_areas = $term;
						$ResearchPaper->websites = "Eric";
						$ResearchPaper->save();

						$duplicates2 = Keyword::where('keywords', $keywords2[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
						$counter2 = count($duplicates2);
						if ($counter2 == 0) 
						{
							$keywords3 = implode(",", $keywords2[$i]);
							$Keyword = new Keyword();
							$Keyword->researchpaper_id = $ResearchPaper->id;
							$Keyword->keywords = $keywords3;
							$Keyword->save(); 

						}
						$duplicates1 = Authors::where('authors', $authors1[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
						$counter1 = count($duplicates1);
						if ($counter1 == 0) 
						{

							$Author = new Authors();
							$Author->researchpaper_id = $ResearchPaper->id;
							$Author->authors = $authors2[$i];
							$Author->save(); 

						}
					}
				}
				return redirect()->route('notavailsearch.show',$term1)->with('m','1')->with([ 'terms' => $term]);
			}
		}
	}
	
}


