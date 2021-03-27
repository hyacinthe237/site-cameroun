<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';
    protected $appends = ['img'];


    public function user () {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function category () {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    public function getImgAttribute () {
        return $this->image ? $this->image : "/assets/images/offers.png";
    }

    public function scopePublished ($q)
    {
        return $q->whereStatus('published');
    }
}
