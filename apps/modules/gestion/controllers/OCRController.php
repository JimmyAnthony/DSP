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

class OCRController extends AppController {

    private $objDatos;
    private $arrayMenu;
    private $puntero=0;

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
    public function setCopyFile($p){
        $bool=false;
        try {
            if (!file_exists(PATH.'public_html/plantillas/'.$p['vp_shi_codigo'])) {
                mkdir(PATH.'public_html/plantillas/'.$p['vp_shi_codigo'], 0777, true);
            }
            $path_parts = pathinfo(PATH.'public_html'.$p['vp_pathorigen'].$p['vp_imgorigen']);
            $ext=$path_parts['extension'];
            copy(PATH.'public_html'.$p['vp_pathorigen'].$p['vp_imgorigen'], PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_cod_plantilla'].'-plantilla.'.$ext);
            $bool=true;
        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
            $bool=false;
        }
        return $bool;
    }
    public function set_ocr_plantilla($p){
        $path_parts = pathinfo(PATH.'public_html'.$p['vp_pathorigen'].$p['vp_imgorigen']);
        $ext=$path_parts['extension'];
        $p['vp_path']='/plantillas/'.$p['vp_shi_codigo'].'/';
        $p['vp_img']='.'.$ext;

        $rs = $this->objDatos->set_ocr_plantilla($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );

        $p['vp_cod_plantilla']=$rs['cod_plantilla'];
        
        if($rs['status']!='ER'){
            $bool=$this->setCopyFile($p);
        }
        
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
    public function set_ocr_trazos($p){
        //$this->valida_mobil($p);
        if($p['vp_op']!='D'){
            $img=$p['vp_img'];
            $path_parts = pathinfo(PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_img']);
            $ext=$path_parts['extension'];
            $p['extension']=$ext;
            $p['vp_path'] = '/plantillas/'.$p['vp_shi_codigo'].'/'; 
            $p['vp_img']  = '.'.$ext;   
        }

        $rs = $this->objDatos->set_ocr_trazos($p);
        $rs = $rs[0];
        if($p['vp_op']!='D'){
            $imagen = $p['vp_path'].$rs['cod_trazo'].'-trazo'.$p['vp_img'];
        }else{
            $imagen = $p['vp_path'].$p['vp_imagen_trazo'];
        }

        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'cod_trazo' => $rs['cod_trazo'],
            'img' => $imagen,
            'msn' => utf8_encode(trim($rs['response']))
        );

        if($rs['status']!='ER'){
            if($p['vp_op']!='D'){
                $p['vp_img'] =$img;
                $p['vp_cod_trazo']=$rs['cod_trazo'];

                if($p['vp_op']=='U'){
                    $file = PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_imagen_trazo'];
                    if (file_exists($file)) {
                        unlink($file);
                    }
                }

                $bool=$this->setDropImg($p);
            }else{
                $file = PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_imagen_trazo'];
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function setDropImg($p){
        $bool=false;
        $img=$p['vp_img'];
        #$path_parts = pathinfo($p['vp_img']);
        $ext=$p['extension'];
        $src_original = PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_cod_plantilla'].'-plantilla.'.$ext;
        $src_guardar  = PATH.'public_html/plantillas/'.$p['vp_shi_codigo'].'/'.$p['vp_cod_trazo'].'-trazo.'.$ext;
        try {
            $destImage = imagecreatetruecolor(number_format($p['vp_w'], 4, '.', ''), number_format($p['vp_h'], 4, '.', ''));
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