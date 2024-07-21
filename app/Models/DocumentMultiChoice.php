<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentMultiChoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function options()
    {
        return $this->hasMany(DocumentMultiChoiceOption::class);
    }


}
