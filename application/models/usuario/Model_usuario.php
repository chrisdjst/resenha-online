
<?php

class Model_usuario extends CI_Model{

    public function bcrypt($senha)
    {
        $tamanho = 22;
        $alfabeto = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $minimo = 0;
        $maximo = strlen($alfabeto) - 1;

        // Gerando a sequencia
            $salt = '';
            for ($i = $tamanho; $i > 0; --$i) {

         // Sorteando uma posicao do alfabeto
                $posicao_sorteada = mt_rand($minimo, $maximo);

        // Obtendo o simbolo correspondente do alfabeto
                $caractere_sorteado = $alfabeto[$posicao_sorteada];

        // Incluindo o simbolo na sequencia
                $salt .= $caractere_sorteado;
            }

        // Sequencia pronta
            $custo = 10;
            $senha = crypt($senha, '$2a$'. $custo . '$' . $salt . '$');
            return $senha;
    }


    public function cadastrar($usuario)
    {
        $this->db->insert('usuario', $usuario);
    }


	public function novaFuncao($funcao)
	{
		$this->db->insert('funcao', $funcao);
	}


	public function trocarSenha($usuario, $idUsuario)
    {
        $this->db->where('id_usuario', $idUsuario);
        $this->db->update('usuario', $usuario);
    }


    public function buscarHash($email)
    {
        $this->db->where("email", $email);
        $this->db->select('senha');
        $hash = $this->db->get("usuario")->row_array();
        return $hash['senha'];
    }


    public function logar($email, $senha)
    {
        $hash = $this->buscarHash($email);

        $senha = crypt($senha, $hash);

        $this->db->where("email", $email);
        $this->db->where("senha", $senha);
        $usuario = $this->db->get("usuario")->row_array();

        return $usuario;
    }


    public function editarPerfil($usuario, $idUsuario)
    {
        $this->db->where('id_usuario', $idUsuario);
        $this->db->update('usuario', $usuario);

        $this->db->where('id_usuario', $idUsuario);
        $usuario = $this->db->get("usuario")->row_array();

        $this->session->unset_userdata('usuario');
        $this->session->set_userdata('usuario', $usuario);
    }


    public function getTotalUsuarios()
	{
    	return $this->db->count_all("usuario");
	}


	public function buscarUsuario($limit, $start)
	{
		$this->db->limit($limit, $start);
		$query = $this->db->get("usuario")->result_array();

		if (count($query) > 0) {
			for( $i = 0; $i < count($query); $i++)
			{
				$query[$i]['funcao'] = $this->buscarNomeFuncao($query[$i]['id_funcao']);
			}

			return $query;
		}

		return false;
	}


	public function buscarNomeFuncao($idFuncao)
	{
				  $this->db->where('id_funcao', $idFuncao);
				  $this->db->select('nome_funcao');
		$funcao = $this->db->get('funcao')->row_array();
		return $funcao['nome_funcao'];
	}

}



