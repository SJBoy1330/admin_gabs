<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table = 'languages';
    protected $primaryKey = 'id_language';
    public $timestamps = false;

    protected $fillable = [
        'code',
        'name',
        'default',
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

    // Relasi ke user yang membuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }

    // Relasi ke user yang menghapus
    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id_user');
    }

    // Relasi ke user yang memblokir
    public function blocker()
    {
        return $this->belongsTo(User::class, 'blocked_by', 'id_user');
    }
}
