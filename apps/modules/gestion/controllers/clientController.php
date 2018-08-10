<?php

/**
 * Geekode php (http://geekode.net/)
 * @link    https://github.com/remicioluis/geekcode_php
 * @author  Luis Remicio @remicioluis (https://twitter.com/remicioluis)
 * @version 2.0
 */

class clientController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new clientModels();
    }

    public function vista_client($p){        
        $this->view('client/form_index.php', $p);
    }

   public function get_list_client($p){
        $rs = $this->objDatos->get_list_client($p);
        //var_export($rs);
        $array = array();
        $lote = 0;
        foreach ($rs as $index => $value){
            $value_['shi_codigo'] = intval($value['shi_codigo']);
            $value_['shi_nombre'] = utf8_encode(trim($value['shi_nombre']));
            $value_['fec_ingreso'] = substr(trim($value['fec_ingreso']),0,10);
            //substr(trim($value['fec_ingreso']),0,10)
            $value_['shi_estado'] = trim($value['shi_estado']);
            $value_['id_user'] = trim($value['id_user']);
            $value_['fecact'] = utf8_encode(trim($value['fecact']));
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

    public function set_client($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_client($p);
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