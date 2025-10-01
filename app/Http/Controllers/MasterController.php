<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

use App\Models\User;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Facility;
use App\Models\Language;
use App\Models\FacilityDetail;

use Mavinoo\Batch\BatchFacade as Batch;

class MasterController extends Controller
{
    // GET VIEW
    public function user()
    {
        $data['title'] = 'Master User';
        $data['subtitle'] = 'Manajemen pelapor atau user website';
        return view('admin.master.user', $data);
    }

    public function product()
    {
        $data['title'] = 'Master Produk';
        $data['subtitle'] = 'Manajemen Produk';
        return view('admin.master.product', $data);
    }

    public function insert_product()
    {
        $data['title'] = 'Tambah Produk';
        $data['subtitle'] = 'Tambah Produk';
        return view('admin.master.insert_product', $data);
    }

     public function location()
    {
        $data['title'] = 'Manajemen Lokasi';
        $data['subtitle'] = 'Manajemen konten Lokasi';
        return view('admin.master.location', $data);
    }

    public function unit()
    {
        $data['title'] = 'Manajemen Unit';
        $data['subtitle'] = 'Manajemen konten Unit';
        return view('admin.master.unit', $data);
    }

    public function type()
    {
        $data['title'] = 'Manajemen Tipe';
        $data['subtitle'] = 'Manajemen konten Tipe';
        return view('admin.master.type', $data);
    }

    public function facility()
    {
        $data['title'] = 'Manajemen Fasilitas';
        $data['subtitle'] = 'Manajemen konten Fasilitas';
        return view('admin.master.facility', $data);
    }


    // USER
    public function insert_user(Request $request)
    {
        $arrVar = [
            'name' => 'Nama lengkap',
            'email' => 'Alamat email',
            'phone' => 'Nomor telepon',
            'password' => 'Kata sandi',
            'repassword' => 'Konfirmasi kata sandi',
            'role' => 'Peran'
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                if (!in_array($var, ['password', 'repassword'])) {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $tujuan = public_path('data/user/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Alamat email tidak valid!']
            ]);
        }

        if (User::where('email', $request->email)->where('deleted', 'N')->exists()) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Alamat email sudah terdaftar!']
            ]);
        }

        if ($request->password !== $request->repassword) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Konfirmasi kata sandi tidak cocok!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $page = 'user';
        if ($role == 1) {
            $page = "admin";
        }

        $post['password'] = $request->password;
        $post['created_by'] = $id_user;

        $insert = User::create($post);

        if ($insert) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil ditambahkan!'],
                'datatable' => 'table_' . $page,
                'modal' => ['id' => '#kt_modal_' . $page, 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal menambahkan data!']
            ]);
        }
    }

    public function update_user(Request $request)
    {
        $id = $request->id_user;
        $user = User::where('id_user', $id)->where('deleted', 'N')->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'User tidak ditemukan!']
            ]);
        }

        $arrVar = [
            'name' => 'Nama lengkap',
            'phone' => 'Nomor telepon',
            'email' => 'Alamat email',
            'role' => 'Peran'
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Alamat email tidak valid!']
            ]);
        }

        if (User::where('email', $request->email)->where('id_user', '!=', $id)->where('deleted', 'N')->exists()) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Alamat email sudah digunakan oleh pengguna lain!']
            ]);
        }

        if ($request->filled('password')) {
            if ($request->password !== $request->repassword) {
                return response()->json([
                    'status' => false,
                    'alert' => ['message' => 'Konfirmasi kata sandi tidak cocok!']
                ]);
            }
            $post['password'] = $request->password;
        }

        $tujuan = public_path('data/user/');
        $name_image = $request->name_image;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($user->image && file_exists($tujuan . $user->image)) {
                unlink($tujuan . $user->image);
            }

            $post['image'] = $fileName;
        } elseif (!$name_image) {
            if ($user->image && file_exists($tujuan . $user->image)) {
                unlink($tujuan . $user->image);
            }
            $post['image'] = null;
        }

        $page = 'user';
        if ($role == 1) {
            $page = "admin";
        }

        $update = $user->update($post);

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil diperbarui!'],
                'datatable' => 'table_' . $page,
                'modal' => ['id' => '#kt_modal_' . $page, 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal memperbarui data!']
            ]);
        }

        return response()->json(['status' => false]);
    }



    
    // POST LOCATION
    public function insert_location(Request $request)
    {
        $arrVar = [
            'name' => 'Nama lokasi',
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['created_by'] = $id_user;

        $insert = Location::create($post);

        if ($insert) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil ditambahkan!'],
                'datatable' => 'table_location',
                'modal' => ['id' => '#kt_modal_location', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal menambahkan data!']
            ]);
        }
    }

    public function update_location(Request $request)
    {
        $id = $request->id_location;
        $location = Location::where('id_location', $id)->first();

        if (!$location) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'location tidak ditemukan!']
            ]);
        }

        $arrVar = [
            'name' => 'Nama lokasi'
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
        $update = $location->update($post);

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil diperbarui!'],
                'datatable' => 'table_location',
                'modal' => ['id' => '#kt_modal_location', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal memperbarui data!']
            ]);
        }

        return response()->json(['status' => false]);
    }



    // POST FACILITY
    public function insert_facility(Request $request)
    {
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'name_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Nama Fasilitas <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        $tujuan = public_path('data/facility/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Icon tidak boleh kosong!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['created_by'] = $id_user;

        $insert = Facility::create($post);

        if ($insert) {
            $post2 = [];
            if ($language->isNotEmpty()) {
                foreach ($language as $key) {
                    $name = 'name_'.$key->id_language;
                    
                    $post2[] = [
                        'id_facility' => $insert->id_facility,
                        'id_language' => $key->id_language,
                        'name' => $$name
                    ];
                }

                $insert->details()->insert($post2);
            }
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil ditambahkan!'],
                'reload' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal menambahkan data!']
            ]);
        }
    }

    public function update_facility(Request $request)
    {
        $id = $request->id_facility;
        $facility = Facility::where('id_facility', $id)->first();

        if (!$facility) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'facility tidak ditemukan!']
            ]);
        }
        
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $button = $request->input('button','N');

        $language = Language::where('status','Y')->get();
        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'name_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Nama Fasilitas <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }


        $tujuan = public_path('data/facility/');
        $name_image = $request->name_image;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($facility->image && file_exists($tujuan . $facility->image)) {
                unlink($tujuan . $facility->image);
            }

            $post['image'] = $fileName;
        } elseif ($name_image) {
            if (!$facility->image || !file_exists($tujuan . $facility->image)) {
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Icon tidak boleh kosong!']
                ]);
            }
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Icon tidak boleh kosong!']
            ]);
        }

        $update = $facility->update($post);

        if ($update) {
            $post2 = [];

            $dtl = FacilityDetail::where('id_facility', $facility->id_facility)->get();

            if ($dtl->isNotEmpty()) {
                foreach ($dtl as $key) {
                    $post2[] = [
                        'id_facility_detail' => $key->id_facility_detail,
                        'id_language'      => $key->id_language,
                        'name'      => request('name_' . $key->id_language)
                    ];
                }

                Batch::update(new FacilityDetail, $post2, 'id_facility_detail');
            }
            
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil diperbarui!'],
                'reload' => true
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal memperbarui data!']
            ]);
        }

        return response()->json(['status' => false]);
    }



     // ORNAMEN
    public function modal_facility(Request $request)
    {
        $id = $request->input('id');

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();

        // SET DATA
        $data['language'] = $language;
        $result = null;
        if ($id) {
            $result = Facility::with(['details'])->find($id);
        }


        $data['result'] = $result;
        return view('admin.master.modal.form_facility',$data);
    }



    // POST UNIT
    public function insert_unit(Request $request)
    {
        $arrVar = [
            'name' => 'Nama unit',
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['created_by'] = $id_user;

        $insert = Unit::create($post);

        if ($insert) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil ditambahkan!'],
                'datatable' => 'table_unit',
                'modal' => ['id' => '#kt_modal_unit', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal menambahkan data!']
            ]);
        }
    }

    public function update_unit(Request $request)
    {
        $id = $request->id_unit;
        $unit = Unit::where('id_unit', $id)->first();

        if (!$unit) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'unit tidak ditemukan!']
            ]);
        }

        $arrVar = [
            'name' => 'Nama unit'
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
        $update = $unit->update($post);

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil diperbarui!'],
                'datatable' => 'table_unit',
                'modal' => ['id' => '#kt_modal_unit', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal memperbarui data!']
            ]);
        }

        return response()->json(['status' => false]);
    }




    // POST TYPE
    public function insert_type(Request $request)
    {
        $arrVar = [
            'name' => 'Nama tipe',
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['created_by'] = $id_user;

        $insert = Type::create($post);

        if ($insert) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil ditambahkan!'],
                'datatable' => 'table_type',
                'modal' => ['id' => '#kt_modal_type', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal menambahkan data!']
            ]);
        }
    }

    public function update_type(Request $request)
    {
        $id = $request->id_type;
        $type = Type::where('id_type', $id)->first();

        if (!$type) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'type tidak ditemukan!']
            ]);
        }

        $arrVar = [
            'name' => 'Nama tipe'
        ];

        $post = [];
        $arrAccess = [];
        $data = [];

        foreach ($arrVar as $var => $value) {
            $$var = $request->input($var);
            if (!$$var) {
                $data['required'][] = ['req_' . $var, "$value tidak boleh kosong!"];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        if (in_array(false, $arrAccess)) {
            return response()->json(['status' => false, 'required' => $data['required']]);
        }
        $update = $type->update($post);

        if ($update) {
            return response()->json([
                'status' => true,
                'alert' => ['message' => 'Data berhasil diperbarui!'],
                'datatable' => 'table_type',
                'modal' => ['id' => '#kt_modal_type', 'action' => 'hide'],
                'input' => ['all' => true]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Gagal memperbarui data!']
            ]);
        }

        return response()->json(['status' => false]);
    }
}
