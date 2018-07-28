<?php

/**
 * Geekode php (http://plasmosys.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis @remicioluis (https://twitter.com/jbazan)
 * @version 2.0
 */

class lotizerModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list_lotizer($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_lotizer');
        parent::SetParameterSP($p['vp_name'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }

   public function get_lotizer_detalle($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_lotizer_detalle');
        parent::SetParameterSP($p['vp_cod_lote'], 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }

    public function setRegisterLotizer($p){
        $p['vp_cod_lote'] =(empty($p['vp_cod_lote']))?0:$p['vp_cod_lote'];
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'setRegisterLotizer');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_cod_lote'], 'int');
        parent::SetParameterSP($p['vp_lote_nombre'], 'varchar');
        parent::SetParameterSP($p['vp_lote_fecha'], 'varchar');
        parent::SetParameterSP($p['vp_ctdad'], 'int');
        parent::SetParameterSP($p['vp_usuario'], 'varchar');
         //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }


}
