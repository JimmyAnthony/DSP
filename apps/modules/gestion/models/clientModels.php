<?php

/**
 * Geekode php (http://plasmosys.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis @remicioluis (https://twitter.com/jbazan)
 * @version 2.0
 */

class clientModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list_client($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_client');
      // parent::SetParameterSP($p['vp_shi_codigo'], 'int');
      //  parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['vp_date'], 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }

public function get_list_clientcontratos($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_clientcontratos');
      // parent::SetParameterSP($p['vp_shi_codigo'], 'int');
      //  parent::SetParameterSP($p['vp_fac_cliente'], 'int');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        parent::SetParameterSP($p['vp_date'], 'varchar');
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

    public function set_client($p){
        $p['vp_id_lote'] =(empty($p['vp_id_lote']))?0:$p['vp_id_lote'];
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_client');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP(utf8_decode(trim($p['vp_nombre'])), 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');

         //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function set_contrato($p){
        $p['vp_id_lote'] =(empty($p['vp_id_lote']))?0:$p['vp_id_lote'];
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_contrato');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_shi_codigo'], 'int');
        parent::SetParameterSP(utf8_decode(trim($p['vp_nombre'])), 'varchar');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP($p['vp_cod_contrato'], 'int');
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
