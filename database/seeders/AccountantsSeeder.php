<?php

namespace Database\Seeders;

use App\Models\Accountant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $received=[500];
        $employee=[1];
        $has=[500];
      

        for ($i = 0; $i < count($accountants); $i++) {
            $accountant = Accountant::create([
                 'received'=>$received[0],

                 'employee_id'=>$employee[0],
                
                 'has'=>$has[0],
            ]);
        }
    }
}
