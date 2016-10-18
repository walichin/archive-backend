<?php
class Negative extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('negative_model');
            $this->load->helper('url_helper');
        }

        public function index() {
            $this->load->view('negative/index', $data);
        }
        
        public function search_wk($params = NULL) {
        	 
        	$aditional_data = $this->input->get('aditional_data');
        	 
        	if (!isset($aditional_data)) {
        		$aditional_data = 'false';
        	} else {
        		if ($aditional_data != 'true') {
        			$aditional_data = 'false';
        		} else {
        			$aditional_data = 'true';
        		}
        	}
        	 
        	$offset = $this->input->get('offset');
        	$limit = $this->input->get('limit');
        	$negative_id_search = $this->input->get('negative_id_search');
        	$filename_search = $this->input->get('filename_search');
        	$box_search = $this->input->get('box_search');
        	$section_search = $this->input->get('section_search');
        	$location_search = $this->input->get('location_search');
        	$imgnro_search = $this->input->get('imgnro_search');
        
        	$params = array(
        			'negative_id_search' => $negative_id_search,
        			'filename_search' => $filename_search,
        			'box_search' => $box_search,
        			'section_search' => $section_search,
        			'location_search' => $location_search,
        			'imgnro_search' => $imgnro_search);
        	 
        	$data['totalCount'] = $this->negative_model->get_num_negatives_wk($params);
        	log_message('debug','archivo: totalCount'.$data['totalCount']);
        
        	if ($data['totalCount'] > 0) {
        		
        		$params = array(
        				'full_search' => 'false',
        				'total_count' => $data['totalCount'],
        				'offset' => $offset,
        				'limit' => $limit,
        				'negative_id_search' => $negative_id_search,
        				'filename_search' => $filename_search,
        				'box_search' => $box_search,
        				'section_search' => $section_search,
        				'location_search' => $location_search,
        				'imgnro_search' => $imgnro_search);
        		
        		$data['negatives'] = $this->negative_model->get_negatives_wk($params);
        		 
        		if ($aditional_data == 'true') {
        		
        			$params = array(
        					'full_search' => 'true',
        					'total_count' => $data['totalCount'],
        					'offset' => $offset,
        					'limit' => $limit,
        					'negative_id_search' => $negative_id_search,
        					'filename_search' => $filename_search,
        					'box_search' => $box_search,
        					'section_search' => $section_search,
        					'location_search' => $location_search,
        					'imgnro_search' => $imgnro_search);
        			 
        			$data['extra_data'] = $this->negative_model->get_negatives_wk($params);
        		
        			header('Content-Type: application/json');
        			echo json_encode(array(
        					'items' => $data['negatives'],
        					'totalCount' => $data['totalCount'],
        					'extra_data' => $data['extra_data']));
        		} else {
        		
        			header('Content-Type: application/json');
        			echo json_encode(array(
        					'items' => $data['negatives'],
        					'totalCount' => $data['totalCount']));
        		}
        	} else {
        		
        		// no hay registros (totalCount == 0)
        		header('Content-Type: application/json');
        		echo json_encode(array(
        				'totalCount' => $data['totalCount']));
        	}
        }
        
        public function view_wk($negative_id = NULL) {
        	log_message('debug','archivo: view_wk:'.$negative_id);
        	$data['negative'] = $this->negative_model->get_negative_wk($negative_id);
        	$data['negative']['cards'] = $this->negative_model->get_negative_cards_wk($negative_id);
        	header('Content-Type: application/json');
        	echo json_encode(array('item' => $data['negative']));
        }
        
        public function new_negative_wk($list_param = NULL) {
        	
        	$list_param = $this->input->post('list_param');
        	//$list_param  = (string) {"img_name":"walter.jpg","box":"...","section":"...",...}
        	
        	log_message('debug','archivo: new_negative_wk: $list_param:'.$list_param);
        	 
        	$negative = json_decode($list_param, true);
        	//$negative  =  {"img_name":"walter.jpg","box":"...","section":"...",...}
        	
        	log_message('debug','archivo: img_name: '.$negative["img_name"]);
        
       		$data['negative_id'] = $this->negative_model->insert_negative_wk($negative);
       		
       		log_message('debug','archivo: negative_id: '.$data['negative_id']);
       		
       		header('Content-Type: application/json');
       		echo json_encode(array('negative_id' => $data['negative_id']));
        }

        public function new_card_wk($list_param = NULL) {
        	 
        	$list_param = $this->input->post('list_param');
        	//$list_param  = (string) {"title":"...","description":"...",...}
        	 
        	log_message('debug','archivo: new_card_wk: $list_param:'.$list_param);
        
        	$card = json_decode($list_param, true);
        	//$card  =  {"title":"...","description":"...",...}
        	 
        	log_message('debug','archivo: title: '.$card['title']);
        
        	$data['card_id'] = $this->negative_model->insert_card_wk($card);
        	
        	log_message('debug','archivo: card_id: '.$data['card_id']);
        	
        	header('Content-Type: application/json');
        	echo json_encode(array('card_id' => $data['card_id']));
        }
}
?>
