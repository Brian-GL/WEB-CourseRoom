<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ChatsArchivosMensajes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'chatArchivosMensajes';

    protected $fillable = ['archivo', 'extension'];
}
