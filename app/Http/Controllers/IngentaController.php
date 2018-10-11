<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\ResearchPapers; 
use App\Authors;
use App\Keyword;

class IngentaController extends Controller
{
  public function scraper($url,$term)
  {
      $css_selector = "h2>a";
         
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
            //Arrays for Scraping         
            $abstract   = array();
            $authors    = array();
            $keywords   = array();
            $dates      = array();
            $doi        = array();

            //Arrays after Scraping and remove empty indexing and reindexing array.
            $emptyindex = array();
            $headings1  = array();
            $abstract1  = array();
            $authors1   = array();
            $links1     = array();
            $doi1       = array();

            //Counter for loops.
            $counter = 0;
            $j = 0;

            //Count headings (rows)
            $count = count($headings);
        
            for($i = 0 ; $i < $count; $i++)
            {
                //Click on links to open subpage.
                $link = $crawler->selectLink($headings[$i])->link();
                $subpage = $client->click($link);
                
                //Scrape Abstract
                $abstract_selector = "div.tab-content>div#Abst";
                $abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
                if (empty($abstract[$i])) 
                {
                  $abstract[$i]=array("Abstract is not available.");
                }
                //Scrape Date
                $date_selector = "div#Info>p:nth-last-child(2)";
                $dates[$i] = $subpage->filter($date_selector)->each(function($node){return $node->text();});
                if(empty($dates[$i]))
                {
                  $dates[$i] = array(" N/A");
                }

                //Scrape Keywords
                $keyword_selector = "div#Info>p>a";
                $keywords[$i] = $subpage->filter($keyword_selector)->each(function($node){return $node->text();});
                if(empty($keywords[$i]))
                {
                  $keywords[$i] = array($term);
                }

                //Sccrape DOI
                $doi_selector = "div.supMetaData>p:nth-child(3)>a";
                $doi[$i] = $subpage->filter($doi_selector)->each(function($node){return $node->text();});
                if(empty($doi[$i]))
                {
                  $doi[$i]=array("N/A");
                }

                //Scrape Authors
                $author_selector = "div#infoArticle>div:nth-child(2)>p>a";
                $authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});
                
                
               if (empty($authors[$i])) 
               {
                 $authors[$i]=array("N/A");
               } 
            }
            $doi1      = array_values($doi);
            $headings1 = array_values($headings);
            $abstract1 = array_values($abstract);
            $authors1  = array_values($authors);
            $links1    = array_values($links);
            $dates1    = array_values($dates);
            $keywords1 = array_values($keywords);
            //Extract Abstract from array in an array
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

            //Extract Date from array in an array
            $index1 = 0;
            $date_list = array();
            foreach ($dates1 as $key) 
            {
              foreach ($key as $key1 ) 
              {
                $pos = strpos($key1, "20",1);
                $date_list[$index1] = substr($key1, $pos,4);
                $index1++;
              }
            }
            //Extract Keywords from array in an array
            $index2 = 0;
            $keyword_list = array();
            foreach ($keywords1 as $key) 
            {
              foreach ($key as $key1 )
              {
                $keyword_list[$index2] = implode($key, ", ");  
              }
              $index2++;
            }
            $index21 = 0;
            $keyword_list1 = array();
            foreach ($keyword_list as $key) 
            {
              if ($keyword_list[$index21] == ", " || $keyword_list[$index21] == ", , " || $keyword_list[$index21] == ", , , " || $keyword_list[$index21] == ", , , , " || $keyword_list[$index21] == ", , , , , ")
              {
                $keyword_list1[$index21] = $term;
              }
              else
              {
                $keyword_list1[$index21] = $keyword_list[$index21];
              }
              $index21++;
            }

            //Extract DOI from array in an array
            $index3 = 0;
            $doi_list = array();
            foreach ($doi1 as $key) 
            {
              foreach ($key as $key1 ) 
              {
                $doi_list[$index3] = $key1;
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
                $ResearchPaper->paperlinks = 'http://www.ingentaconnect.com'.$links1[$i];
                $ResearchPaper->dates = $date_list[$i];
                $ResearchPaper->doi = $doi_list[$i];
                $ResearchPaper->research_areas = $term;
                $ResearchPaper->websites = "Ingenta";
                $ResearchPaper->save();
                $duplicates2 = Keyword::where('keywords', $keyword_list1[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
                $counter2 = count($duplicates2);
                if ($counter2 == 0) 
                {
                  $Keyword = new Keyword();
                  $Keyword->researchpaper_id = $ResearchPaper->id;
                  $Keyword->keywords = $keyword_list1[$i];
                  $Keyword->save(); 
                }
                $duplicates1 = Authors::where('authors', $authors_list[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
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
  public function artificial()
  {
    $term = "Artificial Intelligence";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=artificial+intelligence&pageSize=100";

    $this->scraper($url,$term);
  }
  public function machine()
  {
     $term = "Machine Learning";
     $term1 = str_replace(' ', '+', $term);
     $url = "https://www.ingentaconnect.com/search?option1=tka&value1=machine+Learning&pageSize=100&page=1";

     $this->scraper($url,$term);
  }

  public function recommendation()
  {
    $term = "Recommendation System";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=recommendation+system&pageSize=100";

    $this->scraper($url,$term);
  }

  public function dbms()
  {
    $term = "Database Management System";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=database+management+system&pageSize=100";

    $this->scraper($url,$term);
  }

  public function rfid()
  {
    $term = "RFID";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=rfid&pageSize=100";

    $this->scraper($url,$term); 
  }

  public function image()
  {
    $term = "Image Processing";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=image+processing&pageSize=100";
    
    $this->scraper($url,$term);
  }

  public function iot()
  {
    $term = "Internet of Things";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.ingentaconnect.com/search?option1=tka&value1=internet+of+things&pageSize=100";
    $this->scraper($url,$term);
  }

  public function cv()
  {
    $term = "Computer Vision";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=computer+vision&pageSize=100";

    $this->scraper($url,$term);
  }

  public function nlp()
  {
    $term = "Natural Language Processing";
    $term1 = str_replace(' ', '+', $term);
    $url = "http://www.ingentaconnect.com/search;jsessionid=a7op378mrac2h.x-ic-live-01?form_name=quicksearch&ie=%E0%A5%B0&option1=tka&value1=natural+language+processing&pageSize=100";
    $this->scraper($url,$term);
  }

  public function datamining()
  {
    $term = "Data Mining";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.ingentaconnect.com/search?option1=tka&value1=data+mining&pageSize=100";

    $this->scraper($url,$term);
  }
}