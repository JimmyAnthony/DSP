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
    public function get_list_clientcontratos($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_clientcontratos($p);
        if(!empty($this->rs_)){
            return '{"text": ".","children":['.$this->get_recursivo(1).']}';
            
        }else{
            return json_encode(
                array(
                    'text'=>'root',
                    'children'=>array(
                        'shi_codigo'=>0,
                        'iconCls'=>'task',
                        'shi_nombre'=>'',
                        'fec_ingreso'=>'',
                        'shi_estado'=>'1',
                        'id_user'=>0,
                        'fecact'=>'',
                        'cod_contrato'=>0,
                        'pro_descri'=>'',
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
                $json.='"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"shi_nombre":"'.utf8_encode(trim($value['shi_nombre'])).'"';
                $json.=',"iconCls":"task"';
                $json.=',"fec_ingreso":"'.$value['fec_ingreso'].'"';
                $json.=',"shi_estado":"'.$value['shi_estado'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"fecact":"'.$value['fecact'].'"';
                $json.=',"cod_contrato":"'.$value['cod_contrato'].'"';
                $json.=',"pro_descri":"'.$value['pro_descri'].'"';
                $json.=',"nivel":"'.$value['nivel'].'"';
                $js = $this->getRecursividad_children($_nivel,$value['shi_codigo'],$value['shi_estado']);
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
            if ($value['nivel'] != $_nivel && $value['shi_codigo'] == $_hijo){
                $json.=$coma."{";
                $json.='"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"shi_nombre":"'.utf8_encode(trim($value['shi_nombre'])).'"';
                $json.=',"iconCls":"task"';
                $json.=',"fec_ingreso":"'.$value['fec_ingreso'].'"';
                $json.=',"shi_estado":"'.$value['shi_estado'].'"';
                $json.=',"id_user":"'.$value['id_user'].'"';
                $json.=',"fecact":"'.$value['fecact'].'"';
                $json.=',"cod_contrato":"'.$value['cod_contrato'].'"';
                $json.=',"pro_descri":"'.$value['pro_descri'].'"';
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

    public function set_contrato($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_contrato($p);
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