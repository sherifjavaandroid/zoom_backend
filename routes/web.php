<?php

use App\Http\Livewire\HomeLivewire;
use App\Http\Livewire\Auth\LoginLivewire;
use App\Http\Livewire\Auth\PasswordResetLivewire;
use App\Http\Livewire\Auth\ForgotPasswordLivewire;
use App\Http\Livewire\Auth\RegisterLivewire;
use App\Http\Livewire\HistoryLivewire;
use App\Http\Livewire\DashboardLivewire;
use App\Http\Livewire\MeetingsLivewire;
use App\Http\Livewire\MeetingLivewire;
use App\Http\Livewire\NewMeetingLivewire;
use App\Http\Livewire\LoungeLivewire;
use App\Http\Livewire\UserLivewire;
use App\Http\Livewire\BackUpLivewire;
use App\Http\Livewire\SettingsLivewire;
use App\Http\Livewire\PrivacySettingsLivewire;
use App\Http\Livewire\UpgradeLivewire;
use App\Http\Livewire\NotificationLivewire;
use App\Http\Livewire\ProfileLivewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use League\CommonMark\CommonMarkConverter;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web']], function () {

    //home page
    Route::get('', HomeLivewire::class)->name('home');

    // Auth
    Route::get('login', LoginLivewire::class)->name('login');
    Route::get('logout', function () {
        Auth::logout();
        return redirect()->route('home');
    })->name('logout');

    Route::get('password/forgot', ForgotPasswordLivewire::class)->name('password.forgot');
    Route::get('password/update/{code}/{email}', PasswordResetLivewire::class)->name('password.reset.link');
    Route::get('register', RegisterLivewire::class)->name('register');
    Route::get('meeting/{code}', MeetingLivewire::class)->name('meeting.join');

    // Pages
    Route::get('privacy/policy', function () {
        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $html = $converter->convert(setting('privacyPolicy', ""));
        return view('layouts.pages.privacy', compact('html'));
    })->name('privacy');

    // AUth routes
    Route::group(['middleware' => ['auth']], function () {

        //
        Route::get('new/meeting', NewMeetingLivewire::class)->name('meeting.new');
        Route::get('lounge', LoungeLivewire::class)->name('lounge');
        Route::get('history', HistoryLivewire::class)->name('history');
        Route::get('profile', ProfileLivewire::class)->name('profile');

        Route::group(['middleware' => ['role:admin']], function () {
            Route::get('dashboard', DashboardLivewire::class)->name('dashboard');
            Route::get('meetings', MeetingsLivewire::class)->name('meetings');
            Route::get('users', UserLivewire::class)->name('users');
            Route::get('backup', BackUpLivewire::class)->name('backups');

            //
            Route::get('settings', SettingsLivewire::class)->name('settings');
            Route::get('settings/privacy', PrivacySettingsLivewire::class)->name('settings.privacy');
            Route::get('notification/send', NotificationLivewire::class)->name('notification.send');
            Route::get('upgrade', UpgradeLivewire::class)->name('upgrade');
        });
    });
});
