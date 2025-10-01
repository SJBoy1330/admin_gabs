<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

use App\Models\Sosmed;
use App\Models\WebPhone;
use App\Models\WebEmail;
use App\Models\Language;

class UserRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): mixed
    {
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");
        $role = Session::get("{$prefix}_role");

        if (Schema::hasTable('sosmeds') && Schema::hasTable('sosmed_setting')) {
            $sosmed = Sosmed::select([
                'sosmeds.*',
                DB::raw("(SELECT url FROM sosmed_setting WHERE sosmed_setting.id_sosmed = sosmeds.id_sosmed AND sosmed_setting.id_setting = 1 LIMIT 1) as url"),
                DB::raw("(SELECT name FROM sosmed_setting WHERE sosmed_setting.id_sosmed = sosmeds.id_sosmed AND sosmed_setting.id_setting = 1 LIMIT 1) as name_sosmed"),
            ])->get();

            View::share('sosmed', $sosmed);
            App::instance('sosmed', $sosmed); // optional
        }

        if (Schema::hasTable('web_phone')) {
            $web_phone = WebPhone::where('id_setting', 1)->get();
            View::share('web_phone', $web_phone);
            App::instance('web_phone', $web_phone); // optional
        }

        if (Schema::hasTable('web_email')) {
            $web_email = WebEmail::where('id_setting', 1)->get();
            View::share('web_email', $web_email);
            App::instance('web_email', $web_email); // optional
        }

        if (Schema::hasTable('languages')) {
            $language = Language::get();
            View::share('language', $language);
            App::instance('language', $language); // optional
        }

        


        

        if ($id_user) {
            return redirect('/dashboard');
        }

        return $next($request);
    }

}
