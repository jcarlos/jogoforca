<?php
/**
 * @author João Medrado
 * Testa library letra
 */
class test_letra_library extends CodeIgniterUnitTestCase {

    function __construct() {
        parent::__construct();
        $this->UnitTestCase('Letra Library');
        $this->_ci = & get_instance();
    }

    /**
     * Testa se a letra passada no construtor eh a mesma que getLetra retorna
     */
    public function test_getLetra() {
        $letra = 'a';
        $params = array('letra' => $letra, 'posicoes' => array(1, 3, 4));
        $this->_ci->load->library('letra', $params);
        $this->assertEqual($letra, $this->_ci->letra->getLetra());
    }

    /**
     * Testa se as posicoes passadas no construtor sao as retornas por getPosicoes
     */
    public function test_getPosicoes(){
        $posicoes = array(1, 3, 4);
        $params = array('letra' => 'A', 'posicoes' => $posicoes);
        $this->_ci->load->library('letra', $params);
        //print_r($this->_ci);
        $this->assertEqual($posicoes, $this->_ci->letra->getPosicoes());
    }

    /**
     * Testa se marcacao da letra como nao descoberta
     */
    public function test_is_descoberta_false(){
        $posicoes = array(1, 3, 4);
        $params = array('letra' => 'A', 'posicoes' => $posicoes);
        $this->_ci->load->library('letra', $params);
        $this->_ci->letra->setDescoberta(false);
        $this->assertEqual(false, $this->_ci->letra->isDescoberta());
    }

    /**
     * Testa marcacao da letra como descoberta
     */
    public function test_is_descoberta_true(){
        $posicoes = array(1, 3, 4);
        $params = array('letra' => 'A', 'posicoes' => $posicoes);
        $this->_ci->load->library('letra', $params);
        $this->_ci->letra->setDescoberta(true);
        $this->assertEqual(true, $this->_ci->letra->isDescoberta());
    }
}