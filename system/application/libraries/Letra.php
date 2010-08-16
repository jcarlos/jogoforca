<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @author Joao Medrado
 *
 * Classe responsável por representar uma letra da palavra da forca
 */
class Letra{

    private $posicoes;
    private $letra;
    private $descoberta;

    /**
     * Construtor
     * Recebe um array associativo de chaves posicoes e letra
     * @param Array $params
     */
    public function Letra($params){
        $this->posicoes = $params['posicoes'];
        $this->letra = $params['letra'];
    }

    public function getLetra(){
        return $this->letra;
    }

    public function getPosicoes(){
        return $this->posicoes;
    }

    public function setDescoberta($descoberta){
        $this->descoberta = $descoberta;
    }

    public function isDescoberta(){
        return $this->descoberta;
    }
    
}