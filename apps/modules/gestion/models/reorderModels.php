<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class reorderModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
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
    public function set_reorder($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_reorder');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_id_lote'], 'int');
        parent::SetParameterSP($p['vp_nivel'], 'int');
        parent::SetParameterSP($p['vp_hijo'], 'int'); 
        parent::SetParameterSP($p['vp_padre'], 'int');
        parent::SetParameterSP(utf8_decode(trim($p['vp_nombre'])), 'varchar');
        parent::SetParameterSP($p['vp_order'], 'int');
        parent::SetParameterSP(USR_ID, 'int');
         //echo '=>' . parent::getSql().'<br>'; //exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
}
