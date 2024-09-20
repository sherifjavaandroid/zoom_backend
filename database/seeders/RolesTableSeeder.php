<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => '2020-12-28 11:57:58',
                'updated_at' => '2020-12-28 11:57:58',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'subscriber',
                'guard_name' => 'web',
                'created_at' => '2020-12-28 11:57:58',
                'updated_at' => '2020-12-28 11:57:58',
            ),
        ));
        
        
    }
}