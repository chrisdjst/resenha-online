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
        $data = $this->usuario;
        $this->twig->display('usuario/perfil', $data);
    }


    public function sair()
    {
        $this->session->unset_userdata("usuario");
        redirect("".base_url()."resenha-online");
    }

    public function editarUsuario()
    {
        $data = $this->Usuario_formularios->editarUsuario($this->usuario);
        $this->twig->display('usuario/editar', $data);
    }


    public function editar()
    {
        $this->form_validation->set_rules('nome', 'Nome', array('required', 'min_length[2]', 'max_length[100]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/]'));
        $this->form_validation->set_rules('email', 'Email', array('required', 'valid_email'));
        $this->form_validation->set_rules('sobre', 'Sobre', array('required', 'max_length[2000]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/]'));

        if ($this->form_validation->run() == FALSE)
        {
            $form["form_open"] = form_open("ResenhaOnline/cadastro", 'method="POST"');
            $form["label_nome"] = form_label("Nome*:","nome",'class=""', 'for="nome"');
            $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: João José", "value"=>set_value('nome')));
            $form["label_email"] = form_label("Email*:","email",'class=""', 'for="email"');
            $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "50", "placeholder" => "Ex: seuemail@mail.com", "value"=>set_value('email')));
            $form['label_sobre'] = form_label("Sobre:","sobre",'class=""');
            $form['text_area_sobre'] = form_textarea(array("name" => "sobre", "id" => "sobre", "class" => "form-control","maxlength" => "2000", "rows"=>"5", "value" => set_value('sobre')));
            $form["button_submit"] = form_button(array("type" => "submit", "content" => "Editar", "class" => "btn btn-primary"));
            $form["form_close"] = form_close();

            $form["erros_validacao"] = array(
                "erros_nome" => form_error('nome'),
                "erros_email" => form_error('email'),
                "erros_sobre" => form_error('sobre'),
            );

            $this->twig->display('usuario/editar', $form);
        }
        else
        {


            $usuario = array(
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'sobre' => $this->input->post('sobre'),
            );

            $this->Model_usuario->editarPerfil($usuario, $this->usuario['id_usuario']);
            $this->session->set_flashdata("msg_cadastro_com_sucesso", "Cadastrado com Sucesso!");
            $this->session->set_flashdata("classe_cadastro_com_sucesso", "alert alert-success alert-dismissible fade show");
            redirect("Usuario/perfil");
        }
    }


    public function trocarSenha()
    {
        $this->form_validation->set_rules('senha', 'Senha do Usuário', array('required', 'min_length[7]'));
        $this->form_validation->set_rules('repetirSenha', 'Repetir Senha', 'required|matches[senha]');

        if ($this->form_validation->run() == FALSE)
        {
            $form["form_open"] = form_open("ResenhaOnline/cadastro", 'method="POST"');
            $form["label_nome"] = form_label("Nome*:","nome",'class=""', 'for="nome"');
            $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: João José", "value"=>set_value('nome')));
            $form["label_email"] = form_label("Email*:","email",'class=""', 'for="email"');
            $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "50", "placeholder" => "Ex: seuemail@mail.com", "value"=>set_value('email')));
            $form['label_sobre'] = form_label("Sobre:","sobre",'class=""');
            $form['text_area_sobre'] = form_textarea(array("name" => "sobre", "id" => "sobre", "class" => "form-control","maxlength" => "2000", "rows"=>"5", "value" => set_value('sobre')));
            $form["button_submit"] = form_button(array("type" => "submit", "content" => "Editar", "class" => "btn btn-primary"));
            $form["form_close"] = form_close();

            $form["erros_validacao"] = array(
                "erros_nome" => form_error('nome'),
                "erros_email" => form_error('email'),
                "erros_sobre" => form_error('sobre'),
            );

            $this->twig->display('usuario/editar', $form);
        }
        else
        {

            $senha = $this->input->post("senha");
            $senha = $this->Model_usuario->bcrypt($senha);

            $usuario = array(
                'senha' => $senha,
            );

            $this->Model_usuario->trocarSenha($usuario, $this->usuario['id_usuario']);
            $this->session->set_flashdata("msg_cadastro_com_sucesso", "Senha trocada com Sucesso!");
            $this->session->set_flashdata("classe_cadastro_com_sucesso", "alert alert-success alert-dismissible fade show");
            redirect("Usuario/perfil");
        }


    }

}
