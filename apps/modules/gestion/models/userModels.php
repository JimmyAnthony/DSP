<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class userModels extends Adodb {

    private $dsn;

    public function __construct(){
        $this->dsn = Common::read_ini(PATH.'config/config.ini', 'server_main');
    }

    public function get_list_user($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'get_list_user');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_nombre'], 'varchar');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
    public function set_save($p){
        parent::ReiniciarSQL();
        parent::ConnectionOpen($this->dsn, 'set_user');
        parent::SetParameterSP($p['vp_op'], 'varchar');
        parent::SetParameterSP($p['vp_id_user'], 'varchar');
        parent::SetParameterSP($p['vp_usr_codigo'], 'varchar');
        parent::SetParameterSP(sha1($p['vp_usr_passwd']), 'varchar');
        parent::SetParameterSP($p['vp_usr_nombre'], 'varchar');
        parent::SetParameterSP($p['vp_usr_perfil'], 'varchar');
        parent::SetParameterSP($p['vp_usr_estado'], 'varchar');
        parent::SetParameterSP(USR_ID, 'int');
        // echo '=>' . parent::getSql().'<br>'; exit();
        $array = parent::ExecuteSPArray();
        return $array;
    }
}
