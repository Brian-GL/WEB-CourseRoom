<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class GruposImagenes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'gruposImagenes';

    protected $fillable = ['archivo', 'extension'];
}
