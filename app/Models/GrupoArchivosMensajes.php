<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class GrupoArchivosMensajes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'grupoArchivosMensajes';

    protected $fillable = ['archivo', 'extension'];
}
