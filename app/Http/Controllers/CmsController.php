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
use App\Models\Language;
use App\Models\Banner;
use App\Models\BannerDetail;
use App\Models\About;
use App\Models\Setting;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Facility;
use App\Models\Project;
use App\Models\FacilityDetail;
use App\Models\ProjectFacility;
use App\Models\ProjectDetail;
use App\Models\ProjectGallery;
use App\Models\ProjectGalleryDetail;
use App\Models\Article;
use App\Models\ArticleDetail;


use Mavinoo\Batch\BatchFacade as Batch;

class CmsController extends Controller
{
    // GET VIEW
    public function banner()
    {
        $data['title'] = 'Manajemen Banner';
        $data['subtitle'] = 'Manajemen konten Banner';
        return view('admin.cms.banner', $data);
    }

    public function project()
    {
        $data['title'] = 'Manajemen Proyek';
        $data['subtitle'] = 'Manajemen konten Proyek';
        return view('admin.cms.project', $data);
    }

    public function article()
    {
        $data['title'] = 'Manajemen Artikel';
        $data['subtitle'] = 'Manajemen konten Artikel';
        return view('admin.cms.article', $data);
    }

    public function gallery(Request $request,$id = null)
    {
        if (!$id) {
            return redirect()->route('cms.project');
        }
        $data['title'] = 'Galeri Proyek';
        $data['subtitle'] = 'Kumpulan konten Galeri Proyek';

        // GET DATA
        $result = Project::find($id);
        if (!$result) {
            return redirect()->route('cms.project');
        }
        $gallery = ProjectGallery::with(['details'])->where('id_project',$id)->get();
        $language = Language::orderBy('default', 'ASC')->get();

        $data['result'] = $result;
        $data['gallery'] = $gallery;
        $data['id_project'] = $id;
        $data['language'] = $language;
        
        return view('admin.cms.gallery', $data);
    }

    public function about()
    {
        // SET TITLE
        $data['title'] = 'Manajemen Tentang Website';
        $data['subtitle'] = 'Manajemen konten deskripsi tentang website';

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();
        $abt = About::get();
        $about = [];
        if ($abt->isNotEmpty()) {
            foreach ($abt as $key) {
                $about[$key->id_language]['about_1'] = $key->about_1;
                $about[$key->id_language]['about_2'] = $key->about_2;
            }
        }

        // SET DATA
        $data['language'] = $language;
        $data['about'] = $about;

        return view('admin.cms.about', $data);
    }


    // ORNAMEN
    public function modal_banner(Request $request)
    {
        $id = $request->input('id');

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();

        // SET DATA
        $data['language'] = $language;
        $result = null;
        if ($id) {
            $result = Banner::with(['details'])->find($id);
        }


        $data['result'] = $result;
        return view('admin.cms.modal.form_banner',$data);
    }

    public function modal_article(Request $request)
    {
        $id = $request->input('id');

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();

        // SET DATA
        $data['language'] = $language;
        $result = null;
        if ($id) {
            $result = Article::with(['details'])->find($id);
        }


        $data['result'] = $result;
        return view('admin.cms.modal.form_article',$data);
    }

    public function modal_project(Request $request)
    {
        $id = $request->input('id');

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();
        $default_lang = '';
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                if ($key->default == 'Y') {
                    $default_lang = $key->name;
                }
            }
        }
        $type = Type::orderBy('created_at', 'ASC')->get();
        $location = Location::orderBy('created_at', 'ASC')->get();

        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");
        $facility = FacilityDetail::with('facility')->where('id_language',$lang)->get();
        $unit = Unit::orderBy('created_at', 'ASC')->get();

        // SET DATA
        $data['language'] = $language;
        $data['type'] = $type;
        $data['unit'] = $unit;
        $data['location'] = $location;
        $data['facility'] = $facility;
        $result = null;
        $profas = null;
        if ($id) {
            $result = Project::with(['details','facilities'])->find($id);
            $pro = ProjectFacility::where('id_project',$id)->get();
            if ($pro) {
                foreach ($pro as $key) {
                    $profas[$key->id_facility][$key->id_language] = $key->description;
                }
            }
        }


        $data['result'] = $result;
        $data['profas'] = $profas;
        $data['default_lang'] = $default_lang;
        return view('admin.cms.modal.form_project',$data);
    }

     // ORNAMEN
    public function modal_gallery(Request $request)
    {
        $id = $request->input('id');

        // GET DATA
        $language = Language::orderBy('default', 'ASC')->get();

        // SET DATA
        $data['language'] = $language;
        $result = null;
        if ($id) {
            $result = ProjectGallery::with(['details'])->find($id);
        }


        $data['result'] = $result;
        return view('admin.cms.modal.form_gallery',$data);
    }




    // POST BANNER
    public function insert_banner(Request $request)
    {
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $button = $request->input('button','N');

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'description_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            if ($button == 'Y') {
                foreach ($language as $key) {
                    $var = 'name_button_'.$key->id_language;
                    $$var = $request->input($var);
                    if (!$$var) {
                        return response()->json([
                            'status' => false,
                            'alert' => ['message' => 'Nama Tombol <b>('.$key->name.')</b> Tidak boleh kosong!']
                        ]);
                    }
                }

                foreach ($language as $key) {
                    $var = 'name_link_'.$key->id_language;
                    $$var = $request->input($var);
                    if (!$$var) {
                        return response()->json([
                            'status' => false,
                            'alert' => ['message' => 'Url Tombol <b>('.$key->name.')</b> Tidak boleh kosong!']
                        ]);
                    }
                }
            }
            
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        $tujuan = public_path('data/banner/');
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
                'alert' => ['message' => 'Gambar banner tidak boleh kosong!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['button'] = $button;
        $post['created_by'] = $id_user;

        $insert = Banner::create($post);

        if ($insert) {
            $post2 = [];
            if ($language->isNotEmpty()) {
                foreach ($language as $key) {
                    $desc = 'description_'.$key->id_language;
                    $nb = 'name_button_'.$key->id_language;
                    $nl = 'name_link_'.$key->id_language;
                    $post2[] = [
                        'id_banner' => $insert->id_banner,
                        'id_language' => $key->id_language,
                        'description' => $$desc,
                        'name_button' => (isset($$nb)) ? $$nb : null,
                        'name_link' => (isset($$nl)) ? $$nl : null
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

    public function update_banner(Request $request)
    {
        $id = $request->id_banner;
        $banner = Banner::where('id_banner', $id)->first();

        if (!$banner) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Banner tidak ditemukan!']
            ]);
        }
        
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $button = $request->input('button','N');

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'description_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            if ($button == 'Y') {
                foreach ($language as $key) {
                    $var = 'name_button_'.$key->id_language;
                    $$var = $request->input($var);
                    if (!$$var) {
                        return response()->json([
                            'status' => false,
                            'alert' => ['message' => 'Nama Tombol <b>('.$key->name.')</b> Tidak boleh kosong!']
                        ]);
                    }
                }

                foreach ($language as $key) {
                    $var = 'name_link_'.$key->id_language;
                    $$var = $request->input($var);
                    if (!$$var) {
                        return response()->json([
                            'status' => false,
                            'alert' => ['message' => 'Url Tombol <b>('.$key->name.')</b> Tidak boleh kosong!']
                        ]);
                    }
                }
            }
            
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        $tujuan = public_path('data/banner/');
        $name_image = $request->name_image;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($banner->image && file_exists($tujuan . $banner->image)) {
                unlink($tujuan . $banner->image);
            }

            $post['image'] = $fileName;
        } elseif ($name_image) {
            if (!$banner->image || !file_exists($tujuan . $banner->image)) {
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Gambar banner tidak boleh kosong!']
                ]);
            }
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gambar banner tidak boleh kosong!']
            ]);
        }

        $post['button'] = $button;
        $update = $banner->update($post);

        if ($update) {
            $post2 = [];

            $dtl = BannerDetail::where('id_banner', $banner->id_banner)->get();

            if ($dtl->isNotEmpty()) {
                foreach ($dtl as $key) {
                    $post2[] = [
                        'id_banner_detail' => $key->id_banner_detail,
                        'id_language'      => $key->id_language,
                        'description'      => request('description_' . $key->id_language),
                        'name_button'      => request('name_button_' . $key->id_language, null),
                        'name_link'        => request('name_link_' . $key->id_language, null),
                    ];
                }

                Batch::update(new BannerDetail, $post2, 'id_banner_detail');
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



    // POST ABOUT
    public function update_about_1(Request $request)
    {
        $post = [];
        $post2 = [];
        $language = Language::where('status','Y')->get();

        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'about_1_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi <b>('.$key->name.')</b> about halaman home Tidak boleh kosong!']
                    ]);
                }
            }
        }
        

        $tujuan = public_path('data/setting/');
        $setting = Setting::find(1);
        $name_image_about = $request->name_image_about;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image_about')) {
            $image_about = $request->file('image_about');
            $fileName = uniqid() . '.' . $image_about->getClientOriginalExtension();
            $image_about->move($tujuan, $fileName);

            if ($setting->image_about && file_exists($tujuan . $setting->image_about)) {
                unlink($tujuan . $setting->image_about);
            }

            $post['image_about'] = $fileName;
        } elseif ($name_image_about) {
            if (!$setting->image_about || !file_exists($tujuan . $setting->image_about)) {
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Gambar tidak boleh kosong!']
                ]);
            }
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gambar tidak boleh kosong!']
            ]);
        }

        if ($language->isNotEmpty()) {
            $arrAccess = [];
            foreach ($language as $key) {
                $about = About::where('id_language',$key->id_language)->first();
                $txt = 'about_1_'.$key->id_language;
                $post2['about_1'] = $$txt;
                $post2['id_language'] = $key->id_language;
                if ($about) {
                    $update = $about->update($post2);
                    if ($update) {
                        $arrAccess[] = true;
                    }else{
                        $arrAccess[] = false;
                    }
                }else{
                    $insert = About::create($post2);
                    if ($insert) {
                        $arrAccess[] = true;
                    }else{
                        $arrAccess[] = false;
                    }
                }
            }

            if (empty($arrAccess) || !in_array(FALSE,$arrAccess)) {
                if (!empty($post)) {
                    $setting->update($post);
                }
                
                return response()->json([
                    'status' => 200,
                    'alert' => ['message' => 'Berhasil melaukan perubahan pada about halaman home!'],
                    'reload' => true
                ]);
            }else{
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Gagal melakukan perubahan! Silahkan cek atau hubungi developer']
                ]);
            }
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Sistem invalid! Coba lagi nanti atau hubungi developer']
            ]);
        }


    }


    public function update_about_2(Request $request)
    {
        $languages = Language::where('status', 'Y')->get();

        if ($languages->isEmpty()) {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Sistem invalid! Coba lagi nanti atau hubungi developer']
            ]);
        }

        $arrAccess = [];

        foreach ($languages as $lang) {
            $inputName = 'about_2_' . $lang->id_language;
            $content = $request->input($inputName);

            // Cek apakah CKEditor kosong
            if (empty(ckeditor_check($content))) {
                return response()->json([
                    'status' => false,
                    'alert' => ['message' => 'Deskripsi <b>(' . $lang->name . ')</b> about halaman about tidak boleh kosong!']
                ]);
            }

            // Update atau create data About
            $aboutData = [
                'about_2' => $content,
                'id_language' => $lang->id_language
            ];

            try {
                $about = About::updateOrCreate(
                    ['id_language' => $lang->id_language],
                    ['about_2' => $content]
                );
                $arrAccess[] = $about ? true : false;
            } catch (\Exception $e) {
                \Log::error('Update About gagal: '.$e->getMessage());
                $arrAccess[] = false;
            }
        }

        // Cek hasil
        if (!in_array(false, $arrAccess, true)) {
            return response()->json([
                'status' => 200,
                'alert' => ['message' => 'Berhasil melakukan perubahan about pada halaman about!'],
                'reload' => true
            ]);
        } else {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gagal melakukan perubahan! Silahkan cek atau hubungi developer']
            ]);
        }
    }


    // POST PROJECT

    public function insert_project(Request $request)
    {
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $arrVar = [
            'name' => 'Nama proyek',
            'id_unit' => 'Unit',
            'id_location' => 'Lokasi',
            'id_type' => 'Tipe',
            'price' => 'Harga',
            'address' => 'Alamat'
        ];

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
        $language = Language::where('status','Y')->get();
        $id_facility = $request->input('id_facility',[]);
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'specification_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    $data['required'][] = ['req_' . $var, "Spesifikasi ($key->name) tidak boleh kosong!"];
                    $arrAccess[] = false;
                }else{
                    $arrAccess[] = true;
                }
            }

            if (!empty($id_facility)) {
                foreach ($id_facility as $id) {
                    foreach ($language as $key) {
                        $var = 'description_'.$id.'_'.$key->id_language;
                        $$var = $request->input($var);
                        if (!$$var) {
                            $data['required'][] = ['req_' . $var, "Deskripsi ($key->name) tidak boleh kosong!"];
                            $arrAccess[] = false;
                        }else{
                            $arrAccess[] = true;
                        }
                    }
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        if (in_array(false, $arrAccess)) {
            return response()->json([
                'status' => false, 
                'alert' => ['message' => 'Periksa kembali form anda! Pastikan semua field telah terisi'],
                'required' => $data['required']]);
        }

        $tujuan = public_path('data/project/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        $stock = $request->input('stock');
        if ($stock < 0) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Stok tidak boleh kurang dari 0']
            ]);
        }else{
            $post['stock'] = $stock;
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);
            $post['image'] = $fileName;
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gambar proyek tidak boleh kosong!']
            ]);
        }

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if (!$lat || !$lng) {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Tandai lokasi pada peta terlebih dahulu!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        
        $post['created_by'] = $id_user;
        $post['lat'] = $lat;
        $post['lng'] = $lng;

        $insert = Project::create($post);

        if ($insert) {
            $post2 = [];
            if ($language->isNotEmpty()) {
                foreach ($language as $key) {
                    $spec = 'specification_'.$key->id_language;
                    $post2[] = [
                        'id_project' => $insert->id_project,
                        'id_language' => $key->id_language,
                        'specification' => $$spec
                    ];
                }

                if (!empty($id_facility)) {
                    $post3 = [];
                    foreach ($id_facility as $id) {
                        foreach ($language as $key) {
                            $spec = 'description_'.$id.'_'.$key->id_language;
                            if ($$spec) {
                                $post3[] = [
                                    'id_project' => $insert->id_project,
                                    'id_language' => $key->id_language,
                                    'id_facility' => $id,
                                    'description' => $$spec
                                ];
                            }
                        }
                    }
                    $insert->facilities()->insert($post3);
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

    public function update_project(Request $request)
    {
        $id = $request->id_project;
        $project = Project::where('id_project', $id)->first();

        if (!$project) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Project tidak ditemukan!']
            ]);
        }

        $post = [];
        $arrAccess = [];
        $data = [];

        $arrVar = [
            'name' => 'Nama proyek',
            'id_unit' => 'Unit',
            'id_location' => 'Lokasi',
            'id_type' => 'Tipe',
            'price' => 'Harga',
            'address' => 'Alamat'
        ];

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

        $language = Language::where('status', 'Y')->get();
        
        $id_facility = $request->input('id_facility', []);

        

        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'specification_' . $key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    $data['required'][] = ['req_' . $var, "Spesifikasi ($key->name) tidak boleh kosong!"];
                    $arrAccess[] = false;
                } else {
                    $arrAccess[] = true;
                }
            }

            if (!empty($id_facility)) {
                foreach ($id_facility as $fid) {
                    foreach ($language as $key) {
                        $var = 'description_' . $fid . '_' . $key->id_language;
                        $$var = $request->input($var);
                        if (!$$var) {
                            $data['required'][] = ['req_' . $var, "Deskripsi ($key->name) tidak boleh kosong!"];
                            $arrAccess[] = false;
                        } else {
                            $arrAccess[] = true;
                        }
                    }
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        if (in_array(false, $arrAccess)) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Periksa kembali form anda! Pastikan semua field telah terisi'],
                'required' => $data['required']
            ]);
        }

        $stock = $request->input('stock');
        if ($stock < 0) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Stok tidak boleh kurang dari 0']
            ]);
        }else{
            $post['stock'] = $stock;
        }

        $tujuan = public_path('data/project/');
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        $name_image = $request->name_image;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($project->image && file_exists($tujuan . $project->image)) {
                unlink($tujuan . $project->image);
            }

            $post['image'] = $fileName;
        } elseif ($name_image) {
            if (!$project->image) {
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Gambar proyek tidak boleh kosong!']
                ]);
            }
        } else {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gambar proyek tidak boleh kosong!']
            ]);
        }

        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if (!$lat || !$lng) {
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Tandai lokasi pada peta terlebih dahulu!']
            ]);
        }

        $post['lat'] = $lat;
        $post['lng'] = $lng;

        $update = $project->update($post);

        if ($update) {
            // Update ProjectDetail
            $dtl = ProjectDetail::where('id_project', $project->id_project)->get();

            if ($dtl->isNotEmpty()) {
                $post2 = [];
                foreach ($dtl as $key) {
                    $post2[] = [
                        'id_project_detail' => $key->id_project_detail,
                        'id_language'       => $key->id_language,
                        'specification'     => $request->input('specification_' . $key->id_language)
                    ];
                }
                Batch::update(new ProjectDetail, $post2, 'id_project_detail');
            }

            // Update ProjectFacility
            ProjectFacility::where('id_project', $project->id_project)->delete();

            if (!empty($id_facility)) {
                $post3 = [];
                foreach ($id_facility as $fid) {
                    foreach ($language as $key) {
                        $spec = 'description_' . $fid . '_' . $key->id_language;
                        $val = $request->input($spec);
                        if ($val) {
                            $post3[] = [
                                'id_project'  => $project->id_project,
                                'id_language' => $key->id_language,
                                'id_facility' => $fid,
                                'description' => $val
                            ];
                        }
                    }
                }
                if (!empty($post3)) {
                    $project->facilities()->insert($post3);
                }
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
    }


    // POST GALLERY
    public function insert_gallery(Request $request)
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
                        'alert' => ['message' => 'Nama Galeri <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        $id_project = $request->input('id_project');
        $tujuan = public_path('data/gallery/');
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
                'alert' => ['message' => 'Gambar tidak boleh kosong!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['id_project'] = $id_project;

        $insert = ProjectGallery::create($post);

        if ($insert) {
            $post2 = [];
            if ($language->isNotEmpty()) {
                foreach ($language as $key) {
                    $name = 'name_'.$key->id_language;
                    
                    $post2[] = [
                        'id_project_gallery' => $insert->id_project_gallery,
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

    public function update_gallery(Request $request)
    {
        $id = $request->id_project_gallery;
        $gallery = ProjectGallery::where('id_project_gallery', $id)->first();


        if (!$gallery) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'project_gallery tidak ditemukan!']
            ]);
        }
        
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $id_project = $request->input('id_project','N');

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'name_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Nama Galeri <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }


        $tujuan = public_path('data/gallery/');
        $name_image = $request->name_image;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($gallery->image && file_exists($tujuan . $gallery->image)) {
                unlink($tujuan . $gallery->image);
            }

            $post['image'] = $fileName;
        } elseif ($name_image) {
            if (!$gallery->image || !file_exists($tujuan . $gallery->image)) {
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

        $update = $gallery->update($post);

        if ($update) {
            $post2 = [];

            $dtl = ProjectGalleryDetail::where('id_project_gallery', $gallery->id_project_gallery)->get();

            if ($dtl->isNotEmpty()) {
                foreach ($dtl as $key) {
                    $post2[] = [
                        'id_project_gallery_detail' => $key->id_project_gallery_detail,
                        'id_language'      => $key->id_language,
                        'name'      => request('name_' . $key->id_language)
                    ];
                }
                

                Batch::update(new ProjectGalleryDetail, $post2, 'id_project_gallery_detail');
                
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



    // POST ARTICLE
    public function insert_article(Request $request)
    {
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {

            foreach ($language as $key) {
                $var = 'title_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Judul <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            foreach ($language as $key) {
                $var = 'short_description_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi Singkat <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            foreach ($language as $key) {
                $var = 'description_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }

        $tujuan = public_path('data/article/');
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
                'alert' => ['message' => 'Gambar artikel tidak boleh kosong!']
            ]);
        }

        $prefix = config('session.prefix');
        $id_user = session($prefix . '_id_user');

        $post['created_by'] = $id_user;

        $insert = Article::create($post);

        if ($insert) {
            $post2 = [];
            if ($language->isNotEmpty()) {
                foreach ($language as $key) {
                    $desc = 'description_'.$key->id_language;
                    $title = 'title_'.$key->id_language;
                    $sd = 'short_description_'.$key->id_language;
                    $post2[] = [
                        'id_article' => $insert->id_article,
                        'id_language' => $key->id_language,
                        'description' => $$desc,
                        'title' => $$title,
                        'short_description' => $$sd,
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

    public function update_article(Request $request)
    {
        $id = $request->id_article;
        $article = Article::where('id_article', $id)->first();

        if (!$article) {
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'article tidak ditemukan!']
            ]);
        }
        
        $post = [];
        $arrAccess = [];
        $data = [];
        $arrVar = [];

        $language = Language::where('status','Y')->get();
        if ($language->isNotEmpty()) {
            foreach ($language as $key) {
                $var = 'title_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Judul <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            foreach ($language as $key) {
                $var = 'short_description_'.$key->id_language;
                $$var = $request->input($var);
                if (!$$var) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi Singkat <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }

            foreach ($language as $key) {
                $var = 'description_'.$key->id_language;
                $$var = $request->input($var);
                $cc = ckeditor_check($$var);
                if (empty($cc)) {
                    return response()->json([
                        'status' => false,
                        'alert' => ['message' => 'Deskripsi <b>('.$key->name.')</b> Tidak boleh kosong!']
                    ]);
                }
            }
        }else{
            return response()->json([
                'status' => false,
                'alert' => ['message' => 'Sistem tidak valid! Hubungi developer atau tunggu beberapa saat']
            ]);
        }
        $tujuan = public_path('data/article/');
        $name_image = $request->name_image;
        if (!File::exists($tujuan)) {
            File::makeDirectory($tujuan, 0755, true, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move($tujuan, $fileName);

            if ($article->image && file_exists($tujuan . $article->image)) {
                unlink($tujuan . $article->image);
            }

            $post['image'] = $fileName;
        } elseif ($name_image) {
            if (!$article->image || !file_exists($tujuan . $article->image)) {
                return response()->json([
                    'status' => 700,
                    'alert' => ['message' => 'Gambar artikel tidak boleh kosong!']
                ]);
            }
        }else{
            return response()->json([
                'status' => 700,
                'alert' => ['message' => 'Gambar artikel tidak boleh kosong!']
            ]);
        }

        $update = $article->update($post);

        if ($update) {
            $post2 = [];

            $dtl = ArticleDetail::where('id_article', $article->id_article)->get();

            if ($dtl->isNotEmpty()) {
                foreach ($dtl as $key) {
                    $post2[] = [
                        'id_article_detail' => $key->id_article_detail,
                        'id_language'      => $key->id_language,
                        'description'      => request('description_' . $key->id_language),
                        'title'      => request('title_' . $key->id_language, null),
                        'short_description'        => request('short_description_' . $key->id_language, null),
                    ];
                }

                Batch::update(new ArticleDetail, $post2, 'id_article_detail');
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


}
