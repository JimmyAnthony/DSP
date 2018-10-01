<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class trackingController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new trackingModels();
    }

    public function index($p){        
        $this->view('tracking/form_index.php', $p);
    }

   public function get_list_history($p){
        $rs = $this->objDatos->get_list_history($p);
        //var_export($rs);
        $array = array();
        $lote = 0;
        foreach ($rs as $index => $value){
            $value_['id_estado'] = intval($value['id_estado']);
            $value_['id_lote'] = intval($value['id_lote']);
            $value_['shi_codigo'] = intval($value['shi_codigo']);
            $value_['lot_estado'] = utf8_encode(trim($value['lot_estado']));
            $value_['usr_nombre'] = utf8_encode(trim($value['usr_nombre']));
            $value_['fecact'] = trim($value['fecact']);
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
            return '{"text": ".","children":['.$this->get_recursivo(1,0).']}';
            
        }else{
            return '';
        }
    }

    public function get_recursivo($_nivel,$_hijo){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            $_hijo=((int)$_nivel==1)?$value['hijo']:$_hijo;
            if($value['nivel'] == $_nivel && (int)$value['padre'] == (int)$_hijo){
                $json.=$coma."{";
                $json.='"hijo":"'.$value['hijo'].'"';
                $json.=',"padre":"'.$value['padre'].'"';
                $json.=',"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                //$json.=',"read":true';
                //$json.=',"expanded":true';
                $json.=',"iconCls":"task"';
                $json.=',"lot_estado":"'.$value['lot_estado'].'"';
                $json.=',"tipdoc":"'.$value['tipdoc'].'"';
                $json.=',"nombre":"'.utf8_encode(trim($value['nombre'])).'"';
                $json.=',"lote_nombre":"'.utf8_encode(trim($value['lote_nombre'])).'"';
                $json.=',"descripcion":"'.utf8_encode(trim($value['descripcion'])).'"';
                $json.=',"path":"'.utf8_encode(trim($value['path'])).'"';
                $json.=',"img":"'.utf8_encode(trim($value['img'])).'"';
                $json.=',"fecha":"'.$value['fecha'].'"';
                $json.=',"tot_folder":"'.$value['tot_folder'].'"';
                $json.=',"tot_pag":"'.$value['tot_pag'].'"';
                $json.=',"tot_errpag":"'.$value['tot_errpag'].'"';
                $json.=',"usr_update":"'.$value['usr_update'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"estado":"'.$value['estado'].'"';
                $json.=',"nivel":"'.$value['nivel'].'"';
                unset($this->rs_[$key]);
                $js = $this->get_recursivo((int)$value['nivel']+1,$value['hijo']);
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
    
    public function get_recursivo_hijos($_nivel,$_hijo){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            if($value['nivel'] == $_nivel && (int)$value['padre'] == (int)$_hijo){
                $json.=$coma."{";
                $json.='"hijo":"'.$value['hijo'].'"';
                $json.=',"padre":"'.$value['padre'].'"';
                $json.=',"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                //$json.=',"read":true';
                //$json.=',"expanded":true';
                $json.=',"iconCls":"task"';
                $json.=',"lot_estado":"'.$value['lot_estado'].'"';
                $json.=',"tipdoc":"'.$value['tipdoc'].'"';
                $json.=',"nombre":"'.utf8_encode(trim($value['nombre'])).'"';
                $json.=',"lote_nombre":"'.utf8_encode(trim($value['lote_nombre'])).'"';
                $json.=',"descripcion":"'.utf8_encode(trim($value['descripcion'])).'"';
                $json.=',"path":"'.utf8_encode(trim($value['path'])).'"';
                $json.=',"img":"'.utf8_encode(trim($value['img'])).'"';
                $json.=',"fecha":"'.$value['fecha'].'"';
                $json.=',"tot_folder":"'.$value['tot_folder'].'"';
                $json.=',"tot_pag":"'.$value['tot_pag'].'"';
                $json.=',"tot_errpag":"'.$value['tot_errpag'].'"';
                $json.=',"usr_update":"'.$value['usr_update'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"estado":"'.$value['estado'].'"';
                $json.=',"nivel":"'.$value['nivel'].'"';
                unset($this->rs_[$key]);
                $js = $this->get_recursivo_hijos((int)$value['nivel']+1,$value['hijo']);
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
                $value_['pathorigen'] = utf8_encode(trim($value['pathorigen']));
                $value_['imgorigen'] = utf8_encode(trim($value['imgorigen']));
                $value_['texto'] = utf8_encode(trim($value['texto']));
                $value_['estado'] = utf8_encode(trim($value['estado']));
                $value_['width'] = intval($value['width']);
                $value_['height'] = intval(trim($value['height']));
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
}