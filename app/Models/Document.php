<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    public function documentCategory()
    {
        return $this->belongsTo(DocumentCategory::class)->withTrashed();
    }

    public function lawArea()
    {
        return $this->belongsTo(LawArea::class)->withTrashed();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
}
