<?php
class Card extends CI_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('card_model');
            $this->load->helper('url_helper');
        }

        public function index() {
            $data['title'] = 'index() method called';
            $this->load->view('card/index', $data);
        }
        
        public function search($params = NULL) {                    
        	
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
            $card_id_search = $this->input->get('card_id_search');
            $card_number_search = $this->input->get('card_number_search');
            $title_search = $this->input->get('title_search');
            $description_search = $this->input->get('description_search');
            
            $params = array(
            		'title_search' => $title_search,
            		'description_search' => $description_search,
            		'card_id_search' => $card_id_search,
            		'card_number_search' => $card_number_search);
             
            $data['totalCount'] = $this->card_model->get_num_cards($params);
            log_message('debug','archivo: totalCount'.$data['totalCount']);
            
            if ($data['totalCount'] > 0) {
            	
            	$params = array(
            			'full_search' => 'false',
            			'total_count' => $data['totalCount'],
            			'offset' => $offset,
            			'limit' => $limit,
            			'title_search' => $title_search,
            			'description_search' => $description_search,
            			'card_id_search' => $card_id_search,
            			'card_number_search' => $card_number_search);
            	 
            	$data['cards'] = $this->card_model->get_cards($params);
            	 
            	if ($aditional_data == 'true') {
            	
            		$params = array(
            				'full_search' => 'true',
            				'total_count' => $data['totalCount'],
            				'offset' => $offset,
            				'limit' => $limit,
            				'title_search' => $title_search,
            				'description_search' => $description_search,
            				'card_id_search' => $card_id_search,
            				'card_number_search' => $card_number_search);
            	
            		$data['extra_data'] = $this->card_model->get_cards($params);
            	
            		header('Content-Type: application/json');
            		echo json_encode(array(
            				'items' => $data['cards'],
            				'totalCount' => $data['totalCount'],
            				'extra_data' => $data['extra_data']));
            	} else {
            	
            		header('Content-Type: application/json');
            		echo json_encode(array(
            				'items' => $data['cards'],
            				'totalCount' => $data['totalCount']));
            	}
            } else {
            	
            	// no hay registros (totalCount == 0)
            	header('Content-Type: application/json');
            	echo json_encode(array(
            			'totalCount' => $data['totalCount']));
            }
        }        

       public function view($card_id = NULL) {
            $data['card'] = $this->card_model->get_card($card_id); // get one card from db
            log_message('debug','archivo: card_id is :'.$data['card']['card_id']);
            $data['card']['photos'] = $this->card_model->get_card_photos($data['card']['card_id']); 
            $data['card']['comments'] = $this->card_model->get_card_comments($data['card']['card_id']); 
            $data['card']['history'] = $this->card_model->get_card_history($data['card']['card_id']); 
            header('Content-Type: application/json');
            echo json_encode(array('item' => $data['card']));
        }    

	public function login($user = NULL) {

		$user['username'] = $this->input->post('username');
		$user['password'] = $this->input->post('password');

		log_message('debug','username: '.$this->input->post('username')); 
		log_message('debug','password: '.$this->input->post('password'));

		$data['success'] = $this->card_model->valida_login($user);

		header('Content-Type: application/json');
		echo json_encode(array('success' => $data['success']));
	}

	public function login_ANTIGUO_2($user = NULL) {

		$rawData = file_get_contents("php://input"); // this is the current approach to get post parameters 
		$user = json_decode($rawData,true);

		log_message('debug','username: '.$user['username']); 
		log_message('debug','password: '.$user['password']);

		$data['success'] = $this->card_model->valida_login($user);     

		header('Content-Type: application/json');
		echo json_encode(array('success' => $data['success']));
	}

	public function login_ANTIGUO_1($user = NULL) {

		$user['username'] = $this->input->get('username');
		$user['password'] = $this->input->get('password');
		$data['success'] = $this->card_model->valida_login_ANTIGUO_1($user);     
		header('Content-Type: application/json');
		echo json_encode(array('success' => $data['success']));
	}

    public function save($card_id = NULL) {
        //$card = $this->input->post('archive_id');     // this is not working
        $rawJson = file_get_contents("php://input");
        $card = json_decode($rawJson,true);
        $data['success'] = $this->card_model->save_card($card);     
        $card_id = intval($card['card_id']);
        $data['card'] = $this->card_model->get_card($card_id); 
        header('Content-Type: application/json');
        echo json_encode(array('item' => $data['card'],'success' => $data['success']));
    }

    public function new_comment($comment = NULL) {

		$comment['card_id'] = $this->input->post('card_id');
		$card_id = intval($comment['card_id']);

		log_message('debug','card_id: '.$comment['card_id']); 

		if ($card_id != NULL) {
			$comment['comment'] = $this->input->post('comment');
			$comment['create_user'] = $this->input->post('create_user');

			$data['success'] = $this->card_model->insert_comment($comment);
			$data['card'] = $this->card_model->get_card($card_id);
			$data['card']['photos'] = $this->card_model->get_card_photos($data['card']['card_number']); 
			$data['card']['comments'] = $this->card_model->get_card_comments($data['card']['card_id']); 
			$data['card']['history'] = $this->card_model->get_card_history($data['card']['card_id']); 

			header('Content-Type: application/json');
			echo json_encode(array('item' => $data['card'],'success' => $data['success']));
		}
	}

    public function delete_comment($comment = NULL) {

		$comment['card_comment_id'] = $this->input->post('card_comment_id');
		$card_comment_id = intval($comment['card_comment_id']);

		log_message('debug','card_comment_id: '.$comment['card_comment_id']); 

		if ($card_comment_id != NULL) {
			$card_id = $this->card_model->get_card_id_from_comment($comment);
			$data['success'] = $this->card_model->delete_comment($comment);
			$data['card'] = $this->card_model->get_card($card_id);
			$data['card']['photos'] = $this->card_model->get_card_photos($data['card']['card_id']); 
			$data['card']['comments'] = $this->card_model->get_card_comments($data['card']['card_id']); 
			$data['card']['history'] = $this->card_model->get_card_history($data['card']['card_id']); 

			header('Content-Type: application/json');
			echo json_encode(array('item' => $data['card'],'success' => $data['success']));
		}
	}

       public function unlink($card_id = NULL, $list_image_id = NULL) {
            
	       	$card_id = $this->input->get('cardId');
	       	$list_image_id = $this->input->get('listImageId');
	        log_message('debug','archivo: unlink:[$card_id:'.$card_id.'][$list_image_id:'.$list_image_id.']');
	        
	        $array = json_decode($list_image_id, true);
	        
	        //$data['success'] = $this->card_model->unlink_photo($image_id);
	        //$data['card'] = $this->card_model->get_card($card_id);
	        //$data['card']['photos'] = $this->card_model->get_card_photos($data['card']['card_id']);
	        
	        $data['success'] = $this->card_model->unlink_photo_array($array);
	        $data['photos'] = $this->card_model->get_card_photos($card_id);
	        	    
	        header('Content-Type: application/json');
	        echo json_encode(array('photos' => $data['photos'], 'success' => $data['success']));            
        }   

        public function link($card_id = NULL, $card_number = NULL, $list_image_id = NULL) {
        	
        	$card_id = $this->input->get('cardId');
        	$card_number = $this->input->get('cardNumber');
        	$list_image_id = $this->input->get('listImageId');
        	log_message('debug','archivo: link:[$card_id:'.$card_id.'][$list_image_id:'.$list_image_id.']');
        	
        	$array = json_decode($list_image_id, true);
            //listImageId  =  {"0":"walter","1":"alejos"}
        	//$array  =  ["walter","alejos"]
        	
        	//$data['success'] = $this->card_model->link_photo($image_id, $card_number, $card_id);
        	//$data['card'] = $this->card_model->get_card($card_id);
        	//$data['card']['photos'] = $this->card_model->get_card_photos($data['card']['card_id']);
        	
        	$data['success'] = $this->card_model->link_photo_array($array, $card_number, $card_id);
        	$data['photos'] = $this->card_model->get_card_photos($card_id);
        	
        	header('Content-Type: application/json');
        	echo json_encode(array('photos' => $data['photos'], 'success' => $data['success']));
        }

}
?>
