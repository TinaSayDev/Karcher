<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopMenu extends Model
{
    protected $fillable = [
        'link1',
        'link2',
        'phone',
    ];

    public $timestamps = false;

}
