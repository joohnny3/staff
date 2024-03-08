<?php

namespace App\Models;

use App\Enums\NotifyServiceType;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function service(): Attribute
    {
        return Attribute::make(
            set: fn($value) => NotifyServiceType::service($value)
    );
    }
}
