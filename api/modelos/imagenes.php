<?php

/**
 * 
 */
require_once ('Database.php');

class Imagenes extends Database
{
	
	public $NombreTabla='imagen';

	function __construct()
	{
		parent::__construct($DB='imagenes');
	}


	public function Consulta($ConfiguracionEnviada = array())
	{	
		$ConfiguracionDefecto = array(
            'SELECT' => array(),
            'id_cliente' => '',
            'nombreimagen' =>'',
            'rutaimagen' =>'',
            'limit' => '',
            'orden' => array()            
        );

		
		$ConfiguracionExtendida = array_merge($ConfiguracionDefecto, $ConfiguracionEnviada);


		if($ConfiguracionExtendida['nombreimagen'] != ''){
            $FiltroSQL[] = $this->crearFiltro('i', 'nombreimagen', $ConfiguracionExtendida['nombreimagen']);
        }
        
     
        $ConsultaSQL = "            
        SELECT
        	i.id_imagen, 
        	i.nombreimagen , 
        	i.rutaimagen        	
        FROM
          ".$this->NombreTabla." i "                 
        .((count($FiltroSQL) > 0) ? ' WHERE '.implode(" AND ",$FiltroSQL) : '')."
        ".((isset($OrdenarPor)) ? "ORDER BY ".$OrdenarPor : '')."                     
        ".((isset($Limite)) ? $Limite : '')."
        ";
   
        $ResultadoSQL = $this->pasarelaSql($ConsultaSQL,'assoc');  
        return $ResultadoSQL;
	}


     public function insertar($nombre,$ruta,$fecha) {
        
        $sql="INSERT INTO imagen (nombreimagen, rutaimagen, fecha) 
        VALUES 
        ('".$nombre."','".$ruta."','".$fecha."')";
        
        $this->inserdatos($sql);
    }



}
?>