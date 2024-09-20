<?php

namespace App\Upgrades;

use Illuminate\Support\Facades\Schema;

class Upgrade7 extends BaseUpgrade
{

    public $versionName = "2.5.0";
    //Runs or migrations to be done on this version
    public function run()
    {
        //check if table has expires_at
        $columnExists = Schema::hasColumn('personal_access_tokens', "expires_at");
        if (!$columnExists) {
            //
            Schema::table('personal_access_tokens', function ($table) {
                $table->timestamp('expires_at')->nullable()->after('last_used_at');
            });
        }
    }
}
