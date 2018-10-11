<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1 = User::all();
        
        DB::table('users')->truncate();
        //dd($data1);
        foreach($data1 as $user){
        DB::table('users')->insert(array(
              array('fname'=>$user->fname,'lname'=>$user->lname,'email'=>$user->email,'password'=>$user->password,'status'=>$user->status,'research_areas'=>$user->research_areas)

           ));
         }
         
    }
}
