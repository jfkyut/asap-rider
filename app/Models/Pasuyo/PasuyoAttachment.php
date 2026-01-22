<?php

namespace App\Models\Pasuyo;

use Illuminate\Database\Eloquent\Model;

class PasuyoAttachment extends Model
{
    protected $fillable = [
        'pasuyo_id',
        'file_path',
        'file_name',
    ];
}
