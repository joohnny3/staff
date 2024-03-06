<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;

    protected $table = 'notify';

    protected $fillable = [
        'recipient_name',
        'email',
        'carbon_copy',
        'blind_carbon_copy',
        'subject',
        'content',
        'template',
        'service',
        'attachment',
        'sent_time',
        'status'
    ];
}
