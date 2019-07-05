<?php

class Model_formularios extends CI_Model{

    public function formularioLogin(){
        $form["form_open"] = form_open("ResenhaOnline/login", 'method="POST"');
        $form["label_email"] = form_label("Email","email",'class=""', 'for="email"');
        $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "255", "placeholder" => "Ex: seuemail@mail.com"));
        $form['label_senha'] = form_label("Senha","senha",'class=""');
        $form["input_senha"] = form_password(array("name" => "senha", "id" => "senha", "class" => "form-control w-100", "maxlength" => "255"));
        $form["button_submit"] = form_button(array("type" => "submit", "content" => "Entrar", "class" => "btn btn-primary"));
        $form["form_close"] = form_close();

        return $form;
    }

    public function cadastroUsuario(){
        $form["form_open"] = form_open("ResenhaOnline/cadastro", 'method="POST"');
        $form["label_nome"] = form_label("Nome*:","nome",'class=""', 'for="nome"');
        $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: João José"));
        $form["label_email"] = form_label("Email*:","email",'class=""', 'for="nome"');
        $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "50", "placeholder" => "Ex: seuemail@mail.com"));
        $form['label_senha'] = form_label("Senha*:","senha",'class=""');
        $form["input_senha"] = form_password(array("name" => "senha", "id" => "senha", "class" => "form-control", "maxlength" => "255"));
        $form['label_repetir_senha'] = form_label("Repetir Senha*:","repetirSenha",'class=""');
        $form["input_repetir_senha"] = form_password(array("name" => "repetirSenha", "id" => "repetirSenha", "class" => "form-control w-100", "maxlength" => "255"));
        $form["button_submit"] = form_button(array("type" => "submit", "content" => "Cadastrar", "class" => "btn btn-primary"));
        $form["form_close"] = form_close();

        return $form;
    }


    public function editarUsuario($usuario){
        $form["form_open"] = form_open("usuario/editar", 'method="POST"');
        $form["label_nome"] = form_label("Nome*:","nome",'class=""', 'for="nome"');
        $form["input_nome"] = form_input(array("name" => "nome", "id" => "nome", "class" => "form-control", "maxlength" => "100", "placeholder" => "Ex: João José", "value" => "".$usuario['nome'].""));
        $form["label_email"] = form_label("Email*:","email",'class=""', 'for="nome"');
        $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "50", "placeholder" => "Ex: seuemail@mail.com", "value" => "".$usuario['email'].""));
        $form['label_sobre'] = form_label("Sobre:","sobre",'class=""');
        $form['text_area_sobre'] = form_textarea(array("name" => "sobre", "id" => "sobre", "class" => "form-control","maxlength" => "2000", "rows"=>"5", "value" => "".$usuario['sobre'].""));
        $form["button_submit"] = form_button(array("type" => "submit", "content" => "Editar", "class" => "btn btn-primary"));
        $form["form_close"] = form_close();

        $form["form_open_senha"] = form_open("usuario/trocarSenha", 'method="POST"');
        $form['label_senha'] = form_label("Senha*:","senha",'class=""');
        $form["input_senha"] = form_password(array("name" => "senha", "id" => "senha", "class" => "form-control w-100", "maxlength" => "255"));
        $form['label_repetir_senha'] = form_label("Repetir Senha*:","repetirSenha",'class=""');
        $form["input_repetir_senha"] = form_password(array("name" => "repetirSenha", "id" => "repetirSenha", "class" => "form-control w-100", "maxlength" => "255"));
        $form['label_senha_atual'] = form_label("Senha Atual*:","senhaAtual",'class=""');
        $form["input_senha_atual"] = form_password(array("name" => "senhaAtual", "id" => "senhaAtual", "class" => "form-control w-100", "maxlength" => "255"));
        $form["button_submit_senha"] = form_button(array("type" => "submit", "content" => "Trocar Senha", "class" => "btn btn-primary"));

        return $form;
    }


    public function criarFuncao()
	{
		$form["form_open"] = form_open("Usuario/novaFuncao", 'method="POST"');
		$form["label_funcao"] = form_label("Nome da Função:","funcao",'class=""', 'for="funcao"');
		$form["input_funcao"] = form_input(array("name" => "funcao", "id" => "funcao", "class" => "form-control", "maxlength" => "255", "placeholder" => "Ex: Administrador"));
		$form["button_submit"] = form_button(array("type" => "submit", "content" => "Entrar", "class" => "btn btn-primary"));
		$form["form_close"] = form_close();

		return $form;
	}

}

