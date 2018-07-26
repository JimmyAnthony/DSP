<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class lotizerController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new lotizerModels();
    }

    public function vista_lotizador($p){        
        $this->view('lotizer/form_index.php', $p);
    }

   public function get_list_lotizer($p){
        $rs = $this->objDatos->get_list_lotizer($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['cod_lote'] = intval($value['cod_lote']);
                $value_['lote'] = utf8_encode(trim($value['lote']));
                $value_['fecha'] = substr(trim($value['fecha_ingre']),0,10) ;
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
                $value_['cantidad'] = intval($value['ctdad_pqt']);
                $array[]=$value_;
        }
        $data = array(
            'success' => true,
            'error'=>0,
            'total' => count($array),
            'data' => $array
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }

   public function get_lotizer_detalle($p){
        $rs = $this->objDatos->get_lotizer_detalle($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['lote'] = utf8_encode(trim($value['lote']));
                $value_['paquete'] = utf8_encode(trim($value['paquete']));                
                $value_['cod_paquete'] = utf8_encode(trim($value['cod_paquete']));
                $value_['fecha'] = substr(trim($value['fecha_ingre']),0,10) ;
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
                $value_['ctdad_docs'] = intval($value['ctdad_docs']);
                $array[]=$value_;
        }
        $data = array(
            'success' => true,
            'error'=>0,
            'total' => count($array),
            'data' => $array
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }

    public function setRegisterLotizer($p){
        //$this->valida_mobil($p);
    /*    header("Content-Type: text/plain");
        $target_path = basename( $_FILES['uploadedfile']['name']);

        if(!empty($_FILES['uploadedfile']['name'])){
            $aleatorio = rand();
            $narchivo = explode('.', $_FILES['uploadedfile']['name']);
            $nombre_archivo = 'campana_'.$aleatorio.'.'.$narchivo[1];
            $dir = "campana/" . $nombre_archivo;
            $p['vp_shi_logo']=$nombre_archivo;

            if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$dir)) {
                $rs = $this->objDatos->setRegisterShipper($p);
                $rs = $rs[0];
                //var_export($rs);
                if ($rs['status'] == 'OK' ){
                    $men = "{success: true,error:0,data:'Información se guardo correctamente',close:0}";
                }else{
                    unlink($dir);
                    $men =  "{success: true,error:1, errors: 'Error al registrar la información',close:0}";    
                }
            } else{
                $men =  "{success: true,error:1, errors: 'No se logro subir la imagen al servidor',close:0}";
            }
        }else{*/
            $rs = $this->objDatos->setRegisterLotizer($p);
            $rs = $rs[0];
            //var_export($rs);
            $nuevo = $rs['status'];
            //alert("Hola");

            if ($rs['status'] == 'OK' ){
                $men = "{success: true,error:0,data:'Información se guardo correctamente',close:0}";
            }else{
                //unlink($dir);
               // $men = $rs['status'];
                $men =  "{success: true,error:1, errors: 'Error al registrar la información',close:0}";    
            }
        //}
        return $men;
    }




}