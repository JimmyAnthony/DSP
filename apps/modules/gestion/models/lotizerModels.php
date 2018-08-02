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
        parent::SetParameterSP($p['nombre'], 'varchar');
        parent::SetParameterSP($p['fecha'], 'varchar');
        parent::SetParameterSP($p['estado'], 'varchar');
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
        parent::SetParameterSP($p['vp_nombre'], 'varchar');
        parent::SetParameterSP($p['vp_tipdoc'], 'varchar');
        parent::SetParameterSP($p['vp_lote_fecha'], 'varchar');
        parent::SetParameterSP($p['vp_ctdad'], 'int');
        parent::SetParameterSP($p['vp_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');        

         //echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }


}
