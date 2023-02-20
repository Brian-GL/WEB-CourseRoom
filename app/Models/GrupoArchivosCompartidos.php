<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class GrupoArchivosCompartidos extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'grupoArchivosCompartidos';

    protected $fillable = ['archivo', 'extension'];
}
