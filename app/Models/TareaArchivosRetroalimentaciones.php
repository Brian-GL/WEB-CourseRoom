<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TareaArchivosRetroalimentaciones extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tareaArchivosRetroalimentaciones';

    protected $fillable = ['archivo', 'extension'];
}
