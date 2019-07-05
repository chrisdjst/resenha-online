<?php

class Model_filme extends CI_Model{

	public function cadastrarFilme($filme){
		$this->db->insert('filme', $filme);
	}

}

