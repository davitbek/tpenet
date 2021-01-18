<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MetaGroupMetaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('meta_group_meta')->delete();

        \DB::table('meta_group_meta')->insert(array (
            0 =>
            array (
                'id' => 23,
                'meta_id' => 30,
                'meta_group_id' => 1,
                'default_content' => '',
            ),
            1 =>
            array (
                'id' => 24,
                'meta_id' => 31,
                'meta_group_id' => 1,
                'default_content' => '',
            ),
            2 =>
            array (
                'id' => 26,
                'meta_id' => 33,
                'meta_group_id' => 1,
                'default_content' => '',
            ),
            3 =>
            array (
                'id' => 28,
                'meta_id' => 35,
                'meta_group_id' => 1,
                'default_content' => '',
            ),
            4 =>
            array (
                'id' => 29,
                'meta_id' => 36,
                'meta_group_id' => 1,
                'default_content' => '',
            ),
            5 =>
            array (
                'id' => 30,
                'meta_id' => 37,
                'meta_group_id' => 4,
                'default_content' => '',
            ),
            6 =>
            array (
                'id' => 31,
                'meta_id' => 38,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            7 =>
            array (
                'id' => 32,
                'meta_id' => 39,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            8 =>
            array (
                'id' => 33,
                'meta_id' => 40,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            9 =>
            array (
                'id' => 34,
                'meta_id' => 41,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            10 =>
            array (
                'id' => 35,
                'meta_id' => 41,
                'meta_group_id' => 5,
                'default_content' => '',
            ),
            11 =>
            array (
                'id' => 36,
                'meta_id' => 42,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            12 =>
            array (
                'id' => 37,
                'meta_id' => 43,
                'meta_group_id' => 2,
                'default_content' => '',
            ),
            13 =>
            array (
                'id' => 38,
                'meta_id' => 44,
                'meta_group_id' => 3,
                'default_content' => '',
            ),
            14 =>
            array (
                'id' => 39,
                'meta_id' => 45,
                'meta_group_id' => 3,
                'default_content' => '',
            ),
            15 =>
            array (
                'id' => 40,
                'meta_id' => 46,
                'meta_group_id' => 3,
                'default_content' => '',
            ),
            16 =>
            array (
                'id' => 41,
                'meta_id' => 47,
                'meta_group_id' => 3,
                'default_content' => '',
            ),
            17 =>
            array (
                'id' => 42,
                'meta_id' => 48,
                'meta_group_id' => 5,
                'default_content' => '',
            ),
        ));
    }
}
