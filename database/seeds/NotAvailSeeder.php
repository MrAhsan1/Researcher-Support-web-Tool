<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\NotAvailable;
class NotAvailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data1 = NotAvailable::all();
         DB::table('not_availables')->truncate();
         //insert some dummy records
         foreach($data1 as $user){
         DB::table('not_availables')->insert(array(
             array('search_keywords'=>$user->search_keywords)
          ));
    }
    }
}
