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

class SearchUsingCheckbox extends Controller
{
	public function fun1()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->pubmed($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='pubmed';
		$source3='Pubmed';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun2()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->acm($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='eric';
		$source3='Eric';
		$source4='acm';
		$source5='Acm';

		return redirect()->route('advancedsearch2.show',[$author,$date,$term,$source,$source1,$source2,$source3,$source4,$source5])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun22()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->pubmed($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='eric';
		$source3='Eric';
		$source4='pubmed';
		$source5='Pubmed';

		return redirect()->route('advancedsearch2.show',[$author,$date,$term,$source,$source1,$source2,$source3,$source4,$source5])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun222()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->acm($date);
		$this->pubmed($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='acm';
		$source3='Acm';
		$source4='pubmed';
		$source5='Pubmed';

		return redirect()->route('advancedsearch2.show',[$author,$date,$term,$source,$source1,$source2,$source3,$source4,$source5])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun3()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='eric';
		$source3='Eric';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}

	public function fun4()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$source='Science+Direct';
		$source1='science';
		$this->sciencedirect($date);
		return redirect()->route('advancedsearch.show',[$author,$date,$term,$source1,$source])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun5()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->acm($date);
		$this->sciencedirect($date);
		$source='science';
		$source1='Science+Direct';
		$source2='acm';
		$source3='Acm';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun9()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->acm($date);
		$this->pubmed($date);
		$source='eric';
		$source1='Eric';
		$source2='acm';
		$source3='Acm';
		$source4='pubmed';
		$source5='Pubmed';

		return redirect()->route('advancedsearch2.show',[$author,$date,$term,$source,$source1,$source2,$source3,$source4,$source5])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun10()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->pubmed($date);
		$source='eric';
		$source1='Eric';
		$source2='pubmed';
		$source3='Pubmed';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun11()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->acm($date);
		$source='eric';
		$source1='Eric';
		$source2='acm';
		$source3='Acm';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun12()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$source='eric';
		$source1='Eric';
		return redirect()->route('advancedsearch.show',[$author,$date,$term,$source,$source1])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun13()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->acm($date);
		$source='acm';
		$source1='Acm';
		return redirect()->route('advancedsearch.show',[$author,$date,$term,$source,$source1])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun14()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->pubmed($date);
		$this->acm($date);
		$source='acm';
		$source1='Acm';
		$source2='pubmed';
		$source3='Pubmed';
		return redirect()->route('advancedsearch1.show',[$author,$date,$term,$source,$source1,$source2,$source3])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function fun15()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->pubmed($date);
		$source='pubmed';
		$source1='Pubmed';
		return redirect()->route('advancedsearch.show',[$author,$date,$term,$source,$source1])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function AllSites()
	{
		$date = session()->get('date');
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$author = NotAvailAdvance::latest()->pluck('authors')->first();
		$this->eric($date);
		$this->acm($date);
		$this->sciencedirect($date);
		$this->pubmed($date);
		$source='science';
		$source1='Science+Direct';
		$source4='acm';
		$source5='Acm';
		$source6='pubmed';
		$source7='Pubmed';
		$source2='eric';
		$source3='Eric';

		return redirect()->route('advancedsearch3.show',[$author,$date,$term,$source,$source1,$source2,$source3,$source4,$source5,$source6,$source7])->with(['date' => $date])->with(['term' => $term])->with(['author' => $author])->with('m','1');
	}
	public function pubmed($value)
	{
		$datess = $value;
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$term1 = str_replace(' ', '+', $term);
		$term2 = NotAvailAdvance::latest()->pluck('authors')->first();
		$term3 = str_replace(' ', '+', $term2);
		if($datess=="")
		{
			if($term1=="")
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed?term=".$term3."%5BAuthor%5D";
			}
			elseif($term3=="")
			{
				$url ="https://www.ncbi.nlm.nih.gov/pubmed?term=".$term1."%5BTitle%2FAbstract%5D";
			}
			else
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(".$term3."%5BAuthor%5D)+AND+".$term1."%5BTitle%2FAbstract%5D";
			}
		}
		elseif($datess=="2000-2010")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222000%22%5BDate+-+Publication%5D+%3A+%222010%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)";
			}
			elseif($term3=="" && $term1!="")
			{
				$url ="https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222000%22%5BDate+-+Publication%5D+%3A+%222010%22%5BDate+-+Publication%5D))++AND+".$term1."%5BTitle%2FAbstract%5D";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222000%22%5BDate+-+Publication%5D+%3A+%222010%22%5BDate+-+Publication%5D))";
			}
			else
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222000%22%5BDate+-+Publication%5D+%3A+%222010%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)+AND+".$term1."%5BTitle%2FAbstract%5D";
			}
		}
		elseif($datess=="2011-2015")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222011%22%5BDate+-+Publication%5D+%3A+%222015%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)";
			}
			elseif($term3=="" && $term1!="")
			{
				$url ="https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222011%22%5BDate+-+Publication%5D+%3A+%222015%22%5BDate+-+Publication%5D))++AND+".$term1."%5BTitle%2FAbstract%5D";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222011%22%5BDate+-+Publication%5D+%3A+%222015%22%5BDate+-+Publication%5D))";
			}
			else
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222011%22%5BDate+-+Publication%5D+%3A+%222015%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)+AND+".$term1."%5BTitle%2FAbstract%5D";
			}
		}
		elseif($datess=="2016-2018")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222016%22%5BDate+-+Publication%5D+%3A+%222018%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)";
			}
			elseif($term3=="" && $term1!="")
			{
				$url ="https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222016%22%5BDate+-+Publication%5D+%3A+%222018%22%5BDate+-+Publication%5D))++AND+".$term1."%5BTitle%2FAbstract%5D";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222016%22%5BDate+-+Publication%5D+%3A+%222018%22%5BDate+-+Publication%5D))";
			}
			else
			{
				$url = "https://www.ncbi.nlm.nih.gov/pubmed/?term=(((%222016%22%5BDate+-+Publication%5D+%3A+%222018%22%5BDate+-+Publication%5D))+AND+".$term3."+%5BAuthor%5D)+AND+".$term1."%5BTitle%2FAbstract%5D";
			}
		}

         //CSS selector for urls and headings.
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

			if (count($headings)==0) 
			{
				return;
			}
			else{
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
						$abstract[$i] = array("Abstract Not Available");
					}

                //Scrape Date
					$date_selector = "div.cit";
					$dates[$i] = $subpage->filter($date_selector)->each(function($node){return $node->text();});
					if(empty($dates[$i]))
					{
						$dates[$i] = array("N/A");
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
					if(empty($authors[$i]))
					{
						$authors[$i] = array("N/A");
					}
				}
            //Loop for remove empty rows.
				
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
				foreach ($keywords1 as $key) 
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
						$ResearchPaper->abstract = substr($abstract_list[$i],0,7000);
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
			}

		}
	}
	public function eric($value)
	{

		$datess = $value;
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$term1 = str_replace(' ', '+', $term);
		$term2 = NotAvailAdvance::latest()->pluck('authors')->first();
		$term3 = str_replace(' ', '+', $term2);

		if($datess=="")
		{
			if($term1=="")
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"%22&ft=on";
			}
			elseif($term3=="")
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on";
			}
			else
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"+abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on";
			}
		}
		elseif($datess=="2000-2010")
		{
			if($term1=="" && $term3!="")
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"%22&ft=on&ff1=dtySince_2000";
			}
			elseif($term3=="" && $term1!="")
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2000";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2000";
			}
			else
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"+abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2000";
			}
		}
		elseif($datess=="2011-2015")
		{
			if($term1=="" && $term3!="")
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"%22&ft=on&ff1=dtySince_2011";
			}
			elseif($term3=="" && $term1!="")
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2011";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2011";
			}
			else
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"+abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2011";
			}
		}
		elseif($datess=="2016-2018")
		{
			if($term1=="" && $term3!="")
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"%22&ft=on&ff1=dtySince_2016";
			}
			elseif($term3=="" && $term1!="")
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2016";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://eric.ed.gov/?q=abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2016";
			}
			else
			{
				$url="https://eric.ed.gov/?q=author%3a\"".$term3."\"+abstract%3a%22\"".$term1."\"%22+title%3a%22\"".$term1."\"%22&ft=on&ff1=dtySince_2016";
			}
		}


			//CSS selector for urls and headings.
		$css_selector = "div>div>div.r_t>a";
		$client = new Client();
		$crawler = $client->request('GET', $url);

		$status_code = $client->getResponse()->getStatus();


              //Scrape Headings
		$headings= array();
		$headings = $crawler->filter($css_selector)
		->each(function ($node) {
			return $node->text();
		});

		if (count($headings)==0) 
		{
			return;
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
			$counter = 0;
			$j = 0;

    		       //Arrays after Scraping and remove empty indexing and reindexing array.
			$emptyindex = array();
			$headings1  = array();
			$abstract1  = array();
			$authors1   = array();
			$links1     = array();
			$dates1 =array();
			$keywords1 =array();
			$doi1       = array();


			for($i = 0 ; $i < $count; $i++)
			{
				$link = $crawler->selectLink($headings[$i])->link();
				$subpage = $client->click($link);

				$abstract_selector = "div.abstract";
				$abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
				if(empty($abstract[$i]))
				{
					$abstract[$i] = array("Abstract not available");
				}

				$date_selector = "div#r_colR>div>div:nth-child(3)";
				$dates[$i] = $subpage->filter($date_selector)->each(function($node){return $node->text();});
				if(empty($dates[$i]))
				{
					$dates[$i] = array("N/A");
				}

				$keyword_selector = "div.keywords>a";
				$keywords[$i] = $subpage->filter($keyword_selector)->each(function($node){return $node->text();});
				if(empty($keywords[$i]))
				{
					$keywords[$i] = array($term);
				}

                //Selector for Authors
				$author_selector = "div.r_a>div:nth-child(1)";
				$authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();}); 
				if (empty($authors[$i])) 
				{
					$authors[$i] = array("N/A");
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
					$pos = strpos($key1, '20',1);
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
			for($i = 0; $i < $loop; $i++)
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


					else
					{
						//echo "You already crawled these keywords".$i."<br>";
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
					else
					{
						//echo "You already crawled these authors".$i."<br>";
					}

				}

				else
				{
					//echo "You already crawled this data".$i."<br>";
				}
			}
		}
	}

	public function acm($value)
	{

		$datess = $value;

		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$term1 = str_replace(' ', '%20%252B', $term);
		$term11 = str_replace(' ', '+', $term);

		$term2 = NotAvailAdvance::latest()->pluck('authors')->first();
		$term22 = str_replace(' ', '+', $term);
		$term3 = str_replace(' ', '%20%252B', $term2);
		if($datess=="")
		{
			if($term1=="")
			{
				$url="https://dl.acm.org/results.cfm?query=persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=&bfr=";
			}
			elseif($term3=="")
			{
				$url="https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")&within=owners.owner=HOSTED&filtered=&dte=&bfr=";
			}
			else
			{
				$url="https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")%20%20AND%20persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=&bfr=";
			}
		}
		elseif($datess=="2000-2010")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2000&bfr=2010";
			}
			elseif($term3=="" && $term1!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")&within=owners.owner=HOSTED&filtered=&dte=2000&bfr=2010";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://dl.acm.org/results.cfm?query=*&within=owners.owner=HOSTED&filtered=&dte=2000&bfr=2010";
			}
			else
			{
				$url="https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")%20%20AND%20persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2000&bfr=2010";
			}
		}
		elseif($datess=="2011-2015")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2011&bfr=2015";
			}
			elseif($term3=="" && $term1!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=cacmdlTitle:(%252B".$term1.")&within=owners.owner=HOSTED&filtered=&dte=2011&bfr=2015";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://dl.acm.org/results.cfm?query=*&within=owners.owner=HOSTED&filtered=&dte=2011&bfr=2015";
			}
			else
			{
				$url="https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")%20%20AND%20persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2011&bfr=2015";
			}
		}
		elseif($datess=="2016-2018")
		{
			if($term1=="" && $term3!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2016&bfr=2018";
			}
			elseif($term3=="" && $term1!="")
			{
				$url = "https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")&within=owners.owner=HOSTED&filtered=&dte=2016&bfr=2018";
			}
			elseif ($term1=="" && $term3=="") 
			{
				$url="https://dl.acm.org/results.cfm?query=*&within=owners.owner=HOSTED&filtered=&dte=2016&bfr=2018";
			}
			else
			{
				$url = "https://dl.acm.org/results.cfm?query=acmdlTitle:(%252B".$term1.")%20%20AND%20persons.authors.personName:(%252B".$term3.")&within=owners.owner=HOSTED&filtered=&dte=2016&bfr=2018";
			}
		}
        //CSS selector for urls and headings.
		$css_selector = "div.details>div.title>a";
		$client = new Client();
		$crawler = $client->request('GET', $url);
        //Selector for date
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
			if (count($headings)==0) 
			{
				return;
			}
			else
			{
            //Scrape Links
				$links= array();
				$links = $crawler->filter($css_selector)
				->each(function ($node) {
					return $node->attr('href');
				});

            //Scrape dates
				$dates= array();
				$dates = $crawler->filter($css_selector1)
				->each(function ($node) {
					return $node->text();
				});

            ////Arrays for Scraping         
				$abstract   = array();
				$authors    = array();

				$abstract_selector = "div.details>div.abstract"; 
				$abstract = $crawler->filter($abstract_selector)->each(function($node){return $node->text();});
            //Counter for loops.
				$counter = 0; 
				$j = 0;

				$count = count($headings);
            //dd($count);

				for($i = 0 ; $i < $count; $i++)
				{
					$link = $crawler->selectLink($headings[$i])->link();
					$subpage = $client->click($link);

                //Selector for Authors
					$author_selector = "div#divmain>table>tr>td>table>tr>td>a";
					$authors[$i] = $subpage->filter($author_selector)->each(function($node){return $node->text();});
					if(empty($authors[$i]))
					{
						$authors[$i] = array("N/A");
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
						$ResearchPaper->abstract = substr($abstract[$i],0,7000);
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

			}

		}
	}
	public function sciencedirect($value)
	{
		$datess = $value;
		$source = 'Science+Direct';
		$term = NotAvailAdvance::latest()->pluck('titles')->first();
		$term_keyword = str_replace(' ', '+', $term);
		$term1 = str_replace(' ', '%20', $term);
		$term2 = NotAvailAdvance::latest()->pluck('authors')->first();
		$term_author = str_replace(' ', '+', $term2);
		$term3 = str_replace(' ', '%20', $term2);
		$url = "https://www.sciencedirect.com/search/advanced?qs=".$term1."&date=".$datess."&authors=".$term3."&tak=".$term1."&show=25&sortBy=relevance";

	    //CSS selector for urls and headings.
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
			if (count($headings)==0) 
			{
				return;
			}
			else
			{
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
				->each(function ($node) {
					return $node->text();
				});
	            //Remove string in the date.
				$ind = 0;
				$date_list = array();
				foreach ($dates as $key)
				{
					$date_list[$ind] = str_replace("Available online ", "", $key);
					if(empty($date_list[$ind]))
					{
						$date_list[$ind] = array("N/A");
					}
					$ind++;
				}
	        //Arrays for Scraping         
				$abstract   = array();
				$authors    = array();
				$doi        = array();
				$keywords   = array();

	        //Arrays after Scraping and remove empty indexing and reindexing array.
				$emptyindex = array();
				$headings1  = array();
				$abstract1  = array();
				$authors1   = array();
				$links1     = array();
				$keywords1  = array();
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
					$abstract_selector = "div.Abstracts";
					$abstract[$i] = $subpage->filter($abstract_selector)->each(function($node){return $node->text();});
					if(empty($abstract[$i]))
					{
						$abstract[$i] = array("Abstract Not Available");
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
	            //Code for finding empty array in the scraped data
					if (empty($authors[$i])) 
					{
						$authors[$i] = array("N/A");
					}
				}
	        //Loop for remove empty rows.

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
	         //dd($keyword_list);

				$index1 = 0;
				$authors_list = array();
				foreach ($authors1 as $key) 
				{
					$authors_list[$index1] = $key;
					$index1++;                 
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
						$ResearchPaper->abstract = substr($abstarct_title[$i],0,7000);
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
	}
}
