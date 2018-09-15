<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class controlController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new controlModels();
    }

    public function index($p){        
        $this->view('control/form_index.php', $p);
    }

   public function get_list($p){
        $rs = $this->objDatos->get_list($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['cod_lote'] = intval($value['cod_lote']);
                $value_['lote'] = utf8_encode(trim($value['lote']));
                $value_['fecha'] = substr(trim($value['fecha_ingre']),0,10) ;
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
                $value_['cantidad'] = intval($value['cantidad']);
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
                $json.=',"id_det":"'.$value['id_det'].'"';
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
                $json.=',"id_det":"'.$value['id_det'].'"';
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
    public function get_load_page($p){
        $rs = $this->objDatos->get_load_page($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['id_pag'] = intval($value['id_pag']);
                $value_['id_det'] = intval($value['id_det']);
                $value_['id_lote'] = intval($value['id_lote']);
                $value_['path'] = utf8_encode(trim($value['path']));
                $value_['file'] = utf8_encode(trim($value['img']));
                $value_['imgorigen'] = utf8_encode(trim($value['imgorigen']));
                $value_['lado'] = utf8_encode(trim($value['lado']));
                $value_['ocr'] = utf8_encode(trim($value['ocr']));
                $value_['orden'] = intval($value['orden']);
                $value_['estado'] = utf8_encode(trim($value['estado']));
                $value_['include'] ='Y';
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
    public function set_list_page_trazos($p){
        $rs = $this->objDatos->get_list_page_trazos($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $p['vp_id_pag'] = intval($value['id_pag']);
                $p['vp_path'] = utf8_encode(trim($value['path']));
                $p['vp_img'] = utf8_encode(trim($value['img']));
                $p['vp_cod_trazo'] = intval($value['cod_trazo']);
                $p['vp_x'] = floatval(trim($value['x']));
                $p['vp_y'] = floatval(trim($value['y']));
                $p['vp_w'] = floatval(trim($value['w']));
                $p['vp_h'] = floatval(trim($value['h']));

                $p['vp_wo'] = floatval(trim($value['wo']));
                $p['vp_ho'] = floatval(trim($value['wo']));

                $path_parts = pathinfo(PATH.'public_html'.$p['vp_path'].$p['vp_img']);
                $p['extension']=$path_parts['extension'];
                $status=$this->setDropImg($p);

                $value_['id_det'] =intval($value['id_det']);
                $value_['id_lote'] =intval($value['id_lote']);
                $value_['id_pag'] =intval($value['id_pag']);
                $value_['cod_trazo'] =intval($value['cod_trazo']);
                $value_['extension'] =$p['extension'];
                $value_['tipo'] =utf8_encode(trim($value['tipo']));
                if($status){
                    $array[]=$value_;
                }
                $data = array('success' => true,'error' => $status?'OK':'ER','msn' => $status=='OK'?'Procesado correctamente':'Ocurrio un error al generar el trazo','data'=>$array);
        }
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function setDropImg($p){
        $bool=true;
        //$path_parts = pathinfo(PATH.'public_html'.$p['vp_path'].$p['vp_img']);
        $ext=$p['extension'];
        $src_original = PATH.'public_html'.$p['vp_path'].$p['vp_img'];
        $src_guardar  = PATH.'public_html/tmp_trazos/'.$p['vp_id_pag'].'-'.$p['vp_cod_trazo'].'-trazo.'.$ext;
        try {
            $destImage = imagecreatetruecolor($p['vp_w'], $p['vp_h']);
            #$sourceImage = imagecreatefromjpeg($src_original);

            switch($ext){
                case 'bmp': $sourceImage = imagecreatefromwbmp($src_original); break;
                case 'gif': $sourceImage = imagecreatefromgif($src_original); break;
                case 'jpg': $sourceImage = imagecreatefromjpeg($src_original); break;
                case 'png': $sourceImage = imagecreatefrompng($src_original); break;
                default : return "Unsupported picture type!";
            }
            if($ext == "gif" or $ext == "png"){
                imagecolortransparent($destImage, imagecolorallocatealpha($destImage, 0, 0, 0, 127));
                imagealphablending($destImage, false);
                imagesavealpha($destImage, true);
            }

            imagecopyresampled($destImage, $sourceImage, 0, 0, number_format($p['vp_x'], 4, '.', ''), number_format($p['vp_y'], 4, '.', ''), number_format($p['vp_w'], 4, '.', ''), number_format($p['vp_h'], 4, '.', ''), number_format($p['vp_w'], 4, '.', ''), number_format($p['vp_h'], 4, '.', '')); 

            switch($ext){
                case 'bmp': imagewbmp($destImage, $src_guardar); break;
                case 'gif': imagegif($destImage, $src_guardar); break;
                case 'jpg': imagejpeg($destImage, $src_guardar); break;
                case 'png': imagepng($destImage, $src_guardar); break;
            }
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            $bool=false;
        }
        return $bool;
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
        $string = str_replace(array("\\"), 't', $string);
        return str_replace(array("\n\r", "\n", "\r","'","\\"), '', $string);
    }
    public function set_ocr_pages($p){
        //header("Content-Type: text/html; charset=UTF-8");
        $p['vp_recordsToSend']=$this->strip_carriage_returns(utf8_decode($p['vp_recordsToSend']));
        $records = json_decode(stripslashes($p['vp_recordsToSend'])); //parse the string to PHP objects
        //var_export($p['vp_recordsToSend']);
        if(isset($records)){
            $records1=$records;
            foreach($records1 as $record1){
                if((int)$record1->cod_trazo==0){
                    
                    $pp['vp_text']=$this->strip_carriage_returns(utf8_decode($record->text));
                    $pp['vp_op']='X';
                    $pp['vp_id_pag']=$record1->id_pag;
                    $pp['vp_cod_trazo']='0';
                    $pp['vp_id_det']=$record1->id_det;
                    $pp['vp_id_lote']=$record1->id_lote;

                    $rs = $this->objDatos->set_ocr_pages($pp);
                    $rs = $rs[0];
                    $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));
                }
            }

            foreach($records as $record){
                if((int)$record->cod_trazo!=0){
                    $px['vp_op']='I';
                    $px['vp_id_pag']=$record->id_pag;
                    $px['vp_cod_trazo']=$record->cod_trazo;
                    $px['vp_id_det']=$record->id_det;
                    $px['vp_id_lote']=$record->id_lote;
                    $px['vp_text']=$this->strip_carriage_returns(utf8_decode($record->text));

                    $rs = $this->objDatos->set_ocr_pages($px);
                    $rs = $rs[0];
                    $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));
                }
            }

        }else{
            $data = array('success' => true,'error' => 'ER','msn' => 'No existen textos a procesar');
        }

        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function set_lotizer($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->set_lotizer($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
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