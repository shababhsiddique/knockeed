<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $layout;
    public $ajxLayout;

    public function __construct() {
        parent::__construct();

        $this->ajxLayout = array();
        $this->layout = array();
        
        $this->load->model('app/content_model',"content");

        $this->layout = array(
            "navbar" => sline($this->load->view("app/components/navbar", null, true)),
            "page_header" => "",
            "page_subheader" => "",
            "active_breadcrumb" => "",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true)),
            "content" => "",
            "content_full" => "",
            "footer" => "Copyright &copy; Your Website 2014",
        );
    }

    public function index() {

        $this->_setLayout(array(
            "page_header" => "Home",
            "page_subheader" => "Home",
            "active_breadcrumb" => "",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true)),
            "content" => "This is home page text, with an <h3>H3 Tag</h3>",
            "content_full" => "",
            "footer" => "Copyright &copy; Your Website 2014"
        ));
    }

    public function page() {

        $this->_setLayout(array(
            "page_header" => "Page",
            "page_subheader" => "This is a sample page",
            "active_breadcrumb" => "Page",
            "content_full" => "This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content. Got it",
            "sidebar" => "",
            "content" => ""
        ));
    }

    public function page2() {

        $this->_setLayout(array(
            "page_header" => "Page",
            "page_subheader" => "This is another sample page",
            "active_breadcrumb" => "Page",
            "content_full" => "",
            "content" => "This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content, This is a sample page Content. Got it",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true))
        ));
    }
    
    
    public function grid(){
        
        $gData = array(
            "person_data" => $this->content->selectPersons()
        );
        
        $this->_setLayout(array(
            "page_header" => "Grid Example",
            "page_subheader" => "This is an example of table",
            "active_breadcrumb" => "Grid",
            "content_full" => "",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true)),            
            "content" => sline($this->load->view("app/components/table", $gData, true))
        ));
        
    }

    /**
     * 
     * 
     * 
     * 
     * 
     * KO helper private functions Start
     */

    /**
     * Sets the layout array. Previously known as-
     * 
     *      $this->layout["name"]
     * 
     * @param type $array containing all view elements
     */
    private function _setLayout($array) {
        
        $this->ajxLayout = $array;
        
        if ($this->input->is_ajax_request()) {
            $this->_calcVModHash();
            echo json_encode($this->ajxLayout);
        } else {
            $this->layout = array_merge($this->layout, $this->ajxLayout);
            $this->load->view("app/main", $this->layout);
        }
    }

    /**
     * Calculate hash checksum for identifying which element needs to update.
     */
    private function _calcVModHash() {

        $DOM_MD5 = $this->input->post(NULL, true);

        foreach ($this->ajxLayout as $key => $anItem) {

            //Its an element
            if ($key[1] != "_") {

                $this->ajxLayout["__" . $key] = md5($anItem);

                //New HASH same as old hash, No update required
                if ($this->ajxLayout["__" . $key] === $DOM_MD5["__" . $key]) {
                    unset($this->ajxLayout[$key]); //Delete item from ajax response json, 
                    unset($this->ajxLayout["__" . $key]); //Delete item hash as well
                }
            }
        }
    }

}
