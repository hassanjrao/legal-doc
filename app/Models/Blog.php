<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends=['short_content','image_url'];

    public function getShortContentAttribute()
    {
        $content=$this->content;
        // remove html tags
        $content=strip_tags($content);

        if(strlen($content)>100){
            return substr($content,0,50).'...';
        }

        return $content;
    }

    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

}
