<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name', 'phone', 'address'];

    use HasFactory;

    public function boards()
    {
        return $this->hasMany(Board::class, 'staff_id', 'id');
    }
}
