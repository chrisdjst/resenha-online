<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filme extends CI_Controller {

	private $usuario;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('filmes/Model_formularios');
        $this->load->model('Model_formularios', 'Filmes_formulario');
		$this->load->model('filmes/Model_filme');
		$this->load->model('Model_filme');

		IF($this->session->userdata('usuario'))
		{
			$this->usuario = $this->session->userdata('usuario');
			$this->twig->addGlobal('usuario', $this->usuario);
		}
		ELSE{
			redirect("".base_url()."resenha-online/");
		}
    }

    public function index()
	{
		redirect("".base_url()."Filme/cadastroFilme");
	}


    public function cadastroFilme()
    {
        $data = $this->Filmes_formulario->cadastroFilme();
        $data['pagina_atual'] = 'Cadastrar-se';
        $this->twig->display('filme/cadastro', $data);
    }


    public function cadastro()
	{

		$this->form_validation->set_rules('nome', 'Nome', array('required', 'min_length[2]', 'max_length[100]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ1234567890]+$/]'));
		$this->form_validation->set_rules('descricao', 'Descrição', array('required', 'max_length[2000]', 'regex_match[/^[ A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ,-.]+$/]'));

		if ($this->form_validation->run() == FALSE)
		{
			$form["form_open"] = form_open_multipart("Filme/cadastro", 'method="POST"');
			$form["label_nome"] = form_label("Nome:","nome",'class=""', 'for="nome"');
			$form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: Um Filme Legal", "value" => set_value('nome')));
			$form['label_descricao'] = form_label("Descrição","descricao",'class=""');
			$form['text_area_descricao'] = form_textarea(array("name" => "descricao", "id" => "descricao", "class" => "form-control","maxlength" => "2000", "rows"=>"5", 'value' => set_value('descricao')));
			$form["input_upload"] = form_upload(array("name" => "file", "id" => "adicionar-foto", "accept" => "image/*", "hidden" => "true","onchange" => "previewFiles()"));
			$form["label_upload"] = form_label("Foto de capa", "adicionar-foto", array('class' => 'btn btn-success', 'id' => 'labelFoto', 'onchange' => 'previewFiles()'));
			$form["button_submit"] = form_button(array("type" => "submit", "content" => "Cadastrar", "class" => "btn btn-primary"));
			$form["form_close"] = form_close();

			$form["form_close"] = form_close();


			$form["erros_validacao"] = array(
				"erros_nome" => form_error('nome'),
				"erros_descricao" => form_error('descricao'),
				"erros_file" => form_error('file'),
			);

			$this->twig->display('filme/cadastro', $form);
		}
		else
		{

			$filme = array(
				'nome' => $this->input->post('nome'),
				'descricao' => $this->input->post('descricao'),
				'caminho' => "".base_url()."/static/images/".$data['file_name'],
			);
			$this->Model_filme->cadastrarFilme($filme);
			$this->session->set_flashdata("msg_cadastro_com_sucesso", "Cadastrado com Sucesso!");
			$this->session->set_flashdata("classe_cadastro_com_sucesso", "alert alert-success alert-dismissible fade show");
			redirect("Usuario/perfil");
		}

	}


	public function listarFilmes(){
        $totalFilmes = $this->Model_filme->getTotalFilmes();

        $this->load->library('pagination');

        $config['base_url'] = "".base_url()."filme/listarFilmes";
        $config['total_rows'] = $totalFilmes;
        $config['per_page'] = 2;


        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["results"] = $this->Model_filme->buscarFilme($config["per_page"], $page);

        $this->pagination->initialize($config);

        $links = $this->pagination->create_links();
        $data['links'] = $links;
        $this->twig->display('filme/listarFilme', $data);
    }


    public function adicionarFavoritos($idFilme){
        $favoritos = array(
            'id_usuario' => $this->usuario['id_usuario'],
            'id_filme' => $idFilme,
        );

        $this->Model_filme->adicionarAosFavoritos($favoritos);
        redirect("Usuario/Perfil");
    }
}
