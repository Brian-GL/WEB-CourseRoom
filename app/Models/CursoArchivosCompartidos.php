<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CursoArchivosCompartidos extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cursoArchivosCompartidos';

    protected $fillable = ['archivo', 'extension'];
}
