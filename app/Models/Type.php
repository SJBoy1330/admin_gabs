<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'types';

    // Primary key
    protected $primaryKey = 'id_type';

    // Kalau primary key bukan auto increment integer, harus set ini
    public $incrementing = true;
    protected $keyType = 'int';

    // Laravel default pakai created_at & updated_at (timestamp), 
    // tapi kamu sudah set manual jadi datetime, tetap bisa dipakai
    public $timestamps = true;

    // Kolom yang bisa diisi
    protected $fillable = [
        'name',
        'created_by',
    ];

    // Relasi ke User (pembuat kategori)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
