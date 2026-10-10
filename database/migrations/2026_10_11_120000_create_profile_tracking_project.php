<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Personal "Profile" project that profile.blanko.tech visits are logged against
 * (GET /api/clienttrack/profile/{action}), the same way the portfolio uses the "Portfolio" project.
 * Personal projects are hidden from normal project lists but counted in the stats tracks chart.
 */
return new class extends Migration
{
    public function up(): void
    {
        $columns = Schema::getColumnListing('projects');
        // "isPersonal" on MySQL; some Postgres copies have the column folded to lowercase.
        $personal = in_array('isPersonal', $columns, true) ? 'isPersonal' : 'ispersonal';

        if (DB::table('projects')->where('title', 'Profile')->where($personal, 1)->exists()) {
            return;
        }

        // Same settings as the existing Portfolio tracking project, when there is one.
        $template = DB::table('projects')->where('title', 'Portfolio')->where($personal, 1)->first();
        $row = $template ? (array) $template : ['cost' => 0, 'status' => 1];

        unset($row['id']);
        $row['title'] = 'Profile';
        $row[$personal] = 1;
        $row['created_at'] = now();
        $row['updated_at'] = now();

        DB::table('projects')->insert(array_intersect_key($row, array_flip($columns)));
    }

    public function down(): void
    {
        $personal = in_array('isPersonal', Schema::getColumnListing('projects'), true) ? 'isPersonal' : 'ispersonal';
        $id = DB::table('projects')->where('title', 'Profile')->where($personal, 1)->value('id');

        if ($id) {
            DB::table('clienttracks')->where('project_id', $id)->delete();
            DB::table('projects')->where('id', $id)->delete();
        }
    }
};
