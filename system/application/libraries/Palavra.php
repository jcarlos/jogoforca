<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once APPPATH . '/libraries/Letra.php';

/**
 * @author Joao Medrado
 *
 * Classe responsável por representar uma palavra da forca
 */
class Palavra {

    /**
     * Tamanho da palavra
     * @var int
     */
    private $tamanho;
    /**
     * Array de objetos tipo Letra
     * @var array<Letra>
     */
    private $letras;
    /**
     * Palavra com as letras que ja foram descobertas
     * @var String
     */
    private $palavra_descoberta;
    /**
     * Palavra completa
     * @var String
     */
    private $palavra;

    /**
     * Recebe array do tipo array('palavra'=> $palavra)
     * @param array $palavra
     */
    public function Palavra($params) {
        $palavra = $params['palavra'];
        $this->tamanho = strlen($palavra);
        $this->palavra = $palavra;
        $this->palavra_descoberta = "";
        // popula o array de palavras
        $this->letras = Palavra::geraLetras($palavra);
    }

    /**
     * Metodo responsavel por substituir os _ pela letra caso ela existe
     * Se a letra existir retorna true, caso contrario retorna false
     *
     * Parametro que recebe o caractere a ser descoberto
     * @param Char $l
     * @return boolean
     */
    public function marcaLetra($l) {
        $r = false;
        // se a letra existe
        if (isset($this->letras[$l])) {
            // marca a letra como encontrada
            $this->letras[$l]->setDescoberta(true);
            // atualiza a palavra descoberta para refletir a letra encontrada
            $this->atualizaPalavraDescoberta();
            $r = true;
        }
        return $r;
    }

    /**
     * Atualiza o estado interno da $PalavraDescoberta
     *
     * @return String
     */
    private function atualizaPalavraDescoberta() {
        $palavra = array();
        $r = "";
        // percorre todas as letras para substituir na $palavra por letra ou _
        foreach ($this->letras as $letra) {
            // para cada posicao que a letra ocupa
            foreach ($letra->getPosicoes() as $posicao) {
                // se ela foi encontrada
                if ($letra->isDescoberta()) {
                    // coloca na palavra
                    $palavra[$posicao] = $letra->getLetra();
                } else {
                    // se nao deixa ela oculta
                    $palavra[$posicao] = "_";
                }
            }
        }
        // ordena o array pelo indice (posicao) o contem as letras da palavra
        ksort($palavra);
        // transforma o array em string
        $palavra = implode($palavra);
        // adicionado espaco entre cada uma das letras
        for ($i = 0; $i < strlen($palavra); $i++) {
            $r .= substr($palavra, $i, 1) . " ";
        }
        // retirando o ultimo espaco
        $this->palavra_descoberta = rtrim($r);
        return $this->palavra_descoberta;
    }

    // retorna a palavra descoberta
    public function getPalavraDescoberta() {
        if ($this->palavra_descoberta == "") {
            // se ainda nao tem palavra descoberta, executa o algoritmo para
            // retorna-la
            $this->palavra_descoberta = $this->atualizaPalavraDescoberta();
        }
        return $this->palavra_descoberta;
    }

    /**
     * Recebe uma string e retorna um array contendo objetos Letra daquela string
     * @param String $palavra
     * @return array<Letra>
     */
    public static function geraLetras($palavra) {
        // array contendo objetos letra que a funcao retorna
        $objs_letra = array();
        // armazena array no formato letras['letra'] = array('posicao1','posicao2',...)
        $letras = array();
        // percorre todas as letras da palavra armazenando sua posicao
        for ($i = 0; $i < strlen($palavra); $i++) {
            // pega letra da posicao do for
            $char = substr($palavra, $i, 1);
            // se nao tem no array coloca o primeiro elemento
            if (!isset($letras[$char])) {
                $letras[$char] = array($i);
            } else {
                // se ja tem, complementa
                array_push($letras[$char], $i);
            }
        }
        // varre as letras encontradas para gerar os objetos letra
        foreach ($letras as $l => $posicoes) {
            $params = array("letra" => $l, 'posicoes' => $posicoes);
            $objs_letra[$l] = new Letra($params);
        }
        // retorna colecao dos objetos
        return $objs_letra;
    }

}