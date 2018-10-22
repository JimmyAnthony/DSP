<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class userController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new userModels();
    }

    public function index($p){        
        $this->view('user/form_index.php', $p);
    }

   public function get_list_user($p){
        $rs = $this->objDatos->get_list_user($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
            $value_['id_user'] = intval($value['id_user']);
            $value_['usr_codigo'] = utf8_encode($value['usr_codigo']);
            $value_['usr_tipo'] = utf8_encode($value['usr_tipo']);
            $value_['usr_nombre'] = utf8_encode(trim($value['usr_nombre']));
            $value_['usr_perfil'] = utf8_encode(trim($value['usr_perfil']));
            $value_['usr_estado'] = trim($value['usr_estado']);
            $value_['fecact'] = trim($value['fecact']);
            $value_['hora'] = trim($value['hora']);
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
    public function set_save($p){
        $rs = $this->objDatos->set_save($p);
        $rs = $rs[0];
        $data = array(
            'success' => true,
            'error' => $rs['status'],
            'msn' => utf8_encode(trim($rs['response']))
        );
        header('Content-Type: application/json');
        return $this->response($data);
    }
}