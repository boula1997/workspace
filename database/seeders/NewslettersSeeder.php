<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewslettersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $email = ["ibrahimsamy308@gmail.com","Kero@gmail.com","ibrahim@gmail.com"];
      
      

        for ($i = 0; $i <3 ; $i++) {
            $newsletter = Newsletter::create([
           
                    'newsletter_email' => $email[$i],

                    
                
            ]);
        }
    }
}
