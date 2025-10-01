<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
 use Illuminate\Database\Eloquent\Builder;



use App\Models\User;
use App\Models\Banner;
use App\Models\BannerDetail;
use App\Models\Contact;
use App\Models\Language;
use App\Models\Location;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Facility;
use App\Models\Project;
use App\Models\Article;
use App\Models\ArticleDetail;

class TableManagement extends Controller
{



    public function table_user(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            'users.name',
            'users.email',       
            'users.status',          
        ];

        $query = User::select(     
                    'users.id_user',   
                    'users.name',     
                    'users.email',  
                    'users.status', 
                    'users.image'   
                )->where('users.id_user','!=',$id_user)
                ->where('users.role',2);
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('users.created_at', 'DESC'); // Default sorting
        }

        if ($request->filter_status !== null && $request->filter_status !== '') {
            if ($request->filter_status != 'all') {
                $query->where('status', $request->filter_status);
            }
            
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {
            // GET USER
            $user = '';
            $user .= '<div class="d-flex align-items-center">';
            $user .= '<a role="button" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.image_check($item->image,'user','user').');"></span></a>';
            $user .= '<div class="ms-5">';
            $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
            $user .= '</div></div>';

            // STATUS
            $checked = '';
            if ($item->status == 'Y') {
                $checked = 'checked';
            }
            $status = '';
            $status .= '<div class="d-flex justify-content-center align-items-center">';
            $status .= '<div class="form-check form-switch"><input onchange="switching(this,event,'.$item->id_user.')" data-primary="id_user"  data-url="'.url('switch/users').'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_user.'" '.$checked.'></div>';
            $status .= '</div>';

            $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }
                
                $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }
            

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_user.')" data-image="'.image_check($item->image,'user','user').'" data-bs-toggle="modal" data-bs-target="#kt_modal_user">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_user.',`users`,`id_user`)" data-datatable="table_user" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                $user,
                $kontak,
                $status,
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }


    public function table_banner(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            null,
            null,
            'banners.status',          
        ];

        $query = Banner::with(['details.language']);
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Search di kolom banners
                $q->where('banners.image', 'like', "%{$search}%")
                // Search di relasi banner_details
                ->orWhereHas('details', function ($q2) use ($search) {
                    $q2->where('description', 'like', "%{$search}%");
                });
            });
        }
        if (!empty($search)) {
            $query->whereHas('details', function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                ->orWhere('name_button', 'like', "%{$search}%");
            });
        }
        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('banners.created_at', 'DESC'); // Default sorting
        }

        if ($request->filter_status !== null && $request->filter_status !== '') {
            if ($request->filter_status != 'all') {
                $query->where('status', $request->filter_status);
            }
            
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            $banner = '<div class="background-partisi rounded" style="width : 200px;height : 100px;background-image : url('.image_check($item->image,'banner').')"></div>';

            // STATUS
            $checked = '';
            if ($item->status == 'Y') {
                $checked = 'checked';
            }
            $status = '';
            $status .= '<div class="d-flex justify-content-center align-items-center">';
            $status .= '<div class="form-check form-switch"><input onchange="switching(this,event,'.$item->id_banner.')" data-primary="id_banner"  data-url="'.url('switch/banners').'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_banner.'" '.$checked.'></div>';
            $status .= '</div>';
            
            $desc = '';
            if ($item->details) {
                $desc .= '<table class="table table-bordered">';
                foreach ($item->details as $key) {
                    $desc .= '<tr>';
                    $desc .= '<td><span class="text-primary mb-2">'.$key->language->name.'</span></td>';
                    $desc .= '</tr>';
                    $desc .= '<tr><td>';
                    $desc .= $key->description;
                    $desc .= '</td></tr>';
                }
                $desc .= '</table>';
            }
        

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="action_data('.$item->id_banner.')" data-bs-toggle="modal" data-bs-target="#kt_modal_banner">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_banner.',`banners`,`id_banner`)" data-datatable="table_banner" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                $banner,
                $desc,
                $status,
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }

    public function table_contact(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            'contacts.name',  
            'contacts.email',  
            'contacts.message',           
        ];

        $query = Contact::where('id_contact','>=',1);
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('contacts.name', 'like', "%{$search}%")
                ->orWhere('contacts.email', 'like', "%{$search}%")
                ->orWhere('contacts.message', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('contacts.created_at', 'DESC'); // Default sorting
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_contact.',`contacts`,`id_contact`)" data-datatable="table_contact" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                $item->name,
                $item->email,
                $item->message,
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }


    public function table_location(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            'locations.name',        
        ];

        $query = location::select('*');
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('locations.name', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('locations.created_at', 'DESC'); // Default sorting
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_location.')"  data-bs-toggle="modal" data-bs-target="#kt_modal_location">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_location.',`locations`,`id_location`)" data-datatable="table_location" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                ucwords($item->name),
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }

    public function table_unit(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            'units.name',        
        ];

        $query = Unit::select('*');
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('units.name', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('units.created_at', 'DESC'); // Default sorting
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_unit.')"  data-bs-toggle="modal" data-bs-target="#kt_modal_unit">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_unit.',`units`,`id_unit`)" data-datatable="table_unit" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                ucwords($item->name),
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }

    public function table_type(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            'types.name',        
        ];

        $query = Type::select('*');
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('types.name', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('types.created_at', 'DESC'); // Default sorting
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_type.')"  data-bs-toggle="modal" data-bs-target="#kt_modal_type">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_type.',`types`,`id_type`)" data-datatable="table_type" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                ucwords($item->name),
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }

    public function table_facility(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            null,
            null,   
        ];

        $query = Facility::select('*');
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Search di kolom facilities
                $q->where('facilities.image', 'like', "%{$search}%")
                // Search di relasi banner_details
                ->orWhereHas('details', function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                });
            });
        }
        if (!empty($search)) {
            $query->whereHas('details', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('facilities.created_at', 'DESC'); // Default sorting
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {
            $image = '';
            $image .= '<div class="d-flex align-items-center">';
            $image .= '<a role="button" class="symbol symbol-100px"><span class="symbol-label" style="background-image:url('.image_check($item->image,'facility').');"></span></a>';
            $image .= '</div>';

            $desc = '';
            if ($item->details) {
                $desc .= '<table class="table table-bordered">';
                foreach ($item->details as $key) {
                    $desc .= '<tr>';
                    $desc .= '<td><span class="text-primary mb-2">'.$key->language->name.'</span></td>';
                    $desc .= '</tr>';
                    $desc .= '<tr><td>';
                    $desc .= ucwords($key->name);
                    $desc .= '</td></tr>';
                }
                $desc .= '</table>';
            }

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-start flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="action_data('.$item->id_facility.')" data-bs-toggle="modal" data-bs-target="#kt_modal_facility">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_facility.',`facilities`,`id_facility`)" data-datatable="table_facility" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                $action,
                $image,
                $desc,
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }


    public function table_project(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';

        // Kolom mapping sesuai urutan DataTables
        $columns = [
            null,   
            null,
            'units.name',
            'projects.name',
            'types.name',
            'projects.stock',
            'locations.name',
            'projects.status'
        ];

        $query = Project::with(['type','unit','location'])
            ->select('projects.*')
            ->leftJoin('types', 'types.id_type', '=', 'projects.id_type')
            ->leftJoin('units', 'units.id_unit', '=', 'projects.id_unit')
            ->leftJoin('locations', 'locations.id_location', '=', 'projects.id_location');

        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('projects.name', 'like', "%{$search}%")
                    ->orWhere('locations.name', 'like', "%{$search}%")
                    ->orWhere('units.name', 'like', "%{$search}%")
                    ->orWhere('types.name', 'like', "%{$search}%");
            });
        }

        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('projects.created_at', 'DESC'); // Default
        }

        // Filtering
        if ($request->filter_id_unit !== null && $request->filter_id_unit !== '') {
            $query->where('projects.id_unit', $request->filter_id_unit);
        }

        if ($request->filter_id_type !== null && $request->filter_id_type !== '') {
            $query->where('projects.id_type', $request->filter_id_type);
        }

        if ($request->filter_id_location !== null && $request->filter_id_location !== '') {
            $query->where('projects.id_location', $request->filter_id_location);
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $data = $query->skip($start)->take($length)->get();

        // Format output
        $result = [];
        foreach ($data as $item) {
            $image = '<div class="rounded background-partisi" style="background-image:url('.image_check($item->image,'project').');width:200px;height:150px"></div>';

            $unit = $item->unit 
                ? '<span class="badge badge-primary">'.ucwords($item->unit->name).'</span>' 
                : '<span class="badge badge-secondary">-</span>';

            $type = $item->type 
                ? '<span class="badge badge-info">'.ucwords($item->type->name).'</span>' 
                : '<span class="badge badge-secondary">-</span>';

            $location = $item->location 
                ? '<span class="badge badge-success">'.ucwords($item->location->name).'</span>' 
                : '<span class="badge badge-secondary">-</span>';

            if ($item->stock > 0) {
                $stk = $item->stock;
                $stock = '<span class="text-success fs-6">'.$stk.' Unit</span>';
            } else {
                $stock = '<span class="text-danger fs-6">0 Unit</span>';
            }

            $project = '<div class="d-flex flex-column">';
            $project .= '<span class="text-dark fs-5">'.ucwords($item->name).'</span>';
            $project .= '<span class="text-primary fs-7">Rp. '.number_format($item->price,0,',','.').'</span>';
            $project .= '</div>';

            // STATUS
            $checked = $item->status == 'Y' ? 'checked' : '';
            $status = '<div class="d-flex justify-content-center align-items-center">
                        <div class="form-check form-switch">
                            <input onchange="switching(this,event,'.$item->id_project.')" 
                                    data-primary="id_project"  
                                    data-url="'.url('switch/projects').'" 
                                    class="form-check-input cursor-pointer focus-info" 
                                    type="checkbox" role="switch" 
                                    id="switch-'.$item->id_project.'" '.$checked.'>
                        </div>
                    </div>';

            // ACTION
            $action = '<div class="d-flex justify-content-start flex-shrink-0">
                        <button type="button" onclick="hapus_data(this,event,'.$item->id_project.',`projects`,`id_project`)" 
                                data-datatable="table_project" class="btn btn-icon btn-danger btn-sm me-1" title="Delete">
                            <i class="ki-outline ki-trash fs-2"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" 
                                onclick="action_data('.$item->id_project.')"  
                                data-bs-toggle="modal" data-bs-target="#kt_modal_project">
                            <i class="ki-outline ki-pencil fs-2"></i>
                        </button>
                        <a href="'.route('cms.project.gallery',['id' => $item->id_project]).'" class="btn btn-icon btn-info btn-sm" title="Galeri">
                            <i class="fa-solid fa-images fs-2"></i>
                        </a>
                    </div>';

            $result[] = [
                $action,
                $image,
                $unit,
                $project,
                $type,
                $stock,
                $location,
                $status
            ];
        }

        return response()->json([
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result
        ]);
    }



    public function table_article(Request $request)
    {
        $search = $request->search['value'] ?? '';
        $start = (int)($request->start ?? 0);
        $length = (int)($request->length ?? 10);
        $orderColumn = $request->order[0]['column'] ?? null;
        $orderDir = $request->order[0]['dir'] ?? 'asc';
        $today = Carbon::today()->toDateString();
        $prefix = config('session.prefix');
        $id_user = session($prefix.'_id_user');

        // Kolom mapping sesuai urutan di frontend DataTables
        $columns = [
            null,   
            null,
            null,
            'articles.status',          
        ];

        $query = Article::with(['details.language']);
        // Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Search di kolom banners
                $q->where('articles.image', 'like', "%{$search}%")
                // Search di relasi banner_details
                ->orWhereHas('details', function ($q2) use ($search) {
                    $q2->where('description', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%");
                });
            });
        }
        if (!empty($search)) {
            $query->whereHas('details', function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                ->orWhere('title', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%");
            });
        }
        // Sorting
        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $query->orderBy($columns[$orderColumn], $orderDir);
        } else {
            $query->orderBy('articles.created_at', 'DESC'); // Default sorting
        }

        if ($request->filter_status !== null && $request->filter_status !== '') {
            if ($request->filter_status != 'all') {
                $query->where('status', $request->filter_status);
            }
            
        }

        // Total record
        $totalRecords = $query->count();

        // Pagination
        $query->skip($start)->take($length);
        $data = $query->get();

        // Format output
        $result = [];
        foreach ($data as $item) {

            $article = '<div class="background-partisi rounded" style="width : 200px;height : 100px;background-image : url('.image_check($item->image,'article').')"></div>';

            // STATUS
            $checked = '';
            if ($item->status == 'Y') {
                $checked = 'checked';
            }
            $status = '';
            $status .= '<div class="d-flex justify-content-center align-items-center">';
            $status .= '<div class="form-check form-switch"><input onchange="switching(this,event,'.$item->id_article.')" data-primary="id_article"  data-url="'.url('switch/articles').'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_article.'" '.$checked.'></div>';
            $status .= '</div>';
            
            $desc = '';
            if ($item->details) {
                $desc .= '<table class="table table-bordered">';
                foreach ($item->details as $key) {
                    $desc .= '<tr>';
                    $desc .= '<td><span class="text-primary mb-2">'.$key->language->name.'</span></td>';
                    $desc .= '</tr>';
                    $desc .= '<tr><td>';
                    $desc .= $key->title;
                    $desc .= '</td></tr>';
                }
                $desc .= '</table>';
            }
        

            // ACTION
            $action = '';
            $action .= '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="action_data('.$item->id_article.')" data-bs-toggle="modal" data-bs-target="#kt_modal_article">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_article.',`articles`,`id_article`)" data-datatable="table_article" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

            
            $result[] = [
                $article,
                $desc,
                $status,
                $action
            ];
        }

        $return = [
            'draw' => intval($request->draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $result // langsung isi array row di sini
        ];

        return response()->json($return);

        
    }


}
