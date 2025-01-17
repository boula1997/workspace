<?php

namespace Database\Seeders;

use App\Models\History;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistorysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $task=[1];
        $employee=[1];
       $action=["dummydata"];
      

        for ($i = 0; $i < count($historys); $i++) {
            $history = History::create([
                 'task_id'=>$task[0],

                'employee_id'=>$employee[0],
                
                 'action'=>$action[0],
            ]);
        }
    }
}
