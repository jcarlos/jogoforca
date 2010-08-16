<?php

class Jogo extends Controller {

    private $palavra;
    private $palavra_descoberta;
    private $qtd_letras;
    private $alfabeto;

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->palavra = (($this->session->userdata('palavra')==FALSE)?$this->_db_pega_palavra():$this->session->userdata('palavra'));

        /*
         * seta o valor da palavra descoberta pega da sessao
         * se o valor nao existe fica em branco
         */
        $this->palavra_descoberta = $this->session->userdata('palavra_descoberta');
        if ($this->palavra_descoberta == FALSE) {
            $this->qtd_letras = strlen($this->palavra);
            for ($i = 0; $i < $this->qtd_letras; $i++) {
                $this->palavra_descoberta .= "_";
            }
            $this->palavra_descoberta = trim($this->palavra_descoberta);
            $this->session->set_userdata('palavra_descoberta', $this->palavra_descoberta);
        }

        $this->pontuacao = ($this->session->userdata('pontuacao') ? $this->session->userdata('pontuacao') : 0);

        for ($i = 0; $i <= 256; $i++) {
            $this->alfabeto[$i] = chr($i);
        }
    }

    function index() {
        $this->troca_palavra();
    }

    function _db_pega_palavra() {
        $query = $this->db->query('SELECT UPPER(palavra) AS palavra FROM palavras ORDER BY RAND() LIMIT 1');
        $row = $query->row();
        $this->palavra = $row->palavra;
        $this->session->set_userdata('palavra',$this->palavra);
    }

    function troca_palavra() {
        $this->session->unset_userdata('palavra_descoberta');
        $this->session->unset_userdata('pontuacao');
        $this->pontuacao = 0;
        $this->palavra = $this->_db_pega_palavra();
        $this->qtd_letras = strlen($this->palavra);
        $this->palavra_descoberta = "";
        for ($i = 0; $i < $this->qtd_letras; $i++) {
            $this->palavra_descoberta .= "_";
        }
        $this->session->set_userdata('palavra_descoberta', $this->palavra_descoberta);
        $this->session->set_userdata('pontuacao', $this->pontuacao);
        $this->load->view("jogo", array("palavra" => $this->session->userdata('palavra_descoberta'),
            "letras" => $this->alfabeto,
            "pontuacao" => $this->session->userdata('pontuacao')));
    }

    function escolhe_letra($letra) {
        $pontua = false;
        $fim = false;

        if (strpos($this->palavra_descoberta, "_") === false) {
            $fim = true;
        } else {
            for ($i = 0; $i < strlen($this->palavra); $i++) {
                if ($this->palavra[$i] == $letra) {
                    $this->palavra_descoberta[$i] = $letra;
                    $pontua = true;
                }
            }
            if (strpos($this->palavra_descoberta, "_") === false) {
                $fim = true;
            }
        }

        $this->session->set_userdata('palavra_descoberta', $this->palavra_descoberta);

        // cuida da pontuacao
        $pontos = $this->session->userdata('pontuacao');
        if ($pontua) {
            $pontos += 10;
        } else {
            $pontos -= 5;
        }
        $this->pontuacao = $pontos;
        $this->session->set_userdata('pontuacao', $this->pontuacao);

        $this->load->view("jogo", array("palavra" => $this->session->userdata('palavra_descoberta'),
            "letras" => $this->alfabeto,
            "pontuacao" => $this->session->userdata('pontuacao'),
            "fim" => $fim));
    }

    function testando(){
        //$this->load->library('letra',array('letra' => 'A','posicoes' => array(1,4,6)));
        //echo $this->letra->getLetra();
        //$this->load->library('palavra');
        //$this->palavra->geraLetras("L");
        require_once APPPATH.'/libraries/Palavra.php';
        $resultado = Palavra::geraLetras("Laranja");
        echo '<pre>';
        print_r($resultado);
        echo '</pre>';

    }
}