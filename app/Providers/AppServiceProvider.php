<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // Tambahkan ini
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\Setting;
use App\Models\User;
use App\Models\Language;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {

        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");


        require_once app_path('Helpers/globals.php');

        // Cek apakah tabel 'settings' sudah ada sebelum mengaksesnya
        if (Schema::hasTable('settings')) {
            // Ambil data setting dari tabel settings where id_setting = 1
            $settings = Setting::where('id_setting', 1)->first();
            
            // Share variable $setting ke semua view
            View::share('setting', $settings);

            // Simpan setting di container aplikasi
            $this->app->singleton('setting', function () use ($settings) {
                return $settings;
            });
        }

        if (!$lang) {
            if (Schema::hasTable('languages')) {
                
                $language = Language::where('status', 'Y')->where('default','Y')->first();
                Session::put([
                    "{$prefix}_lang"  => $language->id_language,
                    "{$prefix}_lang_code"  => $language->code
                ]);

            }
        }

       
    }
}
