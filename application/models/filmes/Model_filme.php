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


    public function adicionarAosFavoritos($favortios){
	    $this->db->insert('favoritos', $favortios);
    }

}

