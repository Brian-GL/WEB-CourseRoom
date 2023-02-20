<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TareaArchivosEntregados extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tareaArchivosEntregados';

    protected $fillable = ['archivo', 'extension'];
}
