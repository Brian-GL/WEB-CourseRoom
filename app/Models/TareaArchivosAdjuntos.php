<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TareaArchivosAdjuntos extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tareaArchivosAdjuntos';

    protected $fillable = ['archivo', 'extension'];
}
