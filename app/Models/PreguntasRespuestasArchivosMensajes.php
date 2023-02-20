<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PreguntasRespuestasArchivosMensajes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'preguntaRespuestaArchivosMensajes';

    protected $fillable = ['archivo', 'extension'];
}
