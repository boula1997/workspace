<?php

namespace Database\Seeders;

use App\Models\Issue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IssuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      
        $name= ["Ibrahim Samy","Keroles Fouad","?????????????? ????????"];
        $email = ["ibrahimsamy308@gmail.com","Kero@gmail.com","ibrahim@gmail.com"];
        $pass = ["123456789","123456789","0125458952"];
    
        for ($i = 0; $i < 3; $i++) {
            $issue = Issue::create([
                    'name' => $name[$i],
                    'email' => $email[$i],
                    'password' =>Hash::make($pass[$i]),
                    
             
            ]);
        }
    }
}
