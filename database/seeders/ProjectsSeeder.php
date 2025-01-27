<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $title=["dummydata"];
        $status=[1]; 
        $cost=[500]; 
        $script=["script"]; 

        for ($i = 0; $i < count($title); $i++) {
            $project = Project::create([
                'title'=>$title[0],
                'cost'=>$cost[0],
                'status'=>$status[0],
                'script'=>$script[0],
            ]);
        }
    }
}
