<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */
error_reporting(NULL);
set_time_limit(0);
ini_set("memory_limit", "-1");
class scanningController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new scanningModels();
    }

    public function index($p){        
        $this->view('scanning/form_index.php', $p);
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
    public function setProcessingOCR($p){

        set_time_limit(0);
        ini_set('memory_limit', '-1');
        #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
        $params = base64_encode(PATH . '&0&' . trim($p['vp_shi_codigo']) . '&0&' . trim($p['vp_id_lote']));
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
    public function set_lotizer($p){
        //$this->valida_mobil($p);
        $rs = $this->objDatos->set_lotizer($p);
        $rs = $rs[0];
        if($rs['status']!='ER'){
            $this->setProcessingOCR($p);
        }
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function set_remove_scanner_file_one($p){
        $array = array();
        if (file_exists(PATH.'public_html/contenedor/'.USR_ID.'/'.$p['file'])){
            try{
                unlink(PATH.'public_html/contenedor/'.USR_ID.'/'.$p['file']);
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
            try{
                unlink(PATH.'public_html/tumblr/'.$p['file']);
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }
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
    public function set_remove_file($p){
        if($p['vp_op']!='Z'){
            $rs = $this->objDatos->get_list_page_delete($p);
        }else{
            $rs = $this->objDatos->get_list_page_delete_auto($p);
        }

        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                //$p['vp_op'] = 'D';
                $p['vp_id_pag'] = intval($value['id_pag']);

                $rs = $this->objDatos->set_page($p);
                $rs = $rs[0];
                $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));
                if($rs['status']=='OK'){
                    if (file_exists(PATH.'public_html/'.utf8_encode(trim($value['path'])).utf8_encode(trim($value['img'])))){
                        try{
                            unlink(PATH.'public_html/'.utf8_encode(trim($value['path'])).utf8_encode(trim($value['img'])));
                        } catch (Exception $e) {
                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                        try{
                            unlink(PATH.'public_html/tumblr/'.utf8_encode(trim($value['img'])));
                        } catch (Exception $e) {
                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    }
                }
        }
        
        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function set_remove_scanner_file($p){
        $array = array();
        try {
            if (is_dir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                  if ($dh = opendir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                    
                    while (false !== ($file = readdir($dh))) {
                        if(trim($file)!=".." ){
                            if(trim($file)!="." ){
                                try {
                                    if (file_exists(PATH.'public_html/contenedor/'.USR_ID.'/'.$file)) {
                                        try{
                                            unlink(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                                        } catch (Exception $e) {
                                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                        }
                                        try{
                                            unlink(PATH.'public_html/tumblr/'.$file);
                                        } catch (Exception $e) {
                                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                        }
                                    }
                                } catch (Exception $e) {
                                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                }
                            }
                        }
                    }
                    closedir($dh);
                }
            }
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
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
    public function get_scanner($p){
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $p['path'] = PATH.'public_html/contenedor/'.USR_ID.'/';
        if (!file_exists($p['path'])) {
            mkdir($p['path'], 0777, true);
        }
        $array = array();

        
        /*if (!file_exists(PATH.'public_html/tmp/'.USR_ID.'/')) {
            mkdir(PATH.'public_html/tmp/'.USR_ID.'/', 0777, true);
        }
        try {
            if (is_dir($p['path'])){
                  if ($dh = opendir($p['path'])){
                    while (false !== ($file = readdir($dh))) {
                        if(trim($file)!=".." ){
                            if(trim($file)!="." ){
                                try {
                                    if (file_exists($p['path'].$file)) {
                                        rename($p['path'].$file, PATH.'public_html/tmp/'.USR_ID.'/'.$file);
                                    }

                                } catch (Exception $e) {
                                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                }
                            }
                        }
                    }
                    closedir($dh);
                }
            }
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
        }*/

        if(intval($p['index'])==0){
            try {
                if (is_dir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                      if ($dh = opendir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                        /*if (!file_exists(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'])) {
                            mkdir(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'], 0777, true);
                        }*/

                        while (false !== ($file = readdir($dh))) {
                            if(trim($file)!=".." ){
                                if(trim($file)!="." ){
                                    try {
                                        if($this->getValidFormat(utf8_encode(trim($file)))){
                                            $value_['id_pag'] = 0;
                                            $value_['id_det'] = 0;
                                            $value_['id_lote'] = $id_lote;
                                            $value_['path'] = '/contenedor/'.USR_ID.'/';
                                            $value_['file'] = utf8_encode(trim($file));
                                            $value_['imgorigen'] = utf8_encode(trim($file));
                                            $value_['lado'] = 'A';
                                            $value_['estado'] = 'A';
                                            $value_['include'] ='N';
                                            $array[]=$value_;
                                            $this->setResizeImage(utf8_encode(trim($file)));
                                        }
                                    } catch (Exception $e) {
                                        //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                    }
                                }
                            }
                        }
                        closedir($dh);
                    }
                }
            } catch (Exception $e) {
                //echo 'Caught exception: ',  $e->getMessage(), "\n";
            }

            $data = array(
                'success' => true,
                'error'=>0,
                'total' => count($array),
                'data' => $array
            );
            header('Content-Type: application/json');
            return $this->response($data);

        }else{

            $id_lote = 0;
            $p['vp_op']='Y';
            $p['vp_id_lote']='0';
            $p['vp_nombre']='Lote Automático';
            $p['vp_descripcion']='';
            $p['vp_tipdoc']='L';
            $p['vp_lote_fecha']='';
            $p['vp_ctdad']=1;
            $p['vp_estado']='A';
            $rs = $this->objDatos->set_lotizer($p);
            $rs = $rs[0];
            $existe=false;

            if($rs['status']!='ER'){
                $id_lote = $rs['id_lote'];
                $id_det = $rs['id_det'];
                $p['vp_lote']=$id_lote;
                $p['vp_id_lote']=$id_lote;


                try {
                    if (is_dir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                          if ($dh = opendir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                            if (!file_exists(PATH.'public_html/auto/'.$p['vp_shi_codigo'].'/'.$id_lote)) {
                                mkdir(PATH.'public_html/auto/'.$p['vp_shi_codigo'].'/'.$id_lote, 0777, true);
                            }
                            while (false !== ($file = readdir($dh))) {
                                //echo $file.'xx';
                            #while (($file = readdir($dh)) !== false){ 
                              if(trim($file)!=".." ){
                                    if(trim($file)!="." ){
                                        if (file_exists(PATH.'public_html/contenedor/'.USR_ID.'/'.$file)){
                                            //move_uploaded_file($p['path'].$file, PATH.'public_html/scanning/'.$file);
                                            try {
                                                $path_parts = pathinfo(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                                                $ext=$path_parts['extension'];
                                                $p['vp_op']='I';
                                                $p['vp_id_det']=$id_det;
                                                $p['vp_img']='-page.'.$ext;
                                                $p['vp_imgorigen']=$file;
                                                $p['vp_path']='/auto/'.$p['vp_shi_codigo'].'/'.$id_lote.'/';
                                                $p['vp_lado']='A';
                                                list($width, $height) = getimagesize(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                                                $p['vp_w']=$width;
                                                $p['vp_h']=$height;
                                                $rs = $this->objDatos->set_page($p);
                                                $this->setResizeImage(utf8_encode(trim($file)));
                                                $rs = $rs[0];
                                                $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));

                                                if($rs['status']=='OK'){
                                                    $existe=true;
                                                    try{
                                                        rename(PATH.'public_html/contenedor/'.USR_ID.'/'.$file, PATH.'public_html'.$p['vp_path'].$rs['id_pag'].$p['vp_img']);
                                                    } catch (Exception $e) {
                                                        //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                                    }
                                                    try{
                                                        rename(PATH.'public_html/tumblr/'.$file, PATH.'public_html/tumblr/'.$rs['id_pag'].$p['vp_img']);
                                                    } catch (Exception $e) {
                                                        //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                                    }
                                                }

                                            } catch (Exception $e) {
                                                //echo 'Caught exception: ',  $e->getMessage(), "\n";k
                                            }
                                        }
                                    }
                                }
                            }
                            closedir($dh);
                        }
                    }
                } catch (Exception $e) {
                    //echo 'Caught exception: ',  $e->getMessage(), "\n";
                    //$data = array('success' => true,'error' => 'ER','msn' => $e->getMessage());
                }

                $p['vp_seleccionar']='P';
                $p['vp_id_pag'] ='0';
                $p['vp_id_det']='0';
                $p['vp_ocr']='N';
                //$p['vp_shi_codigo']=
                //$p['vp_fac_cliente']=
                $p['vp_lote_estado']='AU';
                $p['vp_name']='';
                $p['fecha']='';
                $p['vp_estado']='A';

                if($existe){
                    
                    $this->set_list_page_trazos($p);

                    #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
                    //$params = base64_encode(PATH . '&'.trim($id_lote).'&' . trim($p['vp_shi_codigo']) . '&0');

                    $params = base64_encode(PATH . '&0&' . trim($p['vp_shi_codigo']) . '&0&' . trim($p['vp_id_lote']));

                    $comando = "python " . PATH . "apps/modules/gestion/views/scanning/python/scanner.py " . $params;
                    $output = array();
                    echo $comando;die();
                    try{
                        exec($comando, $output);
                    }catch (Exception $e) {
                        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
                    }
                    //$data = array('success' => true,'error' => $output[0],'msn' => utf8_encode(trim($output[1])));
                }

                return $this->get_list_lotizer_page($p);
            }else{
                $data = array(
                    'success' => true,
                    'error' => $rs['status'],
                    'msn' => utf8_encode(trim($rs['response']))
                );
                header('Content-Type: application/json');
                return $this->response($data);
            }

        }
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
        $data=$this->getScannearTrazos($p);
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
    public function getValidFormat($nameimg){
        $path_parts = pathinfo(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg);
        $ext=$path_parts['extension'];
        $bool=false;
        switch($ext){
            #case 'bmp': $sourceImage = $img = $this->resize_imagejpg(PATH.'public_html/tmp/'.$nameimg, 50, 70); break;
            case 'gif': case 'GIF': 
                $bool=true;
            break;
            case 'jpg': case 'JPG': 
                $bool=true;
            break;
            case 'png': case 'PNG': 
                $bool=true;
            break;
            case 'tiff': case 'TIFF': 
                $bool=true;
            break;
        }
        return $bool;
    }
    public function setResizeImage($nameimg){
        $path_parts = pathinfo(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg);
        $ext=$path_parts['extension'];
        $w=40;
        $y=60;
        switch($ext){
            #case 'bmp': $sourceImage = $img = $this->resize_imagejpg(PATH.'public_html/tmp/'.$nameimg, 50, 70); break;
            case 'gif': 
                $img = $this->resize_imagegif(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg, $w, $y); 
            break;
            case 'jpg': 
                $img = $this->resize_imagejpg(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg, $w, $y); 
            break;
            case 'png': 
                $img = $this->resize_imagepng(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg, $w, $y); 
            break;
            case 'tiff': 
                $img = $this->resize_imagetiff(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg, $w, $y); 
            break;
            default : 
                $img = $this->resize_imagejpg(PATH.'public_html/contenedor/'.USR_ID.'/'.$nameimg, $w, $y); 
            break;
        }
        imagejpeg($img, PATH.'public_html/tumblr/'.$nameimg);
    }
    // for jpg 
    public function resize_imagejpg($file, $w, $h) {
       list($width, $height) = getimagesize($file);
       $src = imagecreatefromjpeg($file);
       $dst = imagecreatetruecolor($w, $h);
       imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
       return $dst;
    }

     // for png
    public function resize_imagepng($file, $w, $h) {
       list($width, $height) = getimagesize($file);
       $src = imagecreatefrompng($file);
       $dst = imagecreatetruecolor($w, $h);
       imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
       return $dst;
    }

    // for gif
    public function resize_imagegif($file, $w, $h) {
       list($width, $height) = getimagesize($file);
       $src = imagecreatefromgif($file);
       $dst = imagecreatetruecolor($w, $h);
       imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
       return $dst;
    }
    // for tiff
    public function resize_imagetiff($file, $w, $h) {
       list($width, $height) = getimagesize($file);
       $src = imagecreatefromgif($file);
       $dst = imagecreatetruecolor($w, $h);
       imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
       return $dst;
    }
    public function set_scanner_file_one_to_one($p){
        $records = json_decode(stripslashes($p['vp_recordsToSend'])); //parse the string to PHP objects
        if(isset($records)){
            if (!file_exists(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'])) {
                mkdir(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'], 0777, true);
            }
            foreach($records as $record){
                $file=$record->file;
                if (file_exists(PATH.'public_html/contenedor/'.USR_ID.'/'.$file)){
                    $path_parts = pathinfo(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                    $ext=$path_parts['extension'];
                    $p['vp_img']='-page.'.$ext;
                    $p['vp_imgorigen']=$file;
                    $p['vp_path']='/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'].'/';
                    list($width, $height) = getimagesize(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                    $p['vp_w']=$width;
                    $p['vp_h']=$height;
                    $p['vp_lado']='A';
                    $rs = $this->objDatos->set_page($p);
                    $rs = $rs[0];
                    $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));

                    if($rs['status']=='OK'){
                        rename(PATH.'public_html/contenedor/'.USR_ID.'/'.$file, PATH.'public_html'.$p['vp_path'].$rs['id_pag'].$p['vp_img']);
                        try{
                            rename(PATH.'public_html/tumblr/'.$file, PATH.'public_html/tumblr/'.$rs['id_pag'].$p['vp_img']);
                        } catch (Exception $e) {
                            //echo 'Caught exception: ',  $e->getMessage(), "\n";
                        }
                    }
                }else{
                    $data = array('success' => true,'error' => 'ER','msn' => 'No existen archivos a procesar');
                }

            }
        }else{
            $data = array('success' => true,'error' => 'ER','msn' => 'No existen archivos a procesar');
        }

        header('Content-Type: application/json');
        return $this->response($data);
    }
    public function get_scanner_file($p){
        try {
            if (is_dir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                  if ($dh = opendir(PATH.'public_html/contenedor/'.USR_ID.'/')){
                    if (!file_exists(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'])) {
                        mkdir(PATH.'public_html/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'], 0777, true);
                    }
                    while (false !== ($file = readdir($dh))) {
                        //echo $file.'xx';
                    #while (($file = readdir($dh)) !== false){ 
                      if(trim($file)!=".." ){
                            if(trim($file)!="." ){
                                if (file_exists(PATH.'public_html/contenedor/'.USR_ID.'/'.$file)){
                                    //move_uploaded_file($p['path'].$file, PATH.'public_html/scanning/'.$file);
                                    try {
                                        $path_parts = pathinfo(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                                        $ext=$path_parts['extension'];
                                        $p['vp_img']='-page.'.$ext;
                                        $p['vp_imgorigen']=$file;
                                        $p['vp_path']='/scanning/'.$p['vp_shi_codigo'].'/'.$p['vp_id_lote'].'/';
                                        $p['vp_lado']='A';
                                        list($width, $height) = getimagesize(PATH.'public_html/contenedor/'.USR_ID.'/'.$file);
                                        $p['vp_w']=$width;
                                        $p['vp_h']=$height;
                                        $rs = $this->objDatos->set_page($p);
                                        $rs = $rs[0];
                                        $data = array('success' => true,'error' => $rs['status'],'msn' => utf8_encode(trim($rs['response'])));

                                        if($rs['status']=='OK'){
                                            try{
                                                rename(PATH.'public_html/contenedor/'.USR_ID.'/'.$file, PATH.'public_html'.$p['vp_path'].$rs['id_pag'].$p['vp_img']);
                                            } catch (Exception $e) {
                                                //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                            }
                                            try{
                                                rename(PATH.'public_html/tumblr/'.$file, PATH.'public_html/tumblr/'.$rs['id_pag'].$p['vp_img']);
                                            } catch (Exception $e) {
                                                //echo 'Caught exception: ',  $e->getMessage(), "\n";
                                            }
                                        }

                                    } catch (Exception $e) {
                                        //echo 'Caught exception: ',  $e->getMessage(), "\n";k
                                    }
                                }
                            }
                        }
                    }
                    closedir($dh);
                }
            }
        } catch (Exception $e) {
            //echo 'Caught exception: ',  $e->getMessage(), "\n";
            $data = array('success' => true,'error' => 'ER','msn' => $e->getMessage());
        }
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
    
    public function get_list_lotizer_page($p){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
        $this->rs_ = $this->objDatos->get_list_lotizer_page($p);
        if(!empty($this->rs_)){
            return '{"text": ".","children":['.$this->get_recursivo_page(0,'',true).']}';
            
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
    public function get_recursivo_page($_nivel,$_hijo,$bool){
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
                $json.=',"id_lote":"'.$value['id_lote'].'"';
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
                $js = $this->get_recursivo_page($value['nivel'],$value['hijo'],false);
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
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                $json.=',"id_det":"'.$value['id_det'].'"';
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
    public function getRecursividad_children($_nivel,$_hijo){
        $coma = '';
        foreach ($this->rs_ as $key => $value){
            if ($value['nivel'] != $_nivel && $value['id_lote'] == $_hijo){
                $json.=$coma."{";
                $json.='"id_lote":"'.$value['id_lote'].'"';
                $json.=',"shi_codigo":"'.$value['shi_codigo'].'"';
                $json.=',"fac_cliente":"'.$value['fac_cliente'].'"';
                $json.=',"id_det":"'.$value['id_det'].'"';
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
    public function getScannearTrazos($p){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
        $params = base64_encode(PATH . '&0&' . trim($p['vp_shi_codigo']) . '&0&' . trim($p['vp_id_lote']));
        $comando = "python " . PATH . "apps/modules/gestion/views/scanning/python/scanner.py " . $params;
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
}