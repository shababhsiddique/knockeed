<?php

class Content_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function selectPersons() {
        $r = $this->db
                ->select("*")
                ->from("tbl_person")
                ->get()
                ->result_array();

        return $r;
    }

}
