<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    public function themes()
    {
        return $this->hasMany(Theme::class)->orderBy('sort_id', 'asc');
    }
}
