<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public $layout;
    public $ajxLayout;

    public function __construct() {
        parent::__construct();

        $this->ajxLayout = array();
        $this->layout = array();

        $this->load->model('app/content_model', "content");

        $this->layout = array(
            "navbar" => sline($this->load->view("app/components/navbar", null, true)),
            "page_header" => "",
            "page_subheader" => "",
            "active_breadcrumb" => "",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true)),
            "content" => "",
            "content_full" => "",
            "content_multi" => array(),
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
            "content_multi" => array(
                "view_nam_1" => "<h4>some text here  </h4>",
                "view_nam_2" => "<h4>some text here 2</h4>",
                "view_nam_3" => "<h4>some text here 3</h4>",
                "view_nam_4" => "<h4>some text here 4</h4>"
            ),
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
            "content_multi" => array(
                "view_nam_1" => "<h4>some text here  </h4>",
                "view_nam_7" => "<h4>some text here 7</h4>"
            ),
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true))
        ));
    }

    public function grid($offset = 0) {

        /*
         * Pagination,
         */
        $config = pagination_config(array(
            'base_url' => site_url('home/grid'),
            'total_rows' => $this->content->countAllPersons(),
            'per_page' => 5
        ));

        $this->pagination->initialize($config);

        $gData = array(
            "person_data" => $this->content->selectPersons($offset, $config['per_page']),
            "pagination" => $this->pagination->create_links()
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

    public function form($id = 0) {

        $action = $this->input->post("action");
        if($action == "submit"){
            
            $this->content->savePerson($this->input->post(NULL,TRUE),$id);
        }
        
        //Common stuff
        $layoutData = array(
            "active_breadcrumb" => "form",
            "content_full" => "",
            "sidebar" => sline($this->load->view("app/components/sidebar", null, true))
        );
        
        if($id == 0){
            $layoutData["page_header"] = "Add Person";
            $layoutData["page_subheader"] = "Add New Person Data";
            $layoutData["content"] = sline($this->load->view("app/components/form", null , true));
        }else{
            
            $formData["oldData"] = $this->content->selectPersonById($id);
            
            $layoutData["page_header"] = "Edit Person";
            $layoutData["page_subheader"] = "Edit Person Data";
            $layoutData["content"] = sline($this->load->view("app/components/form", $formData, true));
        }
        
        $this->_setLayout($layoutData);    
        
    }
    
    
    
    public function delete($id = 0,$oldUrlSeg2,$oldUrlSeg3=0){
        if($id != 0){
            $this->content->deletePerson($id);
        }        
        $this->$oldUrlSeg2($oldUrlSeg3);
        redirect("home/$oldUrlSeg2/$oldUrlSeg3");
        //$this->$oldUrlSeg2($oldUrlSeg3);
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
     *      $this->layout["viewvariable"]
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

        $DOM_MD5 = $this->input->get(NULL, true);


        $oldContentHash = json_decode($DOM_MD5["__content_multi"], true);

        $targetContents = array();
        $targetContentHash = array();

        //Handle content_multi if exist
        if (isset($this->ajxLayout["content_multi"])) {

            $targetContents = $this->ajxLayout["content_multi"];        //This is whats supposed to look like
            unset($this->ajxLayout["content_multi"]);

            foreach ($targetContents as $targetViewName => $aTargetItem) {
                $targetContentHash[$targetViewName] = md5($aTargetItem);

                if (isset($oldContentHash[$targetViewName])) {
                    //Same view name Exists already
                    if ($targetContentHash[$targetViewName] === $oldContentHash[$targetViewName]) {
                        //Erase same view with same data
                        unset($targetContents[$targetViewName]);                    //Remove item which already exists.
                    }
                }
            }

            $targetContentHash = json_encode($targetContentHash);
        }

        //All old data removed from response, now remove old data from dom that does not belong to the new data



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

        $this->ajxLayout["content_multi"] = $targetContents;
        $this->ajxLayout["__content_multi"] = $targetContentHash;
    }

}
