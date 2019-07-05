<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

    private $usuario;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario/Model_formularios');
        $this->load->model('Model_formularios', 'Usuario_formularios');
        $this->load->model('usuario/Model_usuario');
        $this->load->model('Model_usuario');

        IF($this->session->userdata('usuario'))
        {
            $this->usuario = $this->session->userdata('usuario');
            $this->twig->addGlobal('usuario', $this->usuario);
        }
        ELSE{
            redirect("".base_url()."resenha-online/");
        }

    }


    public function perfil()
    {
        $this->usuario;
        $this->twig->display('usuario/perfil');
    }


    public function sair()
    {
        $this->session->unset_userdata("usuario");
        redirect("".base_url()."resenha-online");
    }

    public function editarUsuario()
    {

    }

}
