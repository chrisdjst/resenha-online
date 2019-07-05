<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResenhaOnline extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario/Model_formularios');
        $this->load->model('Model_formularios', 'Usuario_formularios');
        $this->load->model('usuario/Model_usuario');
        $this->load->model('Model_usuario');
    }


	public function index()
	{
	    $data = $this->Usuario_formularios->formularioLogin();
        $this->twig->display('inicio', $data);
	}


	public function cadastroUsuario()
    {
	    $data = $this->Usuario_formularios->cadastroUsuario();
	    $this->twig->display('usuario/cadastro', $data);
    }

    public function login()
    {

        $email = $this->input->post("email");
        $senha = $this->input->post("senha");


        $usuario = $this->Model_usuario->logar($email, $senha);


        IF($usuario){

            $this->session->set_userdata("usuario", $usuario);

            redirect("Usuario/perfil");
        }
        ELSE {

            $this->session->set_flashdata('msg_login', "Email ou Senha invalidos!");
            $this->session->set_flashdata('class_msg_login', 'alert alert-danger alert-dismissible fade show');
            redirect("".base_url()."resenha-online");
        }
    }

    public function cadastro()
    {
        $this->form_validation->set_rules('nome', 'Nome*:', array('required', 'min_length[2]', 'max_length[100]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/]'));
        $this->form_validation->set_rules('email', 'Email*:', 'required|is_unique[usuario.email]|valid_email');
        $this->form_validation->set_rules('senha', 'Senha*:', array('required', 'min_length[7]'));
        $this->form_validation->set_rules('repetirSenha', 'Senha Repetir*:', 'required|matches[senha]');

        if ($this->form_validation->run() == FALSE)
        {
            $form["form_open"] = form_open("ResenhaOnline/cadastro", 'method="POST"');
            $form["label_nome"] = form_label("Nome*:","nome",'class=""', 'for="nome"');
            $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: João José", "value"=>set_value('nome')));
            $form["label_email"] = form_label("Email*:","email",'class=""', 'for="nome"');
            $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "50", "placeholder" => "Ex: seuemail@mail.com", "value"=>set_value('email')));
            $form['label_senha'] = form_label("Senha*:","senha",'class=""');
            $form["input_senha"] = form_password(array("name" => "senha", "id" => "senha", "class" => "form-control w-100", "maxlength" => "255"));
            $form['label_repetir_senha'] = form_label("Repetir Senha*:","repetirSenha",'class=""');
            $form["input_repetir_senha"] = form_password(array("name" => "repetirSenha", "id" => "repetirSenha", "class" => "form-control w-100", "maxlength" => "255"));
            $form["button_submit"] = form_button(array("type" => "submit", "content" => "Entrar", "class" => "btn btn-primary"));
            $form["form_close"] = form_close();

            $form["erros_validacao"] = array(
                "erros_nome" => form_error('nome'),
                "erros_email" => form_error('email'),
                "erros_senha" => form_error('senha'),
                "erros_repetirSenha" =>form_error('repetirSenha'),
            );

            $this->twig->display('usuario/cadastro', $form);
        }
        else
        {
            $senha = $this->input->post("senha");
            $senha = $this->Model_usuario->bcrypt($senha);

            $usuario = array(
                'nome' => $this->input->post('nome'),
                'email' => $this->input->post('email'),
                'senha' => $senha,
            );

            $this->Model_usuario->cadastrar($usuario);
            $this->session->set_flashdata("msg_cadastro_com_sucesso", "Cadastrado com Sucesso!");
            $this->session->set_flashdata("classe_cadastro_com_sucesso", "alert alert-success alert-dismissible fade show");
            redirect("".base_url()."resenha-online/");
        }


    }
}
