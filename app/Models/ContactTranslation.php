<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'locale',
        'label',
        'address',
        'phone',
        'email',
        'schedule',
    ];
}
