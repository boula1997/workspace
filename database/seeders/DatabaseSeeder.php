<?php

namespace Database\Seeders;

use App\Http\Requests\Dashboard\VideoRequest;
use App\Models\Admin;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Team;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            FaqSeeder::class,
            ComplainSeeder::class,
            VaccancySeeder::class,
            MessagesSeeder::class,
            NewslettersSeeder::class,
            CountersSeeder::class,
            ContactsSeeder::class,
            GalleriesSeeder::class,
            PagesSeeder::class,
            PermissionTableSeeder::class,
            AccountantsSeeder::class,
            HistorysSeeder::class,
            CreateAdminUserSeeder::class,
            ProjectsSeeder::class,
            TasksSeeder::class,
            ProcessesSeeder::class,
            SettingSeeder::class,
            ServiceSeeder::class,
            FollowupsSeeder::class,
            PartnerSeeder::class,
            FeesSeeder::class,
            TeamSeeder::class,
            TestimonialsSeeder::class,
            ProductSeeder::class,
            CategorySeeder::class,
            UsersSeeder::class,
            VideosSeeder::class,


        ]);

    }
}
