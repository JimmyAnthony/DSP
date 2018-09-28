<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class returnController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new returnModels();
    }

    public function vista_return($p){        
        $this->view('return/form_index.php', $p);
    }

    public function get_lista_devoluciones($p){
        $rs = $this->objDatos->get_lista_devoluciones($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['id_dev'] = intval($value['id_dev']);
                $value_['fecha'] = utf8_encode(trim($value['fecha']));
                $value_['hora'] = utf8_encode(trim($value['hora']));
                $value_['motivo'] = utf8_encode(trim($value['motivo']));
                $value_['responsable'] = utf8_encode(trim($value['responsable']));
                $value_['documento'] = utf8_encode(trim($value['documento']));
                $value_['mensaje'] = utf8_encode(trim($value['mensaje']));
                $value_['tot_lotes'] = intval($value['tot_lotes']);
                $value_['tot_folders'] = intval($value['tot_folders']);
                $value_['estado'] = utf8_encode(trim($value['estado']));
                $value_['fecha_registro'] = utf8_encode(trim($value['fecha_registro']));
                $value_['usr_nombre'] = utf8_encode(trim($value['usr_nombre']));
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
    public function get_list_pre_return($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_pre_return($p);
        if(!empty($this->rs_)){
            return '{"text": ".","children":['.$this->get_recursivo(1,0).']}';
            
        }else{
            return '';
        }
    }
    public function get_list_pending_return($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_pending_return($p);
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
                $json.=',"id_dev":"'.$value['id_dev'].'"';
                $json.=',"usr_dev":"'.$value['usr_dev'].'"';
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
    public function getRecursividad_children($_nivel,$_hijo,$_stado_lote){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            if ($value['nivel'] != $_nivel && $value['id_lote'] == $_hijo){
                $json.=$coma."{";
                $json.='"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
               $json.=',"id_det":"'.$value['id_det'].'"';                
                $json.=',"iconCls":"task"';
                $json.=',"lot_estado":"'.utf8_encode(trim($_stado_lote)).'"';
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

  public function set_return($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_return($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response'])),
            'id_dev' => $rs['id_dev']
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }

     public function set_pre_return($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_pre_return($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response'])),
            'id_dev' => $rs['id_dev']
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }


    public function set_lotizer($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_lotizer($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => ($rs['status']=='OK')?'1':'0',
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
}