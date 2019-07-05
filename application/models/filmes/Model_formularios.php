<?php

class Model_formularios extends CI_Model{

    public function cadastroFilme(){
        $form["form_open"] = form_open_multipart("Filme/cadastro", 'method="POST"');
        $form["label_nome"] = form_label("Nome:","nome",'class=""', 'for="nome"');
        $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: Um Filme Legal"));
        $form['label_descricao'] = form_label("Descrição","descricao",'class=""');
        $form['text_area_descricao'] = form_textarea(array("name" => "descricao", "id" => "descricao", "class" => "form-control","maxlength" => "2000", "rows"=>"5"));
		$form["input_upload"] = form_upload(array("name" => "file", "id" => "adicionar-foto", "accept" => "image/*", "hidden" => "true","onchange" => "previewFiles()"), '');
		$form["label_upload"] = form_label("Foto de capa", "adicionar-foto", array('class' => 'btn btn-success', 'id' => 'labelFoto', 'onchange' => 'previewFiles()'));
		$form["button_submit"] = form_button(array("type" => "submit", "content" => "Cadastrar", "class" => "btn btn-primary"));
        $form["form_close"] = form_close();
		$form["label_foto"] = form_label("Alterar Foto", "adicionar-foto", array('class' => 'btn btn-success', 'id' => 'labelFoto'));


		return $form;
    }

}

