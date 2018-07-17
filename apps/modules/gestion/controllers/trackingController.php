<?php

/**
 * JimmyAnthony php (http://jimmyanthony.com/)
 * @link    https://github.com/jbazan/geekcode_php
 * @author  Jimmy Anthony Bazán Solis (https://twitter.com/jbazan)
 * @version 2.0
 */

class trackingController extends AppController {

    private $objDatos;
    private $arrayMenu;

    public function __construct(){
        /**
         * Solo incluir en caso se manejen sessiones
         */
        $this->valida();

        $this->objDatos = new trackingModels();
    }

    public function index($p){        
        $this->view('tracking/form_index.php', $p);
    }

   public function get_list($p){
        $rs = $this->objDatos->get_list($p);
        //var_export($rs);
        $array = array();
        foreach ($rs as $index => $value){
                $value_['cod_lote'] = intval($value['cod_lote']);
                $value_['lote'] = utf8_encode(trim($value['lote']));
                $value_['fecha'] = substr(trim($value['fecha_ingre']),0,10) ;
                $value_['usuario'] = utf8_encode(trim($value['usuario']));
                $value_['cantidad'] = intval($value['cantidad']);
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

}