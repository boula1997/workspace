<?php

namespace Database\Seeders;

use App\Models\Followup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FollowupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $title=["dummydata"];
        $status=[1]; 
       $employee=[1];
       $difficulty=[1];
       $hasPhone=[1];
      

        for ($i = 0; $i < count($title); $i++) {
            $followup = Followup::create([
                 'title'=>$title[0],

               'status'=>$status[0],
                
                 'employee_id'=>$employee[0],
                
                 'difficulty'=>$difficulty[0],
                 'hasPhone'=>$hasPhone[0],
            ]);
        }
    }
}
