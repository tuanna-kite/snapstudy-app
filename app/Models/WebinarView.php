<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebinarView extends Model
{
    protected $table = 'webinar_views';
    public $timestamps = false;

    protected $guarded = ['id'];
}
