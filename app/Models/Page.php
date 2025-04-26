<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'conference_id',
        'title',
        'slug',
        'content',
    ];

    public function conference()
    {
        return $this->belongsTo(Conference::class);
    }
}
