<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UsuariosImagenes extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'usuariosImagenes';
}
