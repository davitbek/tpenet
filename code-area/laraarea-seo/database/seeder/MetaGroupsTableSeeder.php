<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MetaGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('meta_groups')->delete();

        \DB::table('meta_groups')->insert(array (
            0 =>
            array (
                'id' => 1,
                'is_active' => 1,
                'starts_with' => 'og:',
                'headline' => 'Open Graph',
                'comment_start' => 'Open Graph start',
                'comment_end' => 'Open Graph end',
                'created_at' => '2019-07-03 17:18:06',
                'updated_at' => '2019-09-24 00:14:53',
                'deleted_at' => NULL,
            ),
            1 =>
            array (
                'id' => 2,
                'is_active' => 1,
                'starts_with' => 'twitter:',
                'headline' => 'Twitter',
                'comment_start' => 'Twitter start',
                'comment_end' => 'Twitter end',
                'created_at' => '2019-07-03 17:18:17',
                'updated_at' => '2019-09-24 00:14:53',
                'deleted_at' => NULL,
            ),
            2 =>
            array (
                'id' => 3,
                'is_active' => 1,
                'starts_with' => 'dcterms.',
                'headline' => 'Dublin Core',
                'comment_start' => 'Dublin Core start',
                'comment_end' => 'Dublin Core end',
                'created_at' => '2019-07-04 11:47:09',
                'updated_at' => '2019-09-24 00:14:53',
                'deleted_at' => NULL,
            ),
            3 =>
            array (
                'id' => 4,
                'is_active' => 1,
                'starts_with' => 'fb:',
                'headline' => 'Facebook',
                'comment_start' => 'Facebook start',
                'comment_end' => 'Facebook end',
                'created_at' => '2019-07-04 12:15:38',
                'updated_at' => '2019-09-24 00:14:53',
                'deleted_at' => NULL,
            ),
            4 =>
            array (
                'id' => 5,
                'is_active' => 1,
                'starts_with' => 'apple-mobile-web-app-',
                'headline' => 'Apple',
                'comment_start' => 'Apple start',
                'comment_end' => 'Apple end',
                'created_at' => '2019-07-17 17:52:54',
                'updated_at' => '2019-09-24 00:14:53',
                'deleted_at' => NULL,
            ),
            5 =>
            array (
                'id' => 6,
                'is_active' => 1,
                'starts_with' => 'link',
                'headline' => 'Links',
                'comment_start' => 'Links start',
                'comment_end' => 'Links end',
                'created_at' => '2019-09-24 12:45:39',
                'updated_at' => '2019-09-24 12:45:39',
                'deleted_at' => NULL,
            ),
        ));


    }
}
