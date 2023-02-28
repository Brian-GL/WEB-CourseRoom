<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CursoArchivoMaterialRegistrar extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'cursoArchivosMaterialRegistrar';

    protected $fillable = ['archivo', 'extension'];
}