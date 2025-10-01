<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


use App\Models\User;
use App\Models\Contact;
use App\Models\About;
use App\Models\Language;
use App\Models\BannerDetail;
use App\Models\ProjectDetail;
use App\Models\Project;
use App\Models\Article;
use App\Models\ArticleDetail;
use App\Models\Type;
use App\Models\Unit;


class UserController extends Controller
{
    //

    public function index()
    {
        
        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");

        // SET TITLE
        $data['title'] = 'Home';
        
       
        $banner = BannerDetail::with('banner')->whereHas('banner', function($q) {
            $q->where('status', 'Y');
        })
        ->where('id_language', $lang)
        ->get();

        $about = About::where('id_language',$lang)->first();
        $project = ProjectDetail::with([
            'project',
            'project.unit',
            'project.facilities' => function ($q) use ($lang) {
                $q->where('id_language', $lang)
                ->with('facility');
            }
        ])
        ->where('id_language', $lang)
        ->take(6)
        ->get();

        $article = ArticleDetail::with(['article'])
        ->join('articles', 'articles.id_article', '=', 'article_details.id_article')
        ->where('id_language', $lang)
        ->where('articles.status','Y')
        ->take(6)
        ->get();



        

        // SET DATA
        $data['banner'] = $banner;
        $data['about'] = $about;
        $data['project'] = $project;
        $data['article'] = $article;

        return view('user.index',$data);
    }

    public function about()
    {
        
        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");

        // SET TITLE
        $data['title'] = 'Tentang Kami';

        $about = About::where('id_language',$lang)->first();

        // SET DATA
        $data['about'] = $about;

        return view('user.about',$data);
    }

    public function contact()
    {
        
        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");

        // SET TITLE
        $data['title'] = 'Kontak Kami';

        return view('user.contact',$data);
    }

    public function article(Request $request)
    {
        $prefix = config('session.prefix');
        $lang   = Session::get("{$prefix}_lang");

        // PARAMETER
        $search      = $request->get('search', '');
        $id_unit = $request->get('id_unit', []);
        $id_type = $request->get('id_type', []);
        $min_price   = $request->get('min_price', 0);
        $max_price   = $request->get('max_price');
        $offset      = (int) $request->get('offset', 1);
        $limit       = 6;
        $start       = ($offset - 1) * $limit;

        // SET TITLE
        $data['title'] = 'Artikel Sentanu';
        // BASE QUERY
        $query = ArticleDetail::with([
            'article'
        ])
        ->where('id_language', $lang);

        if (!empty($search)) {
            $query->where('title', 'like', "%{$search}%")
            ->orWhere('short_description','like',"%{$search}%")
            ->orWhere('description','like',"%{$search}%");
        }
        

        // COUNT TOTAL
        $jumlah = $query->count();

        // PAGINATION
        $article = $query
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($limit)
            ->get();

       



        // SET DATA
        $data['article']     = $article;
        $data['search']      = $search;
        $data['jumlah']      = $jumlah;
        $data['offset']      = $offset;
        $data['start']       = $start;
        $data['total']       = ($jumlah > 0) ? ceil($jumlah / $limit) : 0;

        return view('user.article', $data);
    }

    public function project(Request $request)
    {
        $prefix = config('session.prefix');
        $lang   = Session::get("{$prefix}_lang");

        // PARAMETER
        $search      = $request->get('search', '');
        $id_unit = $request->get('id_unit', []);
        $id_type = $request->get('id_type', []);
        $min_price   = $request->get('min_price', 0);
        $max_price   = $request->get('max_price');
        $offset      = (int) $request->get('offset', 1);
        $limit       = 6;
        $start       = ($offset - 1) * $limit;

        // SET TITLE
        $data['title'] = 'Proyek Sentanu';

        // QUERY MAX PRICE
        $mp = Project::where('status', 'Y')
            ->max('price');
        $max_price = $max_price ?? $mp;

        // BASE QUERY
        $query = ProjectDetail::with([
            'project',
            'project.unit',
            'project.facilities' => function ($q) use ($lang) {
                $q->where('id_language', $lang)->with('facility');
            }
        ])
        ->where('id_language', $lang);

        if (!empty($search)) {
            $query->whereHas('project', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // FILTER UNIT
        if (!empty($id_unit) && is_array($id_unit)) {
            $query->whereHas('project', function($q) use ($id_unit) {
                $q->whereIn('id_unit', $id_unit);
            });
        }

        // FILTER TYPE
        if (!empty($id_type) && is_array($id_type)) {
            $query->whereHas('project', function($q) use ($id_type) {
                $q->whereIn('id_type', $id_type);
            });
        }

        // FILTER PRICE
        if (!empty($min_price)) {
            $query->whereHas('project', function($q) use ($min_price) {
                $q->where('price', '>=', $min_price);
            });
        }

        if (!empty($max_price)) {
            $query->whereHas('project', function($q) use ($max_price) {
                $q->where('price', '<=', $max_price);
            });
        }

        // COUNT TOTAL
        $jumlah = $query->count();

        // PAGINATION
        $project = $query
            ->orderBy('created_at', 'desc')
            ->skip($start)
            ->take($limit)
            ->get();

        // GET UNIT
        $unit = Unit::get();
        // GET TYPE
        $type = Type::get();

        // SET DATA
        $data['project']     = $project;
        $data['unit']    = $unit;
        $data['type']    = $type;
        $data['search']      = $search;
        $data['id_unit'] = $id_unit;
        $data['id_type'] = $id_type;
        $data['min_price']   = $min_price;
        $data['max_price']   = $max_price;
        $data['mp']          = $mp ?? 0;
        $data['jumlah']      = $jumlah;
        $data['offset']      = $offset;
        $data['start']       = $start;
        $data['total']       = ($jumlah > 0) ? ceil($jumlah / $limit) : 0;

        return view('user.project', $data);
    }


    public function project_detail(Request $request,$code = null)
    {
        // SESSION
        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");

        $cd = base64url_decode($code);
        $arr = explode('|',$cd);
        $id = $arr[0];

        
        if (!$id) {
            return redirect()->route('project');
        }
        
        // GET DATA
        $result = ProjectDetail::with([
            'project',
            'project.unit',
            'project.galleries' => function($q) use ($lang) {
                $q->with(['details' => function ($f) use ($lang) {
                    $f->where('id_language', $lang);
                }]);
            },
            'project.facilities' => function ($q) use ($lang) {
                $q->where('id_language', $lang)
                ->with(['facility' => function ($f) use ($lang) {
                    $f->with(['details' => function ($d) use ($lang) {
                        $d->where('id_language', $lang);
                    }]);
                }]);
            }
        ])
        ->where('id_project', $id)
        ->where('id_language', $lang)
        ->first();


        if (!$result) {
            return redirect()->route('project');
        }

       

         // SET TITLE
        $data['title'] = ucwords($result->project->name);

        // SET DATA
        $data['result'] = $result;

        return view('user.detail.project',$data);
    }

    public function article_detail(Request $request,$code = null)
    {
        // SESSION
        $prefix = config('session.prefix');
        $lang = Session::get("{$prefix}_lang");

        $cd = base64url_decode($code);
        $arr = explode('|',$cd);
        $id = $arr[0];

        
        if (!$id) {
            return redirect()->route('article');
        }
        
        // GET DATA
        $result = ArticleDetail::with(['article'])
        ->where('id_article', $id)
        ->where('id_language', $lang)
        ->first();


        if (!$result) {
            return redirect()->route('article');
        }

         $other = ArticleDetail::where('id_language', $lang)
            ->where('id_article', '!=', $id)
            ->inRandomOrder()
            ->take(3)
            ->get();

       

         // SET TITLE
        $data['title'] = ucwords($result->article->title);

        // SET DATA
        $data['result'] = $result;
        $data['other'] = $other;

        return view('user.detail.article',$data);
    }

    public function insert_contact(Request $request)
    {
        // Ambil data dari input
        $email = strtolower($request->email);
        $name = $request->name;
        $message = $request->message;

        // Validasi input
        if (!$email || !$name || !$message) {
            return response()->json(['status' => 700, 'message' => 'Tidak ada data terdeteksi! Silahkan cek data']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Alamat email tidak valid! Cek format email']);
        }

        $post['email'] = $email;
        $post['name'] = $name;
        $post['message'] = $message;

        $insert = Contact::create($post);
        if ($insert) {
            return response()->json([
                'status' => 200,
                'message' => 'Anda berhasil meninggalkan pesan!',
                'redirect' => url('/contact')
            ]);
        } else {
            return response()->json(['status' => 500, 'message' => 'Alamat email tidak terdaftar didalam sistem!']);
        }
    }

    public function change_language(Request $request)
    {
        $prefix = config('session.prefix');
        $id = $request->input('id');
        $cek = Language::find($id);

        if ($cek) {
            Session::put([
                "{$prefix}_lang"  => $cek->id_language,
                "{$prefix}_lang_code"  => $cek->code
            ]);
        }
        
        sleep(1);
        return response()->json([
            'status' => true
        ]);
    }


}
