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
				'id_funcao' => 2,
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


    public function criarFuncao()
	{
		$data = $this->Usuario_formularios->criarFuncao();
		$this->twig->display('usuario/criarFuncao', $data);
	}


	public function novaFuncao()
	{
		$this->form_validation->set_rules('funcao', 'função', array('required', 'min_length[2]', 'max_length[100]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ]+$/]'));

		if($this->form_validation->run() == FALSE)
		{
			$form["form_open"] = form_open("Usuario/novaFuncao", 'method="POST"');
			$form["label_funcao"] = form_label("Nome da Função:","funcao",'class=""', 'for="funcao"');
			$form["input_funcao"] = form_input(array("name" => "funcao", "id" => "funcao", "class" => "form-control", "maxlength" => "255", "placeholder" => "Ex: Administrador"),set_value('funcao'));
			$form["button_submit"] = form_button(array("type" => "submit", "content" => "Entrar", "class" => "btn btn-primary"));
			$form["form_close"] = form_close();

			$form["erros_validacao"] = array(
				"erros_funcao" => form_error('funcao'),
			);

			$this->twig->display('usuario/criarFuncao', $form);
		}
		else
		{
			$funcao = array(
				'nome_funcao' => $this->input->post('funcao'),
			);

			$this->Model_usuario->novaFuncao($funcao);
			$this->session->set_flashdata("msg_funcao_cadastro_com_sucesso", "Função cadastrada com Sucesso!");
			$this->session->set_flashdata("classe_funcao_cadastro_com_sucesso", "alert alert-success alert-dismissible fade show");
			redirect("".base_url()."usuario/Perfil");
		}
	}


	public function listarUsuario()
	{
		$totalUsuarios = $this->Model_usuario->getTotalUsuarios($this->usuario['id_usuario']);

		$this->load->library('pagination');

		$config['base_url'] = "".base_url()."usuario/listarUsuario";
		$config['total_rows'] = $totalUsuarios;
		$config['per_page'] = 1;


		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data["results"] = $this->Model_usuario->buscarUsuario($config["per_page"], $page, $this->usuario['id_usuario']);

		$this->pagination->initialize($config);

		$links = $this->pagination->create_links();
		$data['links'] = $links;
		$this->twig->display('usuario/listarUsuario', $data);

	}

	public function alterarFuncao($idUsuario)
	{
        $data = $this->Usuario_formularios->formularioAlterarFuncao($idUsuario);
        $this->twig->display('alterarFuncao', $data);
	}
}
