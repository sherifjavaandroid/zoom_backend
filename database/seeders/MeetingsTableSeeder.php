<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MeetingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('meetings')->delete();
        
        \DB::table('meetings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'meeting_id' => 'knkk3kk4nksd',
                'meeting_title' => 'First Meeting',
                'user_id' => 1,
                'created_at' => '2020-12-29 11:17:31',
                'updated_at' => '2020-12-29 11:17:31',
            ),
            1 => 
            array (
                'id' => 2,
                'meeting_id' => 'sdkn2kn4',
                'meeting_title' => 'sECOND Meeting',
                'user_id' => 1,
                'created_at' => '2020-12-29 11:17:42',
                'updated_at' => '2020-12-29 11:17:42',
            ),
        ));
        
        
    }
}