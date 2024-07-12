<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    static $statuses = [
        'active', 'inactive'
    ];
}
