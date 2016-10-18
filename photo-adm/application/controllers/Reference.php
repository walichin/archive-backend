<?php
class Reference extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('reference_model');
            $this->load->helper('url_helper');
        }

        public function index() {
            //$data['title'] = 'index() method called';
            //$this->load->view('card/index', $data);
        }
        
        public function all($params = NULL) {                    
            $photoTypes = $this->reference_model->get_photo_types();
            $primaryTopics = $this->reference_model->get_primary_topics();
            $secondaryTopics = $this->reference_model->get_secondary_topics();
            $categories = $this->reference_model->get_categories();

            $statuses = array(
                array("id" => 'PEND', "name" => 'Pending'),
                array("id" => 'VERF', "name" => 'Verified')
            );            

            $activeTypes = array(
                array("id" => 'Y', "name" => 'True'),
                array("id" => 'N', "name" => 'False')
            );             

            $decades = array(
                array("id" => '1920'),
                array("id" => '1930'),
                array("id" => '1940'),
                array("id" => '1950'),
                array("id" => '1960'),
                array("id" => '1970')
            );     

            $cardPositions = array(
                array("id" => 'E', "name" => 'East'),
                array("id" => 'O', "name" => 'West'),
                array("id" => 'N', "name" => 'North'),
                array("id" => 'S', "name" => 'South')                
            );                          

            $negativeTypes = $this->reference_model->get_negative_types();
            $observations = $this->reference_model->get_observations();
            $formats = $this->reference_model->get_formats();
            $processes = $this->reference_model->get_processes();

            header('Content-Type: application/json');
            echo json_encode(
                array(
                    'photoTypes' => $photoTypes,
                    'primaryTopics' => $primaryTopics,
                    'secondaryTopics' => $secondaryTopics,
                    'activeTypes' => $activeTypes,
                    'statuses' => $statuses,
                    'decades' => $decades,
                    'negativeTypes' => $negativeTypes,
                    'categories' => $categories,
                    'observations' => $observations,
                    'formats' => $formats,
                    'processes' => $processes,
                    'cardPositions' => $cardPositions
                    )
                );
        }        

}
?>