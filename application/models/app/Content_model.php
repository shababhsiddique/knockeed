<?php

class Content_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function countAllPersons() {
        $r = $this->db
                ->select("*")
                ->from("tbl_person")
                ->count_all_results();

        return $r;
    }

    public function selectPersons($offset, $limit) {

        $r = $this->db
                ->select("*")
                ->from("tbl_person")
                ->limit($limit, $offset)
                ->get()
                ->result_array();

        return $r;
    }

    public function selectPersonById($id) {

        return $this->db->select("*")
                        ->from("tbl_person")
                        ->where("person_id", $id)
                        ->get()
                        ->row_array();
    }

    public function savePerson($data, $id) {


        unset($data['action']);
        if ($id == 0) {
            $this->db->insert("tbl_person",$data);
        } else {
            $this->db->where("person_id", $id)
                    ->update("tbl_person", $data);
        }
    }

    public function deletePerson($id) {

        $this->db->where("person_id", $id)
                ->delete("tbl_person");
    }

}
