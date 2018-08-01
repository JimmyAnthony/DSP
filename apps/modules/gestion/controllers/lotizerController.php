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
                $value_['id_lote'] = intval($value['id_lote']);
                $value_['tipdoc'] = utf8_encode(trim($value['tipdoc']));
                $value_['nombre'] = utf8_encode(trim($value['nombre']));
                $value_['fecha'] = substr(trim($value['fecha']),0,10) ;
                $value_['tot_folder'] = utf8_encode(trim($value['tot_folder']));
                $value_['id_user'] = utf8_encode(trim($value['id_user']));
                $value_['estado'] = utf8_encode(trim($value['estado']));
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
                $value_['nombre'] = utf8_encode(trim($value['nombre']));                
                $value_['id_det'] = intval($value['id_det']);
                $value_['fecha'] = substr(trim($value['fecha']),0,10) ;
                $value_['tot_pag'] = intval($value['tot_pag']);
                $value_['tot_pag_err'] = intval($value['tot_pag_err']);
                $value_['estado'] = utf8_encode(trim($value['estado']));
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

    public function set_lotizer($p){
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
            $rs = $this->objDatos->set_lotizer($p);
            $rs = $rs[0];
            //var_export($rs);
            $nuevo = $rs['status'];
            /*
                            global.Msg({
                                msg: '¿Está de ....?',
                                icon: 3,
                                buttons: 3,
                            });

*/
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