<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    // Nama tabel (kalau beda dari plural default Laravel)
    protected $table = 'abouts';

    // Primary key
    protected $primaryKey = 'id_about';

    // Kolom yang boleh diisi (mass assignable)
    protected $fillable = [
        'id_language',
        'about_1',
        'about_2',
    ];

    // Laravel akan otomatis mengatur created_at dan updated_at
    public $timestamps = true;

      // Relasi ke tabel languages
    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
