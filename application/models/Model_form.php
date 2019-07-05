<?php

class php extends CI_Model{

    public function formularioLogin(){
        $form["form_open"] = form_open("Usuario/autenticar", 'method="POST"');
        $form["label_email"] = form_label("Email","email",'class="color-label-brown"');
        $form["input_email"] = form_input(array("name" => "email", "id" => "email", "class" => "form-control", "maxlength" => "255"));
        $form['label_senha'] = form_label("Senha","senha",'class="color-label-brown"');
        $form["input_senha"] = form_password(array("name" => "senha", "id" => "senha", "class" => "", "maxlength" => "255"));
        $form["button_submit"] = form_button(array("type" => "submit", "content" => "Entrar", "class" => "ui submit green button fluid color-button"));
        $form["form_close"] = form_close();

        return $form;
    }

}

