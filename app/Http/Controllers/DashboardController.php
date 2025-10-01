<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $prefix = config('session.prefix');
        $role = session($prefix.'_role');
        $id_user = session($prefix.'_id_user');

        $data['title'] = 'Dashboard';
        $data['subtitle'] = 'Halaman utama admin';

        $bar = [];
        $tgl = [];
        $grafik = [];
        $cnt_admin = 0;
        $cnt_member = 0;

        $user = User::where('status', 'Y')->where('deleted', 'N')->get();

        if ($user && $user->isNotEmpty()) {
            foreach ($user as $u) {
                if ($u->role == 1) {
                    $cnt_admin++;
                } else {
                    $cnt_member++;
                }
            }
        }

        $endDate = Carbon::today();
        $startDate = Carbon::today()->subDays(6);

        $data['cnt_admin']  = $cnt_admin;
        $data['cnt_member'] = $cnt_member;

        return view('admin.dashboard.index', $data);
    }

    public function contact()
    {
        $data['title'] = 'Daftar Kontak';
        $data['subtitle'] = 'Manajemen Kontak';

        return view('admin.dashboard.contact', $data);
    }

    public function report()
    {
        $data['title'] = 'Daftar Pelaporan';
        $data['subtitle'] = 'Manajemen Pelaporan';

        return view('admin.dashboard.report', $data);
    }

    public function cetak_laporan(Request $request)
    {
        $type = $request->input('type');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = Report::query()
            ->select('reports.*')
            ->join('users', 'users.id_user', '=', 'reports.id_user')
            ->join('categories', 'categories.id_category', '=', 'reports.id_category')
            ->with(['user', 'category']);

        if (!empty($start_date)) {
            $query->whereDate('reports.date', '>=', $start_date);
        }
        if (!empty($end_date)) {
            $query->whereDate('reports.date', '<=', $end_date);
        }

        $result = $query->get();
        $data = [];

        if ($result) {
            foreach ($result as $item) {
                $data[] = [
                    $item->user->name,
                    $item->user->email,
                    $item->category->name,
                    $item->name_1,
                    $item->name_2,
                    $item->place,
                    date('H:i',strtotime($item->time)),
                    date('Y-m-d', strtotime($item->date)),
                    date('Y-m-d H:i', strtotime($item->created_at)),
                ];
            }
        }

        $headings = [
            'Nama Pelapor',
            'Email Pelapor',
            'Kategori',
            'Terlapor 1',
            'Terlapor 2',
            'Tempat Kejadian',
            'Waktu Kejadian',
            'Tanggal Peristiwa',
            'Tanggal Pelaporan'
        ];

        $extname = '';
        if ($start_date || $end_date) {
            if (!$end_date && $start_date) {
                $extname .= '-setelah';
            }
        }
        if ($start_date) {
           $extname .= '-' . date('d-m-Y', strtotime($start_date));
        } else {
            if ($end_date) {
               $extname .= '-sebelum';
            }
        }
        if ($end_date) {
           $extname .= '-' . date('d-m-Y', strtotime($end_date));
        }

        if ($type == 'pdf') {
            return cetak_pdf('data-pelaporan' . $extname, $headings, $data, 'table', 'landscape');
        } else {
            return cetak_excel('data-pelaporan' . $extname, $headings, $data);
        }
    }

    public function detail_pengaduan(Request $request)
    {
        $id = $request->input('id');
        $result = Report::with(['user', 'category'])->find($id);
        $bukti = ReportDetail::where('id_report', $id)->get();

        $data['result'] = $result;
        $data['bukti'] = $bukti;
        return view('admin.dashboard.modal.detail', $data);
    }

    public function profile()
    {
        // PARAMETER
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // SET TITLE
        $data['title'] = 'Profile';
        $data['subtitle'] = 'Personal biodata management';

        // GET DATA
        $result = User::where('id_user', $id_user)->where('deleted','N')->first();

        // SET DATA
        $data['result'] = $result;
        return view('admin.dashboard.profile',$data);
    }

    public function updateProfile(Request $request)
    {
        $arrVar = [
            'name' => 'Full name'
        ];

        $post = [];
        $arrAccess = [];
        $data = ['required' => []];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value cannot be empty!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        // Jika ada input yang kosong, return error
        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');
        $name_image = $request->name_image;
        $result = User::where('id_user', $id_user)->first();

        if (!in_array(false, $arrAccess)) {
            $tujuan = public_path('data/user/');
            if (!File::exists($tujuan)) {
                File::makeDirectory($tujuan, 0755, true, true);
            }
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move($tujuan, $fileName);
                
                if ($result->image && file_exists($tujuan . $result->image)) {
                    unlink($tujuan . $result->image);
                }
                
                $post['image'] = $fileName;
                session([
                    "{$prefix}_image"  => $fileName
                ]);
            } elseif (!$name_image) {
                if ($result->image && file_exists($tujuan . $result->image)) {
                    unlink($tujuan . $result->image);
                }
                $post['image'] = null;
            }

            $update = $result->update($post);
            if ($update) {
                session([
                    "{$prefix}_name"  => $post['name']
                ]);
                return response()->json(['status' => true, 'alert' => ['message' => 'profile changed successfully'], 'reload' => true]);
            } else {
                return response()->json(['status' => false, 'alert' => ['message' => 'profile failed to change']]);
            }
        }

        return response()->json(['status' => false]);
    }

    public function updateEmail(Request $request)
    {
        // Ambil data dari input
        $email = strtolower($request->email);
        $password = $request->password;
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");

        // Validasi input
        if (!$email || !$password) {
            return response()->json(['status' => 700, 'message' => 'No data detected! Please enter data']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Invalid email! Please enter a valid email']);
        }

        // Cek user berdasarkan email
        $mail = User::where('email', $email)->where('id_user','!=',$id_user)->where('deleted','N')->first();
        $user = User::where('id_user',$id_user)->first();
        if ($email == $user->email) {
            return response()->json(['status' => 700, 'message' => 'No email changes detected']);
        }

        if (!$mail) {

            // Cek password
            if (Hash::check($password, $user->password)) {
                session([
                    "{$prefix}_email"  => $email
                ]);
                $user->email = $email;
                $user->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'You have successfully changed your email!'
                ]);
            } else {
                return response()->json(['status' => 500, 'message' => 'Incorrect password! Please enter the correct password.']);
            }
        } else {
            return response()->json(['status' => 500, 'message' => 'Email already registered in the system!']);
        }
    }

    public function updatePassword(Request $request)
    {
        // Ambil data dari input
        $currentpassword = $request->currentpassword;
        $newpassword = $request->newpassword;
        $confirmpassword = $request->confirmpassword;
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");

        // Validasi input
        if (!$confirmpassword || !$newpassword || !$currentpassword) {
            return response()->json(['status' => 700, 'message' => 'No data detected! Please enter data']);
        }


        $user = User::where('id_user',$id_user)->first();
        // Cek password
        if (Hash::check($currentpassword, $user->password)) {
            if ($newpassword === $confirmpassword) {
                $user->password = $newpassword;
                $user->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'You have successfully changed your password!'
                ]);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'new password confirmation does not match'
                ]);
            }
            
        } else {
            return response()->json(['status' => 500, 'message' => 'Incorrect password! Please enter the correct password.']);
        }
    }

    public function accountDeactivated(Request $request)
    {
        $prefix = config('session.prefix');
        $id_user = Session::get("{$prefix}_id_user");

        $user = User::where('id_user',$id_user)->first();
        $user->status = 'N';
        $user->reason = 'you have deactivated your account';
        $user->blocked_date = now();
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Your account has been deactivated.',
            'redirect' => route('logout')
        ]);
    }
}
