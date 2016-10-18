<?php
class Photo extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('photo_model');
            $this->load->helper('url_helper'); // why? check
        }

        public function index() {
            $this->load->view('photo/index', $data);
        }
        
        public function search($params = NULL) {                    
            $textToSearch = $this->input->get('data');
            $params = array('textToSearch' => $textToSearch);
            log_message('debug','archivo: textToSearch'.$textToSearch);
            $data['totalCount'] = $this->photo_model->get_num_photos();
            $data['photos'] = $this->photo_model->get_photos($params); // get all cards from db        
            log_message('debug','archivo: totalCount'.$data['totalCount']);
            header('Content-Type: application/json');
            echo json_encode(array('items' => $data['photos'],'totalCount' => $data['totalCount'] ));
        }        

        public function save_card_photo($image_id = NULL) {
        	//$card = $this->input->post('archive_id');     // this is not working
        	$rawJson = file_get_contents("php://input");
        	$photo = json_decode($rawJson,true);
        	$data['success'] = $this->photo_model->save_photo($photo);
        	
        	$card_id = intval($photo['card_id']);
         	$data['photos'] = $this->photo_model->get_card_photos($card_id);
        	
         	header('Content-Type: application/json');
         	echo json_encode(array('item' => $data['photos'],'success' => $data['success']));
        }        
}
?>