<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // kalau mau pakai soft delete bawaan

class Article extends Model
{
    // Nama tabel (kalau beda dari default plural)
    protected $table = 'articles';

    // Primary key
    protected $primaryKey = 'id_article';

    // Kalau primary key bukan incrementing integer standar
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Karena di migration created_at & updated_at dibuat manual, kita nonaktifkan timestamps default
    public $timestamps = false;

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'image',
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

    // === RELATIONSHIP ===

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id_user');
    }

    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocked_by', 'id_user');
    }

    public function details()
    {
        return $this->hasMany(ArticleDetail::class, 'id_article', 'id_article');
    }

}
