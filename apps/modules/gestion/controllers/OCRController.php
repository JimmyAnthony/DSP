<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class OCRController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new OCRModels();
    }

    public function index($p){        
        $this->view('OCR/form_index.php', $p);
    }

   public function get_ocr_plantillas($p){
        $rs = $this->objDatos->get_ocr_plantillas($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['cod_plantilla'] = intval($value['cod_plantilla']);
                $value_['shi_codigo'] = intval(trim($value['shi_codigo']));
                $value_['fac_cliente'] = intval(trim($value['fac_cliente']));
                $value_['nombre'] = utf8_encode(trim($value['nombre']));
                $value_['cod_formato'] = utf8_encode(trim($value['cod_formato']));
                $value_['tot_trazos'] = intval(trim($value['tot_trazos']));
                $value_['path'] = utf8_encode(trim($value['path']));
                $value_['img'] = utf8_encode(trim($value['img']));
                $value_['texto'] = utf8_encode(trim($value['texto']));
                $value_['estado'] = utf8_encode(trim($value['estado']));
                $value_['width'] = intval($value['w']);
                $value_['height'] = intval(trim($value['h']));
                $value_['width_formato'] = intval($value['width_formato']);
                $value_['height_formato'] = intval(trim($value['height_formato']));
                $value_['fecha'] = trim($value['fecha']);
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
                $value_['formato'] = utf8_encode($value['formato']);
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

    public function get_ocr_trazos($p){
        $rs = $this->objDatos->get_ocr_trazos($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['cod_trazo'] = intval($value['cod_trazo']);
                $value_['cod_plantilla'] = intval(trim($value['cod_plantilla']));
                $value_['nombre'] = utf8_encode(trim($value['nombre']));
                $value_['tipo'] = utf8_encode(trim($value['tipo']));
                $value_['x'] = floatval(trim($value['x']));
                $value_['y'] = floatval(trim($value['y']));
                $value_['w'] = floatval(trim($value['w']));
                $value_['h'] = floatval(trim($value['h']));
                $value_['path'] = utf8_encode(trim($value['path']));
                $value_['img'] = utf8_encode(trim($value['img']));
                $value_['texto'] = utf8_encode(trim($value['texto']));
                $value_['estado'] = utf8_encode(trim($value['estado']));
                $value_['fecha'] = trim($value['fecha']) ;
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
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
    public function set_ocr_trazos($p){
        //$this->valida_mobil($p);
        $rs = $this->objDatos->set_ocr_trazos($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function get_list_shipper($p){
        $rs = $this->objDatos->get_list_shipper($p);
        //var_export($rs);
        $array = array();
        $lote = 0;
        foreach ($rs as $index => $value){
            $value_['shi_codigo'] = intval($value['shi_codigo']);
            $value_['shi_nombre'] = utf8_encode(trim($value['shi_nombre']));
            $value_['shi_logo'] = utf8_encode(trim($value['shi_logo']));
            $value_['fec_ingreso'] = trim($value['fec_ingreso']);
            $value_['shi_estado'] = intval(trim($value['shi_estado']));
            $value_['id_user'] = intval(trim($value['id_user']));
            $value_['fecha_actual'] = utf8_encode(trim($value['fecha_actual']));
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
    public function get_list_contratos($p){
        $rs = $this->objDatos->get_list_contratos($p);
        //var_export($rs);
        $array = array();
        $lote = 0;
        foreach ($rs as $index => $value){
            $value_['fac_cliente'] = intval($value['fac_cliente']);
            $value_['cod_contrato'] = intval($value['cod_contrato']);
            $value_['pro_descri'] = utf8_encode(trim($value['pro_descri']));
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
    public function get_list_lotizer($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_lotizer($p);
        if(!empty($this->rs_)){
            return '{"text": ".","children":['.$this->get_recursivo(1).']}';
            
        }else{
            return json_encode(
                array(
                    'text'=>'root',
                    'children'=>array(
                        'id_lote'=>0,
                        'iconCls'=>'task',
                        'tipdoc'=>'',
                        'nombre'=>'',
                        'fecha'=>'',
                        'tot_folder'=>0,
                        'tot_pag'=>0,
                        'tot_errpag'=>0,
                        'id_user'=>0,
                        'estado'=>'',
                        'leaf'=>'true'
                        )
                    )
                );
        }
    }

    public function get_recursivo($_nivel){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            if ($value['nivel'] == $_nivel){
                $json.=$coma."{";
                $json.='"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                //$json.=',"read":true';
                //$json.=',"expanded":true';
                $json.=',"iconCls":"task"';
                $json.=',"lot_estado":"'.utf8_encode(trim($value['lot_estado'])).'"';
                $json.=',"tipdoc":"'.$value['tipdoc'].'"';
                $json.=',"nombre":"'.utf8_encode(trim($value['nombre'])).'"';
                $json.=',"lote_nombre":"'.utf8_encode(trim($value['lote_nombre'])).'"';
                $json.=',"descripcion":"'.utf8_encode(trim($value['descripcion'])).'"';
                $json.=',"fecha":"'.$value['fecha'].'"';
                $json.=',"tot_folder":"'.$value['tot_folder'].'"';
                $json.=',"tot_pag":"'.$value['tot_pag'].'"';
                $json.=',"tot_errpag":"'.$value['tot_errpag'].'"';
                $json.=',"usr_update":"'.$value['usr_update'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"estado":"'.$value['estado'].'"';
                $json.=',"nivel":"'.$value['nivel'].'"';
                $js = $this->getRecursividad_children($_nivel,$value['id_lote']);
                if(!empty($js)){
                    $json.=',"children":['.trim($js).']';
                }else{
                    $json.=',"leaf":"true"';
                }
                $json.="}";
                $coma = ",";
            }
        }
        return $json;
    }
    public function getRecursividad_children($_nivel,$_hijo){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            if ($value['nivel'] != $_nivel && $value['id_lote'] == $_hijo){
                $json.=$coma."{";
                $json.='"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                $json.=',"iconCls":"task"';
                $json.=',"expanded":true';
                $json.=',"lot_estado":"'.utf8_encode(trim($value['lot_estado'])).'"';
                $json.=',"tipdoc":"'.$value['tipdoc'].'"';
                $json.=',"nombre":"'.utf8_encode(trim($value['nombre'])).'"';
                $json.=',"lote_nombre":"'.utf8_encode(trim($value['lote_nombre'])).'"';
                $json.=',"descripcion":"'.utf8_encode(trim($value['descripcion'])).'"';
                $json.=',"fecha":"'.$value['fecha'].'"';
                $json.=',"tot_folder":"'.$value['tot_folder'].'"';
                $json.=',"tot_pag":"'.$value['tot_pag'].'"';
                $json.=',"tot_errpag":"'.$value['tot_errpag'].'"';
                $json.=',"usr_update":"'.$value['usr_update'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"estado":"'.$value['estado'].'"';
                $json.=',"nivel":"'.$value['nivel'].'"';
                $js = '';//$this->getRecursividad_children($_nivel,$value['id_lote']);
                if(!empty($js)){
                    $json.=',"children":['.trim($js).']';
                }else{
                    $json.=',"leaf":"true"';
                }
                $json.="}";
                 $coma = ",";
            }
        }
        return $json;
    }
    public function getImg_tiff($img){
        /*$output = array();$file2 = '0001_'.rand(0,9999999);
        $file = trim($img);$file = str_replace('.TIF', '', $file);
        $path = REALPATHAPP.'apps/public/imagenes'.$file;
        //echo REALPATHAPP.'apps/public/imagenes/convert.sh '.$path.' '.REALPATHAPP.'apps/public/imagenes/'.$file2;
        $a = exec(REALPATHAPP.'apps/public/imagenes/convert.sh '.$path.' '.REALPATHAPP.'apps/public/imagenes/'.$file2, $output);            
        return $file2;*/
    }
    public function delete_tiff($p){
        /*$path = REALPATHAPP.'apps/public/imagenes/'.trim($p['img']).'.jpg';
        unlink($path);*/
    }

}