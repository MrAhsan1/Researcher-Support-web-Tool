<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use App\User;
use App\ResearchPapers;
use App\Notifications\PaperNotification;
use DB;
use Auth;
use App\CheckNotifications;
use View;

class NotificationController extends Controller
{
  public $check;
  public function showpapers(Request $request, $id,$id1)
  {
    if(Auth::guest())
      {
        return View::make('auth.login');
      }
      else
      {
        $latestpaper = ResearchPapers::limit(5)->orderby('created_at','asc')->get();
        $researchpapers = DB::table('keywords')
        ->join('research_papers','keywords.researchpaper_id','=','research_papers.id')
        ->join('authors','authors.researchpaper_id','=','research_papers.id')
        ->leftjoin('favorite_models','favorite_models.researchpaper_id','=','research_papers.id')
        ->where(strtolower('keywords.researchpaper_id'),'=',$id)
        ->select('research_papers.id','research_papers.title','research_papers.dates','research_papers.abstract','research_papers.paperlinks','authors.authors','keywords.keywords','research_papers.doi','favorite_models.researchpaper_id','research_papers.websites')->get();
        if(count($request->user()->unreadNotifications->where('id',$id1)->first())==0)
        {
          return View::make('ResearchPapers.showbyid')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
        }
        else
        {
         $request->user()->unreadNotifications->where('id',$id1)->first()->markAsRead();
         return View::make('ResearchPapers.showbyid')->with('researchpapers',$researchpapers)->with('latestpaper',$latestpaper);
       }
     }
     
   }
   public function read(Request $request)
   {
     $request->user()->unreadNotifications->markAsRead();
     return redirect()->back(); 
   }

   public function markoneRead(Request $request, $id)
   {
    $notification = $request->user()
    ->unreadNotifications
    ->where('id', $id)
    ->first()
    ->markAsRead();
    return redirect()->back();   
    
  }
  public function query()
  {
    $user = User::all();
    $research_areas1 = $user->pluck('research_areas');
    $count = count($research_areas1);
    
    for ($i=0; $i < $count ; $i++) 
    { 
      $user_area[$i] = explode(',', $research_areas1[$i]);
    }
    
    for($i=0; $i<$count; $i++)
    {
      $count1 = count($user_area[$i]);
      for ($j=0; $j < $count1 ; $j++) 
      { 
        $paper[$i][$j] = DB::table('research_papers')
        ->where(strtolower('research_areas'),'LIKE','%'.strtolower($user_area[$i][$j]).'%')->orderBy('created_at', 'DESC')->limit(1)->get();
        $paper_user[$i][$j] = DB::table('users')
        ->where(strtolower('research_areas'),'LIKE','%'.strtolower($user_area[$i][$j]).'%')->get();
        
      }

    }
    for ($i=0; $i <$count ; $i++) 
    { 
      $count1 = count($user_area[$i]);
      for ($j=0; $j < $count1 ; $j++) 
      { 
        foreach ($paper[$i][$j] as $key) {
          $simple[$i][$j] =$key;
        }
      }
      
    }
    for ($i=0; $i <$count; $i++) { 
      $count1 = count($user_area[$i]);
      for ($j=0; $j < $count1 ; $j++) 
      {   
        $count2 = count($paper_user[$i][$j]);
        
        if ($count2 == 1) 
        {
          foreach ($paper_user[$i][$j] as $key) {
            $simple1[$i][$j] =$key;
          }
        }
        else
        {
          for ($k=0; $k < $count2; $k++) 
          { 
                      //foreach ( as $key) 
            {
              $simple1[$i][$j][$k] =$paper_user[$i][$j][$k];
            }  
          }
        }
        
      }
    }
    for ($index=0; $index < $count; $index++) 
    {  
      $count1 = count($user_area[$index]);
      for ($j=0; $j < $count1 ; $j++) 
      { 
        $count2 = count($paper_user[$index][$j]);
        if ($count2 == 1) 
        {
         
          $this->checkduplication($simple1[$index][$j]->id,$simple[$index][$j]->id); 
          if ($this->check=="store") 
          {
                    User::find($simple1[$index][$j]->id)->notify(new PaperNotification($simple[$index][$j]));           	# code...
                  }             
                  
                }
                else
                {
                  for ($k=0; $k < $count2 ; $k++) 
                  { 
                    
                   
                   $this->checkduplication($simple1[$index][$j][$k]->id,$simple[$index][$j]->id);
                   if($this->check=="store")
                   {
                    User::find($simple1[$index][$j][$k]->id)->notify(new PaperNotification($simple[$index][$j]));
                  }
                }
              }

              
            }
            
          }
          
          return response()->json("Successfully Add Notification");
        }
        
        public function checkduplication($simple1,$simple)
        {
         $duplicate = CheckNotifications::where('user_id', $simple1)->where('researchpaper_id', $simple)->get();
         $count = count($duplicate);
         if($count == 0)
         {
          $this->check = "store";
          $checknotify = new CheckNotifications();
          $checknotify->user_id = $simple1;
          $checknotify->researchpaper_id = $simple;
          $checknotify->save();
        }
        else
        {
          $check = "notstore";
        }
      }
    }
