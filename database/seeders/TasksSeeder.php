<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $title=["dummydata"];
        $status=[1]; 
       $employee=[1];
       $project=[1];
      

        for ($i = 0; $i < count($title); $i++) {
            $task = Task::create([
                 'title'=>$title[0],

                // 'status'=>$status[0],
                
                 'admin_id'=>$employee[0],
                
                 'project_id'=>$project[0],
            ]);
        }
    }
}
