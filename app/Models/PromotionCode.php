<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCode extends Model
{
    use HasFactory;

    protected $table = 'promotion_codes';
    public $timestamps = true;

    public function isValid()
    {
        return $this->expires_at >= now() || $this->is_used == 0;
    }
}
