<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use App\ResearchPapers; 
use App\Authors;
use App\Keyword;

class ScraperController extends Controller
{
  public function scraper($url,$term)
  {
    $css_selector = "div.result-item-content>h2>a";

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
      //Scrape dates
      $dates= array();
      $date_selector = "div>div>ol.SubType>li:nth-child(3)>span:nth-child(1)";
      $dates = $crawler->filter($date_selector)
      ->each(function ($node) 
      {
        return $node->text();
      });
      //Remove string in the date.
      $ind = 0;
      $date_list = array();
      foreach ($dates as $key)
      {
        $date_list[$ind] = str_replace("Available online ", "", $key);
        $ind++;
      }
      //Arrays for Scraping         
      $abstract   = array();
      $authors    = array();
      $doi        = array();
      $keywords   = array();

      //Arrays after Scraping and remove empty indexing and reindexing array.
      $headings1  = array();
      $abstract1  = array();
      $authors1   = array();
      $links1     = array();
      $keywords1  = array();
      $doi1       = array();
      //Count headings (rows)
      $count = count($headings);
      for($i = 0 ; $i < $count; $i++)
      {
        //Click on links to open subpage.
        $link = $crawler->selectLink($headings[$i])->link();
        $subpage = $client->click($link);
        //Scrape Abstract
        $abstract_selector = "div.Abstracts";
        $abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
        if(empty($abstract[$i]))
        {
          $abstract[$i] = array("Abstract is not Available");
        }
        //Scrape Keywords
        $keyword_selector = "div.Keywords>div.keywords-section>div>span";
        $keywords[$i] = $subpage->filter($keyword_selector)->each(function($node){return $node->text();});
        if(empty($keywords[$i]))
        {
          $keywords[$i] = array($term);
        }
        //Scrape DOI
        $doi_selector = "div.DoiLink>a.doi";
        $doi[$i] = $subpage->filter($doi_selector)->each(function($node){return $node->text();});
        if(empty($doi[$i]))
        {
          $doi[$i] = array("N\A");
        }
        //Scrape Authors   
        $author_selector = "div.author-group>a>span";
        $authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});
        if(empty($authors[$i]))
        {
          $authors[$i] = array("N\A");
        }
      }           
      $doi1      = array_values($doi);
      $headings1 = array_values($headings);
      $abstract1 = array_values($abstract);
      $authors1  = array_values($authors);
      $links1    = array_values($links);
      $dates1    = array_values($date_list);
      $keywords1 = array_values($keywords);

      //Extract Scraped Data from array in an array (2D => 1D)
      $index = 0;
      $abstarct_title = array();
      foreach ($abstract1 as $key) 
      {
        foreach ($key as $key1 ) 
        {
          $abstarct_title[$index] = $key1;
          $index++;
        }
      }
      $index1 = 0;
      $doi_link = array();
      foreach ($doi1 as $key) 
      {
        foreach ($key as $key1 ) 
        {
          $doi_link[$index1] = $key1;
          $index1++;
        }
      }

      $index2 = 0;
      $keyword_list = array();
      foreach ($keywords1 as $key) 
      {
        $keyword_list[$index2] = $key;
        $index2++;
      }

      $index1 = 0;
      $authors_list = array();
      foreach ($authors1 as $key) 
      {
        $authors_list[$index1] = $key;
        $index1++;                 
      }
      //All the Scraped Data store in database
      $loop = count($dates); 
      for($i = 0; $i < $loop-1; $i++)
      {
        $duplicates = ResearchPapers::where('title', $headings1[$i]) ->get();
        $counter = count($duplicates);
        if ($counter == 0) 
        {
          $ResearchPaper = new ResearchPapers();
          $ResearchPaper->title = $headings1[$i];
          $ResearchPaper->abstract = $abstarct_title[$i];
          $ResearchPaper->paperlinks = 'https://www.sciencedirect.com'.$links1[$i];
          $ResearchPaper->doi = $doi_link[$i];
          $pos = strpos($dates1[$i], '20');
          $substr_dates = substr($dates1[$i], $pos,4);
          $ResearchPaper->dates = $substr_dates;
          $ResearchPaper->research_areas = $term;
          $ResearchPaper->websites = "Science Direct";
          $ResearchPaper->save();      
          $duplicates2 = Keyword::where('keywords', $keyword_list[$i])->where('researchpaper_id',$ResearchPaper->id) ->get();
          $counter2 = count($duplicates2);
          if ($counter2 == 0) 
          {
            $str = implode(", ", $keyword_list[$i]);
            $Keyword = new Keyword();
            $Keyword->researchpaper_id = $ResearchPaper->id;
            $Keyword->keywords = $str;
            $Keyword->save();  
          }
          else
          {
            echo "You already crawled these keywords".$i."<br>";
          }
          $duplicates1 = Authors::where('authors', $authors_list[$i])->where('researchpaper_id',$ResearchPaper->id)->get();
          $counter1 = count($duplicates1);
          if ($counter1 == 0) 
          {
            $str1 = implode(", ", $authors_list[$i]);
            $Author = new Authors();
            $Author->researchpaper_id = $ResearchPaper->id;
            $Author->authors = $str1;
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
      echo "Data successfully crawled";
    }
  }
  public function machine()
  {
    $term = "Machine Learning";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Machine%20Learning&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
    
    $this->scraper($url,$term);
  }
  public function dbms()
  {
    $term = "Database Management System";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Database%20Management%20System&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
    
    $this->scraper($url,$term);
  }

  public function artificial()
  {
    $term = "Artificial Intelligence";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Artificial%20Intelligence&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
        
    $this->scraper($url,$term);
  }

  public function recommendation()
  {
    $term = "Recommendation System";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Recommendation%20System&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";

    $this->scraper($url,$term);
  }
        
  public function rfid()
  {
    $term = "RFID";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Rfid&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
    
    $this->scraper($url,$term);
  }

  public function iot()
  {
    $term = "Internet of Things";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Internet%20Of%20Things&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
        
    $this->scraper($url,$term);
  }
     
  public function image()
  {
    $term = "Image Processing";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Image%20Processing&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
    $this->scraper($url,$term);
  }

  public function nlp()
  {
    $term = "Natural Language Processing";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Natural%20Language%20Processing&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
        
    $this->scraper($url,$term);
  }

  public function datamining()
  {
    $term = "Data Mining";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Data%20Mining&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
        
    $this->scraper($url,$term);
  }

  public function cv()
  {
    $term = "Computer Vision";
    $term1 = str_replace(' ', '+', $term);
    $url = "https://www.sciencedirect.com/search?qs=Computer%20Vision&authors=&pub=&volume=&issue=&page=&origin=home&zone=qSearch&show=100";
    $this->scraper($url,$term);
  }
}
