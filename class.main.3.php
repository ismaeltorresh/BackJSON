<?php
class clMain extends mysqli{ 
    public $trQuery;
    public $trConexion;
    public $trSesion;
    const cnHost = 'raiz_de_la_aplicacion';

    public function mtConectar(){
        $this->connect('servidor','usuario','contrasenia','base');
        if($this->error){
            $vrResultado['resultado'] = 1;
            $vrResultado['mensaje'] = "Ocurrió un error al conectar con la base de datos";
            $vrResultado['error'] = $this->error;
            $vrArchivo = fopen("../log_error.txt", "w");
            fwrite($vrArchivo,  $vrResultado['error']);
            fclose($vrArchivo);
        }else{
            $vrResultado['resultado'] = 5;
        }
        return $vrResultado;
    }
    public function mtDatos(){
        if($this->trQuery){
            $this->set_charset("utf8");
            $vrRegistros = $this->query($this->trQuery);
            if($vrRegistros){
                if($vrRegistros->num_rows){
                    $vrResultado['resultado'] = 5;
                    while ($vrDatos = $vrRegistros->fetch_assoc()) {
                        $vrResultado['datos'][] = $vrDatos;
                        $vrResultado['mensaje'] = "Consulta exitosa";
                    }
                    $vrResultado['nregistros'] = $vrRegistros->num_rows;
                }else{
                    $vrResultado['resultado'] = 2;
                    $vrResultado['mensaje'] = "No hay registros que mostrar";
                }
            }else{
                $vrResultado['resultado'] = 1;
                $vrResultado['mensaje'] = "Ocurrió un error al ejecutar la consulta";
                $vrResultado['error'] = $this->error;
                $vrArchivo = fopen("../log_error.txt", "w");
                fwrite($vrArchivo, $this->trQuery.$vrResultado['error']);
                fclose($vrArchivo);
            }
        }else{
            $vrResultado['resultado'] = 1;
            $vrResultado['mensaje'] = "No se tiene una consulta";
        }
        return json_encode($vrResultado);
    }
    public function mtAplicar(){
        if($this->trQuery){
            $this->set_charset("utf8");
            $vrRegistros = $this->query($this->trQuery);
            if($vrRegistros){
                $vrResultado['resultado'] = 5;
                $vrResultado['mensaje'] = "La actualización se realizó con éxito";
                $vrResultado['registro'] = $this->insert_id;
            }else{
                $vrResultado['resultado'] = 1;
                $vrResultado['mensaje'] = "Ocurrió un error al actualizar la información";
                $vrResultado['error'] = $this->error;
                $vrArchivo = fopen("../log_error.txt", "w");
                fwrite($vrArchivo, $this->trQuery.$vrResultado['error']);
                fclose($vrArchivo);
            }
        }else{
            $vrResultado['resultado'] = 1;
            $vrResultado['mensaje'] = "No se tiene una consulta";
        }
        return json_encode($vrResultado);
    }
}
?>