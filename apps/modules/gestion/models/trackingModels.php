<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class trackingModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list_lotizer($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_lotizer_search');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_lote'], 'int');
        parent::SetParameterSP($p['vp_cod_trazo'], 'int');
        parent::SetParameterSP($p['vp_lote_estado'], 'varchar');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_history($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_history');
        parent::SetParameterSP($p['vp_lote'], 'int');
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
    public function get_ocr_trazos($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_ocr_trazos');
        parent::SetParameterSP($p['vp_cod_plantilla'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
}
