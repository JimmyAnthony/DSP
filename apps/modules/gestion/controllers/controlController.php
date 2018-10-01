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

class controlController extends AppController {

    private $objDatos;
    private $arrayMenu;
    static $imap_base64 ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+,';

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
            return '';
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
                $value_['id_pag_error'] = intval($value['id_pag_error']);
                $value_['msg_error'] = utf8_encode(trim($value['msg_error']));
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
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $rs = $this->objDatos->get_list_page_trazos($p);
        //var_export($rs);
        $array = array();
        $page=$p['vp_id_pag'];
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
        //header('Content-Type: application/json');
        //return $this->response($data);
        $p['vp_id_pag']=$page;
        $data=$this->setProcessingOCR($p);
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function setDropImg($p){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
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
    public function setProcessingOCR($p){

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
        $params = base64_encode(PATH . '&' . trim($p['vp_id_pag']) . '&' . trim($p['vp_shi_codigo']) . '&' . trim($p['vp_id_det']). '&' . trim($p['vp_id_lote']));
        $comando = "python " . PATH . "apps/modules/gestion/views/control/python/OCR.py " . $params;
        $output = array();
        //echo $comando;die();
        try{
            exec($comando, $output);

        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        $data = array('success' => true,'error' => $output[0],'msn' => utf8_encode(trim($output[1])));
        //header('Content-Type: application/json');
        return $data;
    }
    public function hyphenize($string) {
        $dict = array(
            "I'm"      => "I am",
            "thier"    => "their",
            // Add your own replacements here
        );
        return strtolower(
            preg_replace(
              array( '#[\\s-]+#', '#[^A-Za-z0-9\. -]+#' ),
              array( '-', '' ),
              // the full cleanString() can be downloaded from http://www.unexpectedit.com/php/php-clean-string-of-utf8-chars-convert-to-similar-ascii-char
              $this->cleanString(
                  str_replace( // preg_replace can be used to support more complicated replacements
                      array_keys($dict),
                      array_values($dict),
                      urldecode($string)
                  )
              )
            )
        );
    }

    public function cleanString($text) {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );
        return preg_replace(array_keys($utf8), array_values($utf8), $text);
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
    public function normalize ($string) {
        $table = array(
            'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
            'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
            'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
            'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
            'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
            'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
        );
        return strtr($string, $table);
    }
    public function cp1250_to_utf2($text){
        $dict  = array(chr(225) => 'á', chr(228) =>  'ä', chr(232) => 'č', chr(239) => 'ď', 
            chr(233) => 'é', chr(236) => 'ě', chr(237) => 'í', chr(229) => 'ĺ', chr(229) => 'ľ', 
            chr(242) => 'ň', chr(244) => 'ô', chr(243) => 'ó', chr(154) => 'š', chr(248) => 'ř', 
            chr(250) => 'ú', chr(249) => 'ů', chr(157) => 'ť', chr(253) => 'ý', chr(158) => 'ž',
            chr(193) => 'Á', chr(196) => 'Ä', chr(200) => 'Č', chr(207) => 'Ď', chr(201) => 'É', 
            chr(204) => 'Ě', chr(205) => 'Í', chr(197) => 'Ĺ',    chr(188) => 'Ľ', chr(210) => 'Ň', 
            chr(212) => 'Ô', chr(211) => 'Ó', chr(138) => 'Š', chr(216) => 'Ř', chr(218) => 'Ú', 
            chr(217) => 'Ů', chr(141) => 'Ť', chr(221) => 'Ý', chr(142) => 'Ž', 
            chr(150) => '-');
        return strtr($text, $dict);
    }
    function jsonRemoveUnicodeSequences($struct) {
       return preg_replace("/\\\\u([a-f0-9]{4})/e", "iconv('UCS-4LE','UTF-8',pack('V', hexdec('U$1')))", json_encode($struct));
    }
    public function set_ocr_pages($p){
        header("Content-Type: text/html; charset=UTF-8");
        //$p['vp_recordsToSend']=$this->cp1250_to_utf2($this->normalize($this->strip_carriage_returns(utf8_decode($p['vp_recordsToSend']))));
        $data = $p['vp_recordsToSend'];
        $data = str_replace(array('\"'), "", $data);
        $data = str_replace(array("'"), "", $data);
        $data =utf8_decode($data);
        $data =$this->strip_carriage_returns($data);
        //$data =$this->hyphenize($data);
        //$data =$this->decode($data);
        $data =$this->cp1250_to_utf2($data);
        $data =$this->normalize($data);
        $data =stripslashes($data);
        //echo $data;
        $records = json_decode($data); //parse the string to PHP objects
        //echo $records;
        //echo $data;
        //var_export($records);
        if(!empty($records)){
            foreach($records as $record){
                if((int)$record->cod_trazo==0){
                    
                    $pp['vp_text']=$record->text;
                    $pp['vp_op']='X';
                    $pp['vp_id_pag']=$record->id_pag;
                    $pp['vp_cod_trazo']='0';
                    $pp['vp_id_det']=$record->id_det;
                    $pp['vp_id_lote']=$record->id_lote;

                    $rs = $this->objDatos->set_ocr_pages($pp);
                    $rs = $rs[0];
                    $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));
                }else{
                    $px['vp_op']='I';
                    $px['vp_id_pag']=$record->id_pag;
                    $px['vp_cod_trazo']=$record->cod_trazo;
                    $px['vp_id_det']=$record->id_det;
                    $px['vp_id_lote']=$record->id_lote;
                    $px['vp_text']=$record->text;

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

    static private function encode_b64imap($s) {    
        $a=0; $al=0; $res=''; $n=strlen($s);
        for($i=0;$i<$n;$i++) {
            $a=($a<<8)|ord($s[$i]); $al+=8;
            for(;$al>=6;$al-=6) $res.=self::$imap_base64[($a>>($al-6))&0x3F];
        }
        if ($al>0) { $res.=self::$imap_base64[($a<<(6-$al))&0x3F]; }
        return $res;
    }
    static private function encode_utf8_char($w) {
        if ($w&0x80000000) return '';
        if ($w&0xFC000000) $n=5; else
        if ($w&0xFFE00000) $n=4; else
        if ($w&0xFFFF0000) $n=3; else
        if ($w&0xFFFFF800) $n=2; else
        if ($w&0xFFFFFF80) $n=1; else return chr($w);
        $res=chr(( (255<<(7-$n)) | ($w>>($n*6)) )&255); 
        while(--$n>=0) $res.=chr((($w>>($n*6))&0x3F)|0x80);
        return $res;
    }
    static private function decode_b64imap($s) {
        $a=0; $al=0; $res=''; $n=strlen($s);
        for($i=0;$i<$n;$i++) {
            $k=strpos(self::$imap_base64,$s[$i]); if ($k===FALSE) continue;
            $a=($a<<6)|$k; $al+=6;
            if ($al>=8) { $res.=chr(($a>>($al-8))&255);$al-=8; }
        }
        $r2=''; $n=strlen($res);
        for($i=0;$i<$n;$i++) {
            $c=ord($res[$i]); $i++;
            if ($i<$n) $c=($c<<8) | ord($res[$i]);
            $r2.=self::encode_utf8_char($c);
        }
        return $r2;
    }
    static function encode($s) {
        $n=strlen($s);$err=0;$buf='';$res='';
        for($i=0;$i<$n;) {
            $x=ord($s[$i++]);
            if (($x&0x80)==0x00) { $r=$x;$w=0; } 
            else if (($x&0xE0)==0xC0) { $w=1; $r=$x &0x1F; } 
            else if (($x&0xF0)==0xE0) { $w=2; $r=$x &0x0F; } 
            else if (($x&0xF8)==0xF0) { $w=3; $r=$x &0x07; } 
            else if (($x&0xFC)==0xF8) { $w=4; $r=$x &0x03; } 
            else if (($x&0xFE)==0xFC) { $w=5; $r=$x &0x01; } 
            else if (($x&0xC0)==0x80) { $w=0; $r=-1; $err++; } 
            else { $w=0;$r=-2;$err++; }
            for($k=0;$k<$w && $i<$n; $k++) {
                $x=ord($s[$i++]); if ($x&0xE0!=0x80) { $err++; }
                $r=($r<<6)|($x&0x3F);
            }
            if ($r<0x20 || $r>0x7E ) {
                $buf.=chr(($r>>8)&0xFF); $buf.=chr($r&0xFF);
            } else {
                if (strlen($buf)) { 
                    $res.='&'.self::encode_b64imap($buf).'-';
                    $buf=''; 
                }
                if ($r==0x26) { $res.='&-'; } else $res.=chr($r);
            }
        }
        if (strlen($buf)) $res.='&'.self::encode_b64imap($buf).'-';
        return $res;
    }
    static function decode($s) {
        $res=''; $n=strlen($s); $h=0;
        while($h<$n) {
            $t=strpos($s,'&',$h); if ($t===false) $t=$n;
            $res.=substr($s,$h,$t-$h); $h=$t+1; if ($h>=$n) break;
            $t=strpos($s,'-',$h); if ($t===false) $t=$n;
            $k=$t-$h; 
            if ($k==0) $res.='&'; 
            else $res.=self::decode_b64imap(substr($s,$h,$k));
            $h=$t+1;
        }
        return $res;
    }
    public function set_delete_temporal_file($p){
        $estado="ER";
        $msn="No existe archivo a editar.";
        if (file_exists(PATH.'public_html/filedit/'.$p['temporalFile'])) {
            unlink(PATH.'public_html/filedit/'.$p['temporalFile']);
            $estado="OK";
            $msn="Creado correctamente";
        }
        $data = array('success' => true,'error' => $estado,'msn' => $msn);
        header('Content-Type: application/json');
        return $this->response($data);
        
    }
    public function setSaveChangeFile($p){
        $estado="ER";
        $msn="No existe archivo a editar.";
        if (file_exists(PATH.'public_html/filedit/'.$p['temporalFile'])){
            try{
                rename(PATH.'public_html/filedit/'.$p['temporalFile'], PATH.'public_html'.$p['path'].$p['img']);
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            try{
                unlink(PATH.'public_html/filedit/'.$p['temporalFile']);
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            $estado="OK";
            $msn="Creado correctamente";
        }
        $data = array('success' => true,'error' => $estado,'msn' => $msn);
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function set_create_temporal_file($p){
        $estado="ER";
        $msn="Creado correctamente";
        $time = time();
        $RD=date("dmYHis", $time);
        $path_parts = pathinfo(PATH.'public_html'.$p['path'].$p['img']);
        $extension=$path_parts['extension'];
        $R=rand();
        $file=$RD.'_'.$R.'.'.$extension;
        try {
            if (file_exists(PATH.'public_html'.$p['path'].$p['img'])) {
                copy(PATH.'public_html'.$p['path'].$p['img'], PATH.'public_html/filedit/'.$file);
                if (file_exists(PATH.'public_html/filedit/'.$p['temporalFile'])) {
                    unlink(PATH.'public_html/filedit/'.$p['temporalFile']);
                }
                $estado="OK";
            }else{
                $msn="No existe archivo a editar.";
            }
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            $estado="ER";
            $msn=$e->getMessage();
        }

        $data = array('success' => true,'error' => $estado,'msn' => $msn,'file'=>$file);
        header('Content-Type: application/json');
        return $this->response($data);
   }
    public function set_resize_file($p){
        $img=$p['vp_img'];
        $path=$p['vp_path'];
        $path_parts = pathinfo(PATH.'public_html'.$path.$img);
        $p['extension']=$path_parts['extension'];


        $time = time();
        $RD=date("dmYHis", $time);
        $R=rand();
        $file=$RD.'_'.$R.'.'.$p['extension'];


        $bool=$this->setDropImgFile($p,$file);

        if($bool){
            if (file_exists(PATH.'public_html/filedit/'.$p['vp_img'])) {
                unlink(PATH.'public_html/filedit/'.$p['vp_img']);
            }
        }

        $data = array(
            'success' => true,
            'error' => $bool?'OK':'ER',
            'msn' => 'Mensaje generado',
            'file'=>$file
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function setDropImgFile($p,$file){
        $bool=false;
        $img=$p['vp_img'];
        $path=$p['vp_path'];
        #$path_parts = pathinfo($p['vp_img']);
        $ext=$p['extension'];
        $src_original = PATH.'public_html'.$path.$img;
        $src_guardar  = PATH.'public_html'.$path.$file;
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
            $bool=true;
        } catch (Exception $e) {
            $msn= $e->getMessage();
            $bool=false;
        }
        return $bool;
    }

    public function setRotateImage($p){
        $nameimg=$p['temporalFile'];
        $path_parts = pathinfo(PATH.'public_html/filedit/'.$nameimg);
        $ext=$path_parts['extension'];
        $w=40;
        $y=60;
        $time = time();
        $RD=date("dmYHis", $time);
        $R=rand();
        $file=$RD.'_'.$R.'.'.$ext;
        $msn='Mensaje generado';
        try {
            switch($ext){
                #case 'bmp': $sourceImage = $img = $this->resize_imagejpg(PATH.'public_html/tmp/'.$nameimg, 50, 70); break;
                case 'gif': 
                    $img = $this->resize_imagegif(PATH.'public_html/filedit/'.$nameimg); 
                break;
                case 'jpg': 
                    $img = $this->resize_imagejpg(PATH.'public_html/filedit/'.$nameimg); 
                break;
                case 'png': 
                    $img = $this->resize_imagepng(PATH.'public_html/filedit/'.$nameimg); 
                break;
                default : 
                    $img = $this->resize_imagejpg(PATH.'public_html/filedit/'.$nameimg); 
                break;
            }
            imagejpeg($img, PATH.'public_html/filedit/'.$file);
            
            if (file_exists(PATH.'public_html/filedit/'.$nameimg)) {
                unlink(PATH.'public_html/filedit/'.$nameimg);
            }
            $bool=true;
        } catch (Exception $e) {
            $msn= $e->getMessage();
            $bool=false;
        }
        $data = array(
            'success' => true,
            'error' => $bool?'OK':'ER',
            'msn' => $msn,
            'file'=>$file
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
    // for jpg 
    public function resize_imagejpg($file) {
       //list($width, $height) = getimagesize($file);
       $src = imagecreatefromjpeg($file);
       $dst = imagerotate($src, 90,0);
       return $dst;
    }

     // for png
    public function resize_imagepng($file) {
       //list($width, $height) = getimagesize($file);
       $src = imagecreatefrompng($file);
       $dst = imagerotate($src, 90,0);
       return $dst;
    }

    // for gif
    public function resize_imagegif($file) {
       //list($width, $height) = getimagesize($file);
       $src = imagecreatefromgif($file);
       $dst = imagerotate($src, 90,0);
       return $dst;
    }
    public function setSaveReproFile($p){
        //$this->valida_mobil($p);
        
        $rs = $this->objDatos->setSaveReproFile($p);
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