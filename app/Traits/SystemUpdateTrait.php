<?php

namespace App\Traits;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait SystemUpdateTrait
{

    public function upgradeAppSystem()
    {
        //
        $appVersionCode = setting('appVerisonCode', "1");
        $appVerison = setting('appVerison', "1.0.0");


        //
        if ($appVersionCode <= 5) {

            if ($appVersionCode == 1) {

                $appVersionCode++;
                $appVerison = "1.0.1";

                //adding phone to users table
                if (!Schema::hasColumn('users', 'phone')) {
                    Schema::table('users', function (Blueprint $table) {
                        $table->string('phone')->nullable()->unique()->after('email');
                    });
                }
            }

            if ($appVersionCode == 2) {
                $appVersionCode++;
                $appVerison = "2.0.0";
            }

            if ($appVersionCode == 3) {
                $appVersionCode++;
                $appVerison = "2.1.0";
            }

            if ($appVersionCode == 4) {
                $appVersionCode++;
                $appVerison = "2.3.0";
            }

            if ($appVersionCode == 5) {
                $appVersionCode++;
                $appVerison = "2.4.0";
            }

            setting([
                'appVerisonCode' =>  $appVersionCode,
                'appVerison' =>  $appVerison,
            ])->save();
        } else {

            //
            $newVerisonCode = $appVersionCode + 1;
            $upgradeClassName = "App\\Upgrades\\Upgrade" . $newVerisonCode . "";
            if (!class_exists($upgradeClassName)) {
                $this->showSuccessAlert(__("System Updated Successfully!") . ". v" . $newVerisonCode . "");
                return;
            }
            $upgradeClass = new $upgradeClassName();
            $upgradeClass->run();
            $upgradeClass->update();
        }


        $this->showSuccessAlert("System Updated Successfully!");
    }

    public function systemTerminalRun($command)
    {

        $commandArray = explode(" ", $command);
        $composerInstall = new Process($commandArray);
        $composerInstall->setWorkingDirectory(base_path());
        $composerInstall->run();

        if (!$composerInstall->isSuccessful()) {
            throw new ProcessFailedException($composerInstall);
        }
    }
}
