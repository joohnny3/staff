<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jsadways\ScopeFilter\ScopeFilterTrait;

class Staff extends Model
{
    use ScopeFilterTrait;

    use HasFactory;
    protected $fillable = ['name', 'phone', 'address'];

    public function boards()
    {
        return $this->hasMany(Board::class, 'staff_id', 'id');
    }
}
