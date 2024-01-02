<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jsadways\ScopeFilter\ScopeFilterTrait;

class Board extends Model
{
    use ScopeFilterTrait;
    protected $fillable = ['staff_id', 'content', 'board_id'];

    use HasFactory;
}
