<?php

/**
 * Geekode php (http://plasmosys.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis @remicioluis (https://twitter.com/jbazan)
 * @version 2.0
 */

class returnModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }
    public function get_lista_devoluciones($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_return');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_id_dev'], 'int');
        parent::SetParameterSP($p['vp_motivo'], 'varchar');
        parent::SetParameterSP($p['vp_fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_pre_return($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_pre_return');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_id_dev'], 'int');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_pending_return($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_pending_return');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_lote'], 'int');
        parent::SetParameterSP($p['vp_lote_estado'], 'varchar');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function get_list_return($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_return');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_lote'], 'int');
        parent::SetParameterSP($p['vp_lote_estado'], 'varchar');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
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

    public function set_return($p){
            $p['vp_id_dev'] =(empty($p['vp_id_dev']))?0:$p['vp_id_dev'];
            parent::ReiniciarSQL();
            parent::ConnectionOpen($this->dsn, 'set_return');
            parent::SetParameterSP($p['vp_op'], 'varchar');
            parent::SetParameterSP($p['vp_shi_codigo'], 'int');
            parent::SetParameterSP($p['vp_fac_cliente'], 'int');
            parent::SetParameterSP($p['vp_id_dev'], 'int');
            parent::SetParameterSP($p['vp_motivo'], 'varchar');
            parent::SetParameterSP($p['vp_fecha'], 'varchar');
            parent::SetParameterSP($p['vp_hora'], 'varchar');
            parent::SetParameterSP(utf8_decode(trim($p['vp_responsable'])), 'varchar');
            parent::SetParameterSP(utf8_decode(trim($p['vp_documento'])), 'varchar');
            parent::SetParameterSP(utf8_decode(trim($p['vp_mensaje'])), 'varchar');
            parent::SetParameterSP(USR_ID, 'int');
             //echo '=>' . parent::getSql().'<br>'; exit();
            $array = parent::ExecuteSPArray();
            return $array;
    }
    public function set_pre_return($p){
            parent::ReiniciarSQL();
            parent::ConnectionOpen($this->dsn, 'set_pre_return');
            parent::SetParameterSP($p['vp_op'], 'varchar');
            parent::SetParameterSP($p['vp_shi_codigo'], 'int');
            parent::SetParameterSP($p['vp_fac_cliente'], 'int');
            parent::SetParameterSP($p['vp_id_lote'], 'int');
            parent::SetParameterSP($p['vp_id_det'], 'int');
            parent::SetParameterSP($p['vp_id_dev'], 'int');
            parent::SetParameterSP(USR_ID, 'int');
             //echo '=>' . parent::getSql().'<br>'; exit();
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
