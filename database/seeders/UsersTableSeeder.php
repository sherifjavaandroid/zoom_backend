<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin Account',
                'email' => 'admin@demo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$PXQZtHa6QTnz3LWYuAtBcuRTHquy5eZIOIKxLdTWBoZBc3RNYMijy',
                'remember_token' => NULL,
                'created_at' => '2020-12-28 11:14:31',
                'updated_at' => '2020-12-28 11:14:31',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Subscriber Account',
                'email' => 'subscriber@demo.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$PXQZtHa6QTnz3LWYuAtBcuRTHquy5eZIOIKxLdTWBoZBc3RNYMijy',
                'remember_token' => NULL,
                'created_at' => '2020-12-28 11:14:31',
                'updated_at' => '2020-12-28 11:14:31',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}