<?php

class test_palavra_library extends CodeIgniterUnitTestCase {

    function __construct() {
        parent::__construct();
        $this->UnitTestCase('Palavra Library');
        $this->_ci = & get_instance();
        require_once APPPATH . '/libraries/Letra.php';
        require_once APPPATH . '/libraries/Palavra.php';
    }

    public function test_geraLetras() {
        $letras_expected = array("L" => new Letra(array('letra' => 'L', 'posicoes' => array(0))));
        $params = array("palavra" => "Laranja");
        $obj = new Palavra($params);
        $letras_result = $obj->geraLetras("L");
        $this->assertIdentical($letras_result, $letras_expected);
    }

    public function test_getPalavraDescoberta_sem_letra_advinhada() {
        $params = array("palavra" => "laranja");
        $obj = new Palavra($params);
        $this->assertEqual("_ _ _ _ _ _ _", $obj->getPalavraDescoberta());
    }

    public function test_2x_marcaLetraExistente() {
        $params = array("palavra" => "Banana");
        $obj = new Palavra($params);
        $this->assertEqual(true, $obj->marcaLetra("n"));
        $this->assertEqual(true, $obj->marcaLetra("a"));
        $this->assertEqual("_ a n a n a", $obj->getPalavraDescoberta());
    }

    public function test_marcaLetraExistente() {
        $params = array("palavra" => "Laranja");
        $obj = new Palavra($params);
        $this->assertEqual(true, $obj->marcaLetra("a"));
        $this->assertEqual("_ a _ a _ _ a", $obj->getPalavraDescoberta());
    }

}