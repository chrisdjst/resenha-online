<?php

class Model_filme extends CI_Model{

	public function cadastrarFilme($filme){
		$this->db->insert('filme', $filme);
	}


    public function getTotalFilmes()
    {
        return $this->db->count_all("filme");
    }


    public function buscarFilme($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get("filme")->result_array();

        if (count($query) > 0) {
            return $query;
        }

        return false;
    }


    public function adicionarAosFavoritos($favortios)
	{
	    $this->db->insert('favoritos', $favortios);
    }


    public function removerDosFavoritos($idUsuario, $idFilme)
	{
		$this->db->where('id_usuario', $idUsuario);
		$this->db->where('id_filme', $idFilme);
		$this->db->delete('favoritos');
	}


	public function filmesCapa()
	{
		$this->db->limit(4);
		$this->db->order_by('id_filme', 'RANDOM');
		return $this->db->select('caminho')->get('filme')->result_array();
	}

}

