<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class reprocessingModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_lotizer');
        parent::SetParameterSP($p['vp_cod_lote'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_load_page($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_page');
        parent::SetParameterSP($p['vp_id_pag'], 'int');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_id_det'], 'int');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_page_delete($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_page_delete');
        parent::SetParameterSP($p['vp_id_pag'], 'int');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_id_det'], 'int');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function set_page($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_page');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_id_pag'], 'int'); 
        parent::SetParameterSP($p['vp_id_det'], 'int');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        parent::SetParameterSP(utf8_decode($p['vp_path']), 'varchar');
        parent::SetParameterSP(utf8_decode($p['vp_img']), 'varchar');
        parent::SetParameterSP(utf8_decode($p['vp_imgorigen']), 'varchar');
        parent::SetParameterSP($p['vp_lado'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP($p['vp_w'], 'int');
        parent::SetParameterSP($p['vp_h'], 'int');
        parent::SetParameterSP(USR_ID, 'int');
        //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function set_lotizer($p){
        $p['vp_id_lote'] =(empty($p['vp_id_lote']))?0:$p['vp_id_lote'];
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_lotizer');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP(utf8_decode(trim($p['vp_nombre'])), 'varchar');
        parent::SetParameterSP(utf8_decode(trim($p['vp_descripcion'])), 'varchar');
        parent::SetParameterSP($p['vp_tipdoc'], 'varchar');
        parent::SetParameterSP($p['vp_lote_fecha'], 'varchar');
        parent::SetParameterSP($p['vp_ctdad'], 'int');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');

         //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_lotizer($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_lotizer');
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

   public function get_lotizer_detalle($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_lotizer_detalle');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
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
    public function setSaveReproFile($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_page_error');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_id_pag'], 'int');
        parent::SetParameterSP($p['vp_id_det'], 'int');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        parent::SetParameterSP(utf8_decode(trim($p['vp_msn'])), 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
         //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
}
