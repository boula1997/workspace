<?php

namespace Database\Seeders;

use App\Models\Clienttrack;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClienttracksSeeder extends Seeder
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
            $clienttrack = Clienttrack::create([
                    'name' => $name[$i],
                    'email' => $email[$i],
                    'password' =>Hash::make($pass[$i]),
                    
             
            ]);
        }
    }
}
