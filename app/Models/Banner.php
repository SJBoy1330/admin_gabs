<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';
    protected $primaryKey = 'id_banner';
    public $timestamps = false; // created_at & updated_at di-handle DB

    protected $fillable = [
        'image',
        'button',
        'status',
        'reason',
        'blocked_date',
        'blocked_by',
        'created_by',
        'created_at',
        'updated_at',
        'deleted',
        'deleted_by',
        'deleted_at',
    ];

    // Relasi ke user yang membuat banner
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    // Relasi ke user yang menghapus banner
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id_user');
    }

    // Relasi ke user yang memblokir banner
    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocked_by', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(BannerDetail::class, 'id_banner', 'id_banner');
    }

}
