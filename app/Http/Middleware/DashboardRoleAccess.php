<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session; // Tambahkan ini!
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;

use App\Models\User;

class DashboardRoleAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");
        $role = Session::get("{$prefix}_role");

        if ($id_user) {
            if (Schema::hasTable('users')) {
                $user = User::where('id_user', $id_user)->get();
                View::share('profils', $user);
                App::instance('profils', $user); // optional

                if (!$user) {
                    return redirect()->route('logout');
                }
            }else{
                return redirect()->route('logout');
            }

            
           
        }else{
            return redirect()->route('logout');
        }

        return $next($request);
    }
}
