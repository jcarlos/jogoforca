<?php
class Testando extends Controller {

	function index()
	{
            $this->load->view("teste1");
	}

        function carrega(){
            $dados['variavel1'] = "um";
            $dados['variavel2'] = "dois";
            $this->load->view("teste2",$dados);
            $this->load->view("teste1");
	}

        /*function carrega($msg1, $msg2){
            $this->load->view("teste2");
        }*/
}