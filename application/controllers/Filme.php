<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filme extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('filmes/Model_formularios');
        $this->load->model('Model_formularios', 'Filmes_formulario');
    }


    public function index()
    {
        $data = $this->Filmes_formulario->formularioLogin();
        $this->twig->display('inicio', $data);
    }


    public function login(){}


    public function cadastroFilme()
    {
        $data = $this->Filmes_formulario->cadastroFilme();
        $data['pagina_atual'] = 'Cadastrar-se';
        $this->twig->display('filme/cadastro', $data);
    }
}
