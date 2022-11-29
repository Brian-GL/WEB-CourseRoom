<?php

namespace App\Entities;

class OperacionMatematica{

    public $clave;
    public $nombre;

    function __construct( $key, $name ) {
		$this->clave = $key;
        $this->nombre = $name;
	}
}

?>
