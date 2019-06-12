<?php
error_reporting(E_ALL);
ini_set('display_error', 'On');
require_once('./api/Rest.php');


class API extends REST {
    
    private $buscarcontenido = null;
    public function __construct() 
    {
        // Inicializa 
    }

    public function processApi() 
    {
        $func = $_REQUEST['request'];
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404);
    }

    private function BuscarImagen() 
    {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }
        
        $Configuracion = array(
            'loginuser' => $_POST['nombre'],           
        );
   
        $ArchivoModelo= './api/modelos/'.$this->_request['modelo'].'.php';
        if(file_exists($ArchivoModelo))
        {
            include $ArchivoModelo;
            $this->Imagenes = new Imagenes($_POST['base']);
            $datos = $this->Imagenes->Consulta($Configuracion );        
            $this->response($this->json($datos), 200);
        }
        else{
            $this->response('', 405);
        }
        
        //$error = array('status' => "Failed", "msg" => "Invalid Email address or Password");
        //$this->response($this->json($error), 400);
    }

    private function getReporte() {
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $ArchivoModelo= './api/modelos/'.$this->_request['modelo'].'.php';
        if(file_exists($ArchivoModelo))
        {
            include $ArchivoModelo;
            $this->Reporte = new Reporte($_POST['base']);
            $datos = $this->Cliente->ConsultaInventario($_POST['id_cliente'] );        
            $this->response($this->json($datos), 200);
        }
        else{
            $this->response('', 405);
        }
    }

    private function GuardarImagen() {
        /*
                print_r($_POST);
                $fileTmpPath = $_POST['file']['file']['tmp_name'];
                $fileName = $_POST['file']['file']['name'];
                $fileSize = $_POST['file']['file']['size'];
                $fileType = $_POST['file']['file']['type'];
                $fileNameCmps = explode(".", $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                $dest_path =  $newFileName;
                
                if(move_uploaded_file($fileTmpPath, $dest_path))
                {
                    $Respuesta = array('error' =>'ok');
                     $this->response($this->json($Respuesta), 200);
                    //echo json_encode($Respuesta);
                }
                else
                {
                    $Respuesta = array('error' =>$dest_path);
                     $this->response($this->json($Respuesta), 200);
                } */
             $ArchivoModelo= './api/modelos/imagenes.php';
        if(file_exists($ArchivoModelo))
        {
            include $ArchivoModelo;
            $this->Imagenes = new Imagenes();
            $this->Imagenes->insertar($_POST['nombre'],$_POST['ruta'],$_POST['fecha']); 
            $Respuesta = array('respuesta' =>'imagen guardada');        
            $this->response($this->json($Respuesta), 200);
        }
        else{
            $Respuesta = array('respuesta' =>'no existe la ruta');        
            $this->response($this->json($Respuesta), 200);
        }
                 
       
    }
    
    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}

$api = new API;
$api->processApi();
