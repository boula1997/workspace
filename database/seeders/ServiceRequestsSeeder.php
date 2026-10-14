<?php

namespace Database\Seeders;

use App\Models\ServiceRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        $name = ["Ibrahim Samy","Kero Boula","ابراهيم سامى"];
        $email = ["ibrahimsamy308@gmail.com","Kero@gmail.com","ibrahim@gmail.com"];
        $Phone = ["01289189890","0124578960","450015885"];
        $serviceRequest = ["ًكيفيه عمل موقع بتكلفه اقل","كيفيه استخدام الموقع","ًWe upload websites for free"];
      
      

        for ($i = 0; $i <3 ; $i++) {
            $serviceRequest = ServiceRequest::create([
           
                    'name' => $name[$i],
                    'email' => $email[$i],
                    'phone' => $Phone[$i],
                    'service_request'=>$serviceRequest[$i],
                    
                
            ]);
        }
    }
}
