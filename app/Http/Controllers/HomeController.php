<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use App\ResearchPapers;
use DB;
use View;
use App\NotAvailable;
use App\Keyword;
use Route;
use App\NotAvailAdvance;
use App\User;
use Session;
use Redirect;

class HomeController extends Controller
{
  public $in = 0;
  public $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";

  public function latestpapers()
  {
    $re=ResearchPapers::limit(5)->orderby('created_at','asc')->get();
    return $re;
  }
  public function index()
  { 
     $term = "Science";
     $paper = ResearchPapers::get()->count();
     $ingenta  = DB::table('research_papers')->where('websites','=','Ingenta')->get()->count();
     $pubmed  = DB::table('research_papers')->where('websites','=','Pubmed')->get()->count();
     $science  = DB::table('research_papers')->where('websites','=','Science Direct')->get()->count();
     $eric  = DB::table('research_papers')->where('websites','=','Eric')->get()->count();
     $acm  = DB::table('research_papers')->where('websites','=','ACM')->get()->count();
     $users = User::get()->count();
     return View::make('index')->with('paper',$paper)
     ->with('users',$users)
     ->with('acm',$acm)
     ->with('eric',$eric)
     ->with('pubmed',$pubmed)
     ->with('ingenta',$ingenta)
     ->with('science',$science);
  }
  //All repositories show
  public function repositoriespapers($d)
  {
    $latestpaper = $this->latestpapers();
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower($d).'%')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
    ->paginate(10);
    return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
 //Research Areas
  public function ShowResearchAreas($d)
  { 
      $researchpapers = DB::table('keywords')
      ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
      ->join('authors','authors.researchpaper_id','=','research_papers.id')
      ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
      ->orwhereRaw("MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)",array($d))
      ->orwhere(strtolower('research_papers.research_areas'),'LIKE','%'.strtolower($d).'%')
      ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);      
      return $researchpapers;
  }
  public function datamining()
  {
      $latestpaper = $this->latestpapers();
      $d="Data Mining";
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function machine()
  {
      $latestpaper = $this->latestpapers();
      $d="Machine Learning";
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function recommend()
  {
      $d="Recommendation System";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function artificial()
  {
      $d="Artificial Intelligence";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function database()
  {
      $d="Database Management System";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function cv()
  {
      $d="Computer Vision";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function rfid()
  {
    $d="RFID";
    $latestpaper = $this->latestpapers();
    $researchpapers = $this->ShowResearchAreas($d);
    return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function iot()
  {
      $d="Internet of Things";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function image()
  {
      $d="Image Processing";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
  public function nlp()
  {
      $d="Natural Language Processing";
      $latestpaper = $this->latestpapers();
      $researchpapers = $this->ShowResearchAreas($d);
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
  }
    //end of Show Reasearch Areas
  public function SimpleSearch($term)
  {
    $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
    $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw("MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)",array($term))
      ->orwhere(strtolower('research_papers.abstract'),'LIKE','%'.strtolower($term).'%');
    })
    ->orwhere(strtolower('keywords.keywords'),'LIKE','%'.strtolower($term).'%')
    ->orwhere(strtolower('authors.authors'),'LIKE','%'.strtolower($term).'%')
    ->orderbyRaw($match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
    ->paginate(10);
    session()->forget('m');                  
    session()->forget('terms');                  
    return $researchpapers;
  }
    
    //Simple Search
  public function search(Request $request)
  {
    $latestpaper = $this->latestpapers();
    $term = $request['search'];
    if(session()->get('m')==1)
    {
      $term1 = session()->get('terms');
      $researchpapers = $this->SimpleSearch($term1);
      if ($researchpapers->isEmpty()) 
      {
        $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
        return View::make('ResearchPapers.papersmessage')->with('message',$message)
        ->with('latestpaper',$latestpaper);
      }
      else
      {
        return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
        ->with('latestpaper',$latestpaper);
      }
    }
    if ($term == "") 
    {
      $message = "Search field cannot be empty.";
      return View::make('ResearchPapers.papersmessage')->with('message',$message)
      ->with('latestpaper',$latestpaper);
    }

    $researchpapers = $this->SimpleSearch($term);

    if($researchpapers->isEmpty()) 
    {
      NotAvailable::truncate();
      $notavail = new NotAvailable();
      $notavail->search_keywords = $term;
      $notavail->save();

      return redirect()->route('notavail');   
    }
    else
    {
      return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
      ->with('latestpaper',$latestpaper);
    }   
   
  }
//end Simple Search

//Store in Db Not Available
  public function StoreNotAvial($term,$term1,$term2)
  {
    NotAvailAdvance::truncate();
    $notavail = new NotAvailAdvance();
    $notavail->titles = $term;
    $notavail->authors = $term1;
    $notavail->dates = $term2;
    $notavail->save();
  }
//Advanced Search
  public function advancesearch(Request $request)
  {
    $latestpaper = $this->latestpapers();
    $term = $request['s'];
    $term1 = $request['authors'];
    $term2 = $request->get('date');
    $term3 = $request['science'];
    $term4 = $request['eric'];
    $term5 = $request['acm'];
    $term6 = $request['pubmed'];

    $count_copy = session()->get('m');
    $date_copy = session()->get('date');
    $term_copy = session()->get('term');
    $author_copy = session()->get('author');

    $science_class = new Science;
    $eric_class = new Eric;
    $pubmed_class = new Pubmed;
    $acm_class = new Acm;
    $se_class = new ScienceEric;
    $sa_class = new ScienceAcm;
    $spub_class = new SciencePubmed;
    $ericacm_class = new EricAcm;
    $ericpub_class = new EricPubmed;
    $acmpub_class = new AcmPubmed;
    $sciericacm_class = new SciEricAcm;
    $sciericpub_class = new SciEricPub;
    $sciacmpub_class = new SciAcmPub;
    $ericacmpub_class = new EricAcmPub;
    $sciericacmpub_class = new SciEricAcmPub;
    $nosciericacmpub_class = new NoSciEricAcmPub;
    
    if ($term1==null && $term==null && $term2==null) 
    {
      $message = "All fields cannot be empty";
      return View::make('ResearchPapers.papersmessage')->with('message',$message)->with('latestpaper',$latestpaper);
    }
    if($term ==null) {$term="";}
    if($term1==null){$term1="";}
    if($term2==null){$term2="";}

    //Only Science Direct
    if (($term3!=null && $term4==null && $term5==null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->scienceEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->scienceEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $science_class->science2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $science_class->science2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only ERIC
    elseif (($term3==null && $term4!=null && $term5==null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->ericEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->ericEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $eric_class->eric2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $eric_class->eric2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeric')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only PUBMED
    elseif (($term3==null && $term4==null && $term5==null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmedEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmedEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $pubmed_class->pubmed2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $pubmed_class->pubmed2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('frompubmed')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only ACM
    elseif (($term3==null && $term4==null && $term5!=null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acmEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acmEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acm_class->acm2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acm_class->acm2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromacm')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only Science Direct with Eric
    elseif (($term3!=null && $term4!=null && $term5==null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->seEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->seEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $se_class->se2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $se_class->se2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromse')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
     //Only Science Direct with Acm
    elseif (($term3!=null && $term4==null && $term5!=null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->saEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->saEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sa_class->sa2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sa_class->sa2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsa')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only Science Direct with Pubmed
    elseif (($term3!=null && $term4==null && $term5==null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $spub_class->spub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $spub_class->spub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsp')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only Eric with ACM
    elseif (($term3==null && $term4!=null && $term5!=null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacmEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacmEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacm_class->ericacm2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacm_class->ericacm2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only Eric with Pubmed
    elseif (($term3==null && $term4!=null && $term5==null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericpub_class->ericpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericpub_class->ericpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Only Acm with Pubmed
    elseif (($term3==null && $term4==null && $term5!=null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $acmpub_class->acmpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $acmpub_class->acmpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Science with Eric and Acm
    elseif (($term3!=null && $term4!=null && $term5!=null && $term6==null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacmEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacm_class->sciericacm2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacm_class->sciericacm2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsea')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Science with Eric and Pubmed
    elseif (($term3!=null && $term4!=null && $term5==null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericpub_class->sciericpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericpub_class->sciericpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsep')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Science with Acm and Pubmed
    elseif (($term3!=null && $term4==null && $term5!=null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciacmpub_class->sciacmpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciacmpub_class->sciacmpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromsap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    //Eric with Acm and Pubmed
    elseif (($term3!=null && $term4==null && $term5!=null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $ericacmpub_class->ericacmpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $ericacmpub_class->ericacmpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromeap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    // Science Eric with Acm and Pubmed
    elseif (($term3!=null && $term4!=null && $term5!=null && $term6!=null))
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $sciericacmpub_class->sciericacmpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $sciericacmpub_class->sciericacmpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromseap')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
    // All Empty
    else
    {
      if ($term2=="") 
      {
        if ($term1=="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty1($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty1($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty2($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmpty2($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2000-2010') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2010($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2010($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2010($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2010($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2010();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2010();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2010Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2010Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2011-2015') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2015($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2015($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2015($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2015($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2015();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2015();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2015Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2015Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
      elseif ($term2=='2016-2018') 
      {
        if ($term1=="" && $term!="") 
        {
         if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2018($term_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyAuthor2018($term);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          } 
        }
        elseif ($term=="" && $term1!="") 
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2018($author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpubEmptyKeyword2018($term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        elseif($term=="" && $term1=="")
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2018();
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2018();
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
        else
        {
          if ($count_copy == 1) 
          {
            $researchpapers = $nosciericacmpub_class->sciericacmpub2018Full($term_copy,$author_copy);
            if ($researchpapers->isEmpty()) 
            {
              $message = "Sorry No Paper Found for this query Please check your Searching Keyword.";
              return View::make('ResearchPapers.papersmessage')->with('message',$message)
              ->with('latestpaper',$latestpaper);
            }
            else
            {
              return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)
              ->with('latestpaper',$latestpaper);
            }
          }
          $researchpapers = $nosciericacmpub_class->sciericacmpub2018Full($term,$term1);
          if($researchpapers->isEmpty())
          {
            $this->StoreNotAvial($term,$term1,$term2);
            return redirect()->route('fromscience')->with(['date' => $term2]);
          }
          else
          {
            return View::make('ResearchPapers.showpapers')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
          }
        }
      }
    }
  }
}
class Science
{
  public $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function scienceEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function scienceEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function scienceEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function scienceEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function scienceEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function science2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function science2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function scienceEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function scienceEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function science2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function science2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function scienceEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function scienceEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function science2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function science2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class Eric
{
  public $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function ericEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function ericEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function ericEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function eric2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function eric2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function ericEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function ericEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function eric2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function eric2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function ericEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function ericEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function eric2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function eric2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class Pubmed
{
  public $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function pubmedEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function pubmedEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function pubmedEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function pubmedEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function pubmedEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function pubmed2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function pubmed2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function pubmedEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function pubmedEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function pubmed2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function pubmed2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function pubmedEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function pubmedEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function pubmed2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function pubmed2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class Acm
{
  public $match = "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function acmEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function acmEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function acmEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function acmEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function acmEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function acm2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function acm2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function acmEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function acmEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function acm2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function acm2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function acmEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function acmEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function acm2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function acm2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class ScienceEric
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function seEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function seEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function seEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function seEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function seEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function se2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function se2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function seEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function seEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function se2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function se2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function seEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function seEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function se2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function se2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class ScienceAcm
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function saEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function saEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function saEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function saEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function saEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sa2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sa2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function saEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function saEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sa2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sa2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function saEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function saEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sa2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sa2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class SciencePubmed
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function spubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function spubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function spubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function spubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function spubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function spub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function spub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function spubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function spubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function spub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function spub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function spubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function spubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function spub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function spub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class EricAcm
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function ericacmEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericacmEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function ericacmEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function ericacmEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericacmEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function ericacm2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function ericacm2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function ericacmEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function ericacmEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function ericacm2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function ericacm2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function ericacmEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function ericacmEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function ericacm2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function ericacm2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class EricPubmed
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function ericpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function ericpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function ericpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function ericpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function ericpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function ericpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function ericpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function ericpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function ericpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function ericpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function ericpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function ericpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function ericpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class AcmPubmed
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function acmpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function acmpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function acmpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function acmpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function acmpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function acmpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function acmpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function acmpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function acmpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function acmpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function acmpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function acmpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function acmpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function acmpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function acmpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class SciEricAcm
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function sciericacmEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function sciericacmEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function sciericacmEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sciericacm2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sciericacm2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function sciericacmEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function sciericacmEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sciericacm2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sciericacm2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function sciericacmEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function sciericacmEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sciericacm2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sciericacm2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class SciEricPub
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function sciericpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function sciericpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function sciericpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sciericpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sciericpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function sciericpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function sciericpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sciericpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sciericpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function sciericpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function sciericpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sciericpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sciericpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class SciAcmPub
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function sciacmpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciacmpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function sciacmpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function sciacmpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciacmpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sciacmpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sciacmpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function sciacmpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function sciacmpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sciacmpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sciacmpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function sciacmpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function sciacmpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sciacmpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sciacmpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class EricAcmPub
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function ericacmpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericacmpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function ericacmpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function ericacmpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function ericacmpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function ericacmpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function ericacmpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function ericacmpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function ericacmpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function ericacmpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function ericacmpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function ericacmpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function ericacmpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function ericacmpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function ericacmpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class SciEricAcmPub
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function sciericacmpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function sciericacmpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function sciericacmpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sciericacmpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sciericacmpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function sciericacmpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function sciericacmpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sciericacmpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sciericacmpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function sciericacmpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function sciericacmpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sciericacmpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sciericacmpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}
class NoSciEricAcmPub
{
  public $match =  "MATCH(authors.authors) AGAINST(? IN BOOLEAN MODE)";
  public $match1 = "MATCH(keywords.keywords) AGAINST(? IN BOOLEAN MODE)";
  public $match2 = "MATCH(research_papers.title) AGAINST(? IN BOOLEAN MODE)";
  public $match3 = "MATCH(research_papers.abstract) AGAINST(? IN BOOLEAN MODE)";
  //for Scince direct empty_date and keyword 
  public function sciericacmpubEmpty($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmpubEmpty1($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct only empty_date 
  public function sciericacmpubEmpty2($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 and empty keyword 
  public function sciericacmpubEmptyKeyword2010($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct empty_date and Author 
  public function sciericacmpubEmptyAuthor2010($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2010 only emty keyword and author 
  public function sciericacmpub2010()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2010 Full
  public function sciericacmpub2010Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2000".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2001".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2002".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2003".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2004".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2005".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2006".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2007".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2008".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2009".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2010".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
 //for Scince direct 2011-2015 and empty keyword 
  public function sciericacmpubEmptyKeyword2015($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015  and empty Author 
  public function sciericacmpubEmptyAuthor2015($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2011-2015 only empty keyword and author 
  public function sciericacmpub2015()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2015 Full
  public function sciericacmpub2015Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2011".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2012".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2013".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2014".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2015".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 and empty keyword 
  public function sciericacmpubEmptyKeyword2018($term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match."DESC",array($term1))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018  and empty Author 
  public function sciericacmpubEmptyAuthor2018($term)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
  //for Scince direct 2016-2018 only empty keyword and author 
  public function sciericacmpub2018()
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }

  //for Scince direct 2016-2018 Full
  public function sciericacmpub2018Full($term,$term1)
  {
    $researchpapers = DB::table('keywords')
    ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
    ->join('authors','authors.researchpaper_id','=','research_papers.id')
    ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
    ->whereRaw($this->match,array($term1))
    ->where(function($query) use ($term)
    {
      $query->whereRaw($this->match1,array($term))
      ->orwhereRaw($this->match2,array($term))
      ->orwhereRaw($this->match3,array($term));
    })
    ->where(function($query)
    {
      $query->where(strtolower('research_papers.dates'),'LIKE','%'."2016".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2017".'%')
      ->orwhere(strtolower('research_papers.dates'),'LIKE','%'."2018".'%');
    })
    ->where(function($query)
    {
       $query->where(strtolower('research_papers.websites'),'LIKE','%'.strtolower('pubmed').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('acm').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('eric').'%')
      ->orwhere(strtolower('research_papers.websites'),'LIKE','%'.strtolower('science direct').'%');
    })
    ->orderbyRaw($this->match2."DESC",array($term))
    ->orderby('dates','desc')
    ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')
      ->paginate(10);
      session()->forget('m');
      return $researchpapers;
  }
}