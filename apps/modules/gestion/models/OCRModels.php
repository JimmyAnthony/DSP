<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class OCRModels extends Adodb {

    private $dsn;

    public function __construct(){ 
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_ocr_plantillas');
        parent::SetParameterSP($p['vp_cod_lote'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function strip_carriage_returns($string){
        return str_replace(array("\n\r", "\n", "\r","'"), '', $string);
    }
    public function set_ocr_plantilla($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_ocr_plantilla');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_cod_plantilla'], 'int');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP(utf8_decode($p['vp_nombre']), 'varchar');
        parent::SetParameterSP($p['vp_cod_formato'], 'int');
        parent::SetParameterSP($p['vp_width'], 'varchar');
        parent::SetParameterSP($p['vp_height'], 'varchar');
        parent::SetParameterSP($p['vp_path'], 'varchar');
        parent::SetParameterSP($p['vp_img'], 'varchar');
        parent::SetParameterSP($p['vp_pathorigen'], 'varchar');
        parent::SetParameterSP($p['vp_imgorigen'], 'varchar');
        parent::SetParameterSP($this->strip_carriage_returns(utf8_decode($p['vp_texto'])), 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int'); 
        //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_ocr_plantillas($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_ocr_plantillas');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        /*parent::SetParameterSP($p['vp_lote'], 'int');
        parent::SetParameterSP($p['vp_lote_estado'], 'varchar');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');*/
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function set_ocr_trazos($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_ocr_trazos');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_cod_trazo'], 'int');
        parent::SetParameterSP($p['vp_cod_plantilla'], 'int');
        parent::SetParameterSP(utf8_decode($p['vp_nombre']), 'varchar');
        parent::SetParameterSP($p['vp_tipo'], 'varchar');
        parent::SetParameterSP($p['vp_x'], 'varchar');
        parent::SetParameterSP($p['vp_y'], 'varchar');
        parent::SetParameterSP($p['vp_w'], 'varchar');
        parent::SetParameterSP($p['vp_h'], 'varchar');
        parent::SetParameterSP($p['vp_path'], 'varchar');
        parent::SetParameterSP($p['vp_img'], 'varchar');
        parent::SetParameterSP($this->strip_carriage_returns(utf8_decode($p['vp_texto'])), 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
   public function get_ocr_trazos($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_ocr_trazos');
        parent::SetParameterSP($p['vp_cod_plantilla'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_lotizer($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_lotizer_page');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_lote'], 'int');
        parent::SetParameterSP($p['vp_lote_estado'], 'varchar');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_shipper($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_shipper');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_contratos($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_contratos');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
}
