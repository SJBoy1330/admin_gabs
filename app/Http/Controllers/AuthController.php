<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Facades\Session;



class AuthController extends Controller
{
    public function index()
    {
        $data['title'] = 'Login';
        return view('auth.index',$data);
    }


    public function loginProses(Request $request)
    {
        // Ambil data dari input
        $email = strtolower($request->email);
        $password = $request->password;

        // Validasi input
        if (!$email || !$password) {
            return response()->json(['status' => 700, 'message' => 'Tidak ada data terdeteksi! Silahkan cek data']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Alamat email tidak valid! Cek format email']);
        }

        // Cek user berdasarkan email
        $user = User::where('email', $email)->where('deleted','N')->first();

        if ($user) {
            // Cek apakah user diblokir
            if ($user->status == 'N') {
                $reason = $user->reason ? ' dengan alasan </br></br><b>"' . $user->reason . '!"</b></br></br>' : '!';
                return response()->json(['status' => 700, 'message' => 'Akses kamu terhadap sistem dimatikan' . $reason . ' Hubungi admin jika terjadi kesalahan.']);

            }

            // Cek password
            if (Hash::check($password, $user->password)) {
                // Set session Laravel
                Auth::login($user);
                $prefix = config('session.prefix');
                $st['last_login'] = date('Y-m-d H:i:s');
                $user->update($st);

                // Simpan session
                Session::put([
                    "{$prefix}_id_user"  => $user->id_user,
                    "{$prefix}_id_role"  => $user->id_role,
                    "{$prefix}_name"     => $user->name,
                    "{$prefix}_email"    => $user->email,
                    "{$prefix}_phone"    => $user->phone,
                    "{$prefix}_image"    => $user->image,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Anda berhasil masuk ke sistem! Selamat datang ' . $user->name,
                    'redirect' => url('/dashboard')
                ]);
            } else {
                return response()->json(['status' => 500, 'message' => 'Kata sandi tidak valid! Silahkan coba lagi.']);
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'Alamat email tidak terdaftar didalam sistem!']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        Session::flush(); // Hapus semua session

        return redirect('/admin');
    }
}
