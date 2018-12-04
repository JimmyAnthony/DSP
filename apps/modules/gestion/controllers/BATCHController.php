<?php

class BATCHController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new BATCHModels();
    }

    public function index($p){        
        $this->view('BATCH/form_index.php', $p);
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
                $json.=',"por":"'.$value['por'].'"';
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

    public function get_recursivo_hijos($_nivel,$_hijo,$bool){
        $coma = '';
        //var_export($this->rs_);
        foreach ($this->rs_ as $key => $value){
            //if($bool)$_hijo=$value['hijo'];
            //echo $key.'-';
            
            if($value['nivel'] != $_nivel && (int)$value['padre'] == (int)$_hijo){
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
                $js = $this->get_recursivo_hijos($value['nivel'],$value['hijo'],false);
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
    public function get_print($p){
        require APPPATH_VIEW . 'closing/print_pdf.php';
    }
    public function get_zip($p){
        $time = time();
        $RD=date("dmY His", $time);
        $zipname = 'DSP-FILE-'.$RD.'.zip';

        $path_lote = "";
        $nombre_lote = "";

        $zip = new ZipArchive;
        $zip->open($zipname, ZipArchive::CREATE|ZipArchive::OVERWRITE);

        $rs = $this->objDatos->get_load_page($p);
        foreach ($rs as $index => $value){
            $path_lote = PATH.'public_html/download/'.trim($value['nombre']).'/';
            $nombre_lote = trim($value['nombre']);
            if (!file_exists(PATH.'public_html/download/'.trim($value['nombre']).'/'.trim($value['expediente']).'/')) {
                mkdir(PATH.'public_html/download/'.trim($value['nombre']).'/'.trim($value['expediente']).'/', 0777, true);
            }
            $path_parts = pathinfo(PATH.'public_html'.trim($value['path']).trim($value['img']));
            $ext=$path_parts['extension'];
            $to=PATH.'public_html/download/'.trim($value['nombre']).'/'.trim($value['expediente']).'/'.trim($value['orden']).'.'.$ext;
            copy(PATH.'public_html'.trim($value['path']).trim($value['img']), $to);
            $zip->addFile($to,trim($value['nombre']).'/'.trim($value['expediente']).'/'.trim($value['orden']).'.'.$ext);
        }
        
        $zip->close();

        ///Then download the zipped file.
        header('Content-Type: application/zip');
        header('Content-disposition: attachment; filename='.$zipname);
        header('Content-Length: ' . filesize($zipname));
        readfile($zipname);
        unlink($zipname);
        $this->rrmdir($path_lote);
    }
    public function rrmdir($dir) { 
       if (is_dir($dir)) { 
         $objects = scandir($dir); 
         foreach ($objects as $object) { 
           if ($object != "." && $object != "..") { 
             if (filetype($dir."/".$object) == "dir") $this->rrmdir($dir."/".$object); else unlink($dir."/".$object); 
           } 
         } 
         reset($objects); 
         rmdir($dir); 
       } 
    } 


    public function set_process_ocr($p){
        //$this->valida_mobil($p);
        //set_time_limit(0);
        //ini_set('memory_limit', '-1');

        $op = $p['vp_op'];

        /*$p['vp_op']=$p['vp_op']=='S'?'J':$p['vp_op'];

        $rs = $this->objDatos->set_lotizer($p);

        //$p['vp_op']=$op=='A'?'S':$p['vp_op'];

        $rs = $rs[0];
        if($rs['status']!='ER'){

            
        }*/

        $p['vp_seleccionar']='P';
        /*$p['vp_id_pag'] ='0';
        $p['vp_id_det']='0';*/
        $p['vp_ocr']='N';
        //$p['vp_shi_codigo']=
        //$p['vp_fac_cliente']=
        $p['vp_lote_estado']='AU';
        $p['vp_name']='';
        $p['fecha']='';
        $p['vp_estado']='A';
        
        /*$thread = new ChildThread($op,$p);
        $thread->start();*/
        $this->set_list_page_trazos_auto($p);
        $rs['status'] ='OK';
        $rs['response'] ='PROCESANDO...';
        if($op=='S'){
            $this->setProcessingOCR($p);
        }else{
            $this->setProcessingOCRAUTO($p);
        }


        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }

    public function open($exec, $cwd = null) {
        if (!is_string($cwd)) {
            $cwd = @getcwd();
        }

        @chdir($cwd);

        if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
            /*$WshShell = new COM("WScript.Shell");
            $WshShell->CurrentDirectory = str_replace('/', '\\', $cwd);
            $WshShell->Run($exec, 0, false);*/
            system($exec." > NUL");
        } else {
            exec($exec . " > /dev/null 2>&1 &");
        }
    }

    public function execInBackground($cmd) {
        if (substr(php_uname(), 0, 7) == "Windows"){
            pclose(popen("start /B ". $cmd, "r"));
        }
        else {
            exec($cmd . " > /dev/null &");
        }
    }

    public function setProcessingOCR($p){
        set_time_limit(10);
        ini_set('memory_limit', '-1');
        #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
        $params = base64_encode(PATH . '&0&' . trim($p['vp_shi_codigo']) . '&0&' . trim($p['vp_id_lote']).'&H&'.USR_ID);
        $comando = "python " . PATH . "apps/modules/gestion/views/control/python/OCR.py " . $params;
        $output = array();
        //echo $comando;die();
        try{
            $this->execInBackground($comando);
            //pclose(popen($comando, 'r'));
            //$this->open($comando);
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        $data = array('success' => true,'error' => $output[0],'msn' => utf8_encode(trim($output[1])));
        //header('Content-Type: application/json');
        return $data;
    }
    public function setProcessingOCRAUTO($p){
        set_time_limit(10);
        ini_set('memory_limit', '-1');
        #IN vp_id_pag INTEGER,IN vp_shi_codigo smallint,IN vp_id_det INT,IN vp_id_lote INT
        $params = base64_encode(PATH . '&0&' . trim($p['vp_shi_codigo']) . '&0&' . trim($p['vp_id_lote']).'&B&'.USR_ID);
        $comando = "python " . PATH . "apps/modules/gestion/views/scanning/python/scanner.py " . $params;
        $output = array();
        //echo $comando;die();
        try{
            $this->execInBackground($comando);
            //pclose(popen($comando, 'r'));
            //$this->open($comando);
        }catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";
        }
        $data = array('success' => true,'error' => $output[0],'msn' => utf8_encode(trim($output[1])));
        //header('Content-Type: application/json');
        return $data;
    }
    public function set_list_page_trazos_auto($p){
        set_time_limit(0);
        ini_set('memory_limit', '-1');
        $rs = $this->objDatos->get_list_page_trazos_pending($p);
        //var_export($rs);
        $array = array();
        //$page=$p['vp_id_pag'];
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
        //$p['vp_id_pag']=$page;

        $res = $this->objDatos->set_marca_trazos($p);

        #$data=$this->getScannearTrazos($p);
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
}