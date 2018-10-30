<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */
error_reporting(NULL);
set_time_limit(1000);
ini_set("memory_limit", "-1");
class reorderController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new reorderModels();
    }

    public function index($p){        
        $this->view('reorder/form_index.php', $p);
    }

    public function get_list_lotizer($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_lotizer($p);
        if(!empty($this->rs_)){
            return '{"text": ".","children":['.$this->get_recursivo(0,'',true).']}';
            
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

    public function get_recursivo($_nivel,$_hijo,$bool){
        $coma = '';
        //var_export($this->rs_);
        foreach ($this->rs_ as $key => $value){
            if($bool)$_hijo=$value['hijo'];

            if($value['nivel'] > $_nivel && (int)$value['padre'] == (int)$_hijo){
                $json.=$coma."{";
                $json.='"hijo":"'.$value['hijo'].'"';
                $json.=',"padre":"'.$value['padre'].'"';
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
                $js = $this->get_recursivo($value['nivel'],$value['hijo'],false);
                if(!empty($js)){
                    $json.=',"children":['.trim($js).']';
                }else{
                    if((int)$value['nivel']==2){
                        $json.=',"children":[]';
                    }else{
                        $json.=',"leaf":"true"';
                    }
                }
                $json.="}";
                $coma = ",";
            }
        }
        return $json;
    }
    public function strip_carriage_returns($string){
        $badchar=array(
            // control characters
            chr(0), chr(1), chr(2), chr(3), chr(4), chr(5), chr(6), chr(7), chr(8), chr(9), chr(10),
            chr(11), chr(12), chr(13), chr(14), chr(15), chr(16), chr(17), chr(18), chr(19), chr(20),
            chr(21), chr(22), chr(23), chr(24), chr(25), chr(26), chr(27), chr(28), chr(29), chr(30),
            chr(31),
            // non-printing characters
            chr(127)
        );
        $string = str_replace($badchar, '', $string);
        $string = str_replace(array('\"'), "'", $string);
        $string = str_replace(array("\\"), 't', $string);
        $string = str_replace(array("`"), '', $string);
        $string = str_replace(array("|"), ' ', $string);
        return str_replace(array("\n\r", "\n", "\r","'","\\",'\"'), '', $string);
    }
    public function set_reorder($p){
        header("Content-Type: text/html; charset=UTF-8");
        //$p['vp_recordsToSend']=$this->cp1250_to_utf2($this->normalize($this->strip_carriage_returns(utf8_decode($p['vp_recordsToSend']))));
        //$data = $p['vp_recordsToSend'];
        //$data = str_replace(array('\"'), "", $data);
        //$data = str_replace(array("'"), "", $data);
        //$data =utf8_decode($data);
        //$data =$this->strip_carriage_returns($data);
        //$data =$this->hyphenize($data);
        //$data =$this->decode($data);
        //$data =$this->cp1250_to_utf2($data);
        //$data =$this->normalize($data);
        //$data =stripslashes($data);
        //echo $data;
        //$records = json_decode($data); //parse the string to PHP objects
        $records = json_decode(stripslashes($p['vp_recordsToSend']), true);
        //echo $records;
        //echo $data;
        //var_export($records);
        $bool=true;
        if(!empty($records)){
            $pp['vp_op']='D';
            $pp['vp_id_lote']=$p['vp_id_lote'];
            $rs = $this->objDatos->set_reorder($pp);
            $x=1;
            foreach($records as $record){
                //$record=$record[$id];
                //$record=$record[0];
                //var_export($record);
                $pp['vp_op']='R';
                $pp['vp_id_lote']=$record['vp_id_lote'];
                $pp['vp_nivel']=$record['vp_nivel'];
                $pp['vp_hijo']=$record['vp_hijo'];
                $pp['vp_padre']=$record['vp_padre'];
                $pp['vp_nombre']=$record['vp_nombre'];
                $pp['vp_order']=''+$x;
                $x+=1;
                $rs = $this->objDatos->set_reorder($pp);
                $rs = $rs[0];
                if($rs['status']=='ER'){
                    $bool=false;
                }
            }

            if($bool){
                $pp['vp_op']='C';
                $pp['vp_id_lote']=$p['vp_id_lote'];
                $rs = $this->objDatos->set_reorder($pp);
                $rs = $rs[0];
                $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));
            }else{
                $data = array('success' => true,'error' => 'ER','msn' => utf8_encode('Error al tratar de registrar el orden de los registros.'));
            }
        }else{
            $data = array('success' => true,'error' => 'ER','msn' => 'No existen registros a procesar');
        }

        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function setChangeRecord($p){
        //$this->valida_mobil($p);
        $rs = $this->objDatos->set_reorder($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
}