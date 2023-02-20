<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CursoArchivosMensajes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cursoArchivosMensajes';

    protected $fillable = ['archivo', 'extension'];
}
