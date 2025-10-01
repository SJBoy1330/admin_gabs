<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleDetail extends Model
{
    // Nama tabel
    protected $table = 'article_details';

    // Primary key
    protected $primaryKey = 'id_article_detail';

    // Auto increment
    public $incrementing = true;

    // Tipe primary key
    protected $keyType = 'int';

    // Karena created_at & updated_at dihandle manual di migration
    public $timestamps = false;

    // Kolom yang bisa diisi mass assignment
    protected $fillable = [
        'id_article',
        'id_language',
        'title',
        'short_description',
        'description',
        'created_at',
        'updated_at',
    ];

    // === RELATIONSHIP ===

    // Relasi ke Article
    public function article()
    {
        return $this->belongsTo(Article::class, 'id_article', 'id_article');
    }

    // Relasi ke Language
    public function language()
    {
        return $this->belongsTo(Language::class, 'id_language', 'id_language');
    }
}
