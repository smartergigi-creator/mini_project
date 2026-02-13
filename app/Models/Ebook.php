<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ebook extends Model
{
    // ✅ Correct table name
    protected $table = 'ebook';

   protected $fillable = [
'title',
        'file_title',
        'pdf_path',
        'folder_path',
        'page_count',
        'uploaded_by',
        'user_id',
        'share_token',
        'share_expires_at',
        'share_enabled',
        'shared_by',
        'max_views',
        'current_views'
];


    public function pages()
    {
        return $this->hasMany(EbookPage::class);
    }
    // Upload pannina user
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Share pannina user
    public function sharedUser()
    {
        return $this->belongsTo(User::class, 'shared_by');
    }
}
