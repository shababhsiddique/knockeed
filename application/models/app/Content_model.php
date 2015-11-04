<?php

class Content_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function countAllPersons(){
        $r = $this->db
                ->select("*")
                ->from("tbl_person")
                ->count_all_results();

        return $r;
    }

    public function selectPersons($offset,$limit) {
        
        $r = $this->db
                ->select("*")
                ->from("tbl_person")
                ->limit($limit,$offset)
                ->get()
                ->result_array();

        return $r;
    }

}
