<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerDetail extends Model
{
    use HasFactory;

    protected $table = 'banner_details';
    protected $primaryKey = 'id_banner_detail';
    public $timestamps = false; // karena created_at & updated_at diatur manual lewat DB

    protected $fillable = [
        'id_banner',
        'id_language',
        'description',
        'name_button',
        'name_link',
        'created_at',
        'updated_at',
    ];

    // Relasi ke tabel banners
    public function banner()
    {
        return $this->belongsTo(Banner::class, 'id_banner', 'id_banner');
    }

    // Relasi ke tabel languages
    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
