<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'en' => [
                'appointment1' => ': 24/7',
                'copyright' => 'Copyright reserved by Blanko Tech © 2024',
                'title' => 'Blanko Tech',
                'address' => 'Online',
                'description' => 'We are a web development company specialized in creating, fixing and mangaing websites using latest technologies and web services',
                'meta_data' => 'Web Development Company',
            ],
            'ar' => [
                'appointment1' => ': 24/7',
                'copyright' => 'جميع الحقوق محفوظة لدي بلانكو تك © 2023 ',
                'title' => 'بلانكو تك',
                'address' => 'عبر الانترنت',
                'description' => 'نحن شركة تطوير لمواقع الويب متخصصون في انشاء,صيانة وادارة مواقع الويب',
                'meta_data' => 'شركة خدمات ويب',
            ],
            'logo' => 'images/v47eEip5Lddzad14CyZEdqNBCuHG7arjKK4sXlf8.png',
            'white_logo' => 'images/M8wYYa6zQnLin0iqw5wsCbXELXeJcY9duAPAcstX.png',
            'tab' => 'images/esrFDI9ill0bm0wxe2inrrQTirOIvGlpxP7Cj378.png',
            'image' => 'image',
            'last_time' => '2025-01-27 19:26:41',
            'tasks' => '',
            'map' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d55275.18948853619!2d31.18964315!3d30.016788299999998!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458469235579697%3A0x4e91d61f9878fc52!2sGiza%2C%20El%20Omraniya%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695471231297!5m2!1sen!2seg" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);
    }
}
