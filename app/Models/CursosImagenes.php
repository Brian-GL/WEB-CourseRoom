<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CursosImagenes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cursosImagenes';

    protected $fillable = ['archivo', 'extension'];
}
