<?php
class Negative_model extends CI_Model {

    public function __construct() {
		$this->load->database();
    }
    
    public function get_num_negatives_wk($params = NULL) {
    
    	if (!isset($params['negative_id_search'])) {
    		$params['negative_id_search'] = "";
    	}
    	if (!isset($params['filename_search'])) {
    		$params['filename_search'] = "";
    	}
        if (!isset($params['box_search'])) {
    		$params['box_search'] = "";
    	}
    	if (!isset($params['section_search'])) {
    		$params['section_search'] = "";
    	}
    	if (!isset($params['location_search'])) {
    		$params['location_search'] = "";
    	}
    	if (!isset($params['imgnro_search'])) {
    		$params['imgnro_search'] = "";
    	}
    	 
    	if (strlen($params['negative_id_search']) > 0) {
    		$this->db->like('negative_id', $params['negative_id_search']);
    	}
    	if (strlen($params['filename_search']) > 0) {
    		$this->db->like('img_name', $params['filename_search']);
    	}
        if (strlen($params['box_search']) > 0) {
    		$this->db->like('box', $params['box_search']);
    	}
    	if (strlen($params['section_search']) > 0) {
    		$this->db->like('section', $params['section_search']);
    	}
    	if (strlen($params['location_search']) > 0) {
    		$this->db->like('location', $params['location_search']);
    	}
    	if (strlen($params['imgnro_search']) > 0) {
    		$this->db->like('img_imgnro', $params['imgnro_search']);
    	}
    	 
    	$query = $this->db->get('adm_negative_wk');
    	return $query->num_rows();
    }
    
    public function get_negatives_wk($params = NULL) {
    
    	$total_count = $params['total_count'];
    
    	$full_search = false;
    	if (isset($params['full_search']) && $params['full_search'] == 'true') {
    		$full_search = true;
    	}
    	if (!isset($params['limit'])) {
    		$params['limit'] = 10;
    	}
    	if (!isset($params['offset'])) {
    		$params['offset'] = 0;
    	}
    	if (!isset($params['negative_id_search'])) {
    		$params['negative_id_search'] = "";
    	}
    	if (!isset($params['filename_search'])) {
    		$params['filename_search'] = "";
    	}
        if (!isset($params['box_search'])) {
    		$params['box_search'] = "";
    	}
    	if (!isset($params['section_search'])) {
    		$params['section_search'] = "";
    	}
    	if (!isset($params['location_search'])) {
    		$params['location_search'] = "";
    	}
    	if (!isset($params['imgnro_search'])) {
    		$params['imgnro_search'] = "";
    	}
    
    	log_message('debug','archivo: offset:'.$params['offset']);
    	log_message('debug','archivo: limit:'.$params['limit']);
    	log_message('debug','archivo: negative_id_search:'.$params['negative_id_search']);
    	log_message('debug','archivo: filename_search:'.$params['filename_search']);
    	log_message('debug','archivo: box_search:'.$params['box_search']);
    	log_message('debug','archivo: section_search:'.$params['section_search']);
    	log_message('debug','archivo: location_search:'.$params['location_search']);
    	log_message('debug','archivo: imgnro_search:'.$params['imgnro_search']);
    
    	/*** Main Query ***/
    	if (!$full_search) {
    		$this->db->limit($params['limit'], $params['offset']);
    	}
    	if (strlen($params['negative_id_search']) > 0) {
    		$this->db->like('negative_id', $params['negative_id_search']);
    	}
    	if (strlen($params['filename_search']) > 0) {
    		$this->db->like('img_name', $params['filename_search']);
    	}
    	if (strlen($params['box_search']) > 0) {
    		$this->db->like('box', $params['box_search']);
    	}
    	if (strlen($params['section_search']) > 0) {
    		$this->db->like('section', $params['section_search']);
    	}
    	if (strlen($params['location_search']) > 0) {
    		$this->db->like('location', $params['location_search']);
    	}
    	if (strlen($params['imgnro_search']) > 0) {
    		$this->db->like('img_imgnro', $params['imgnro_search']);
    	}
    	 
    	if ($full_search) {
    		$this->db->select('negative_id');
    	}
    	$this->db->order_by('negative_id', 'asc');
    	$query = $this->db->get('adm_negative_wk');
    	$array = $query->result_array();
    
    	//$dbgquery = $this->db->last_query();
    	//log_message('debug', 'archivo: query:'.$dbgquery);
    
    	$count = count($array);
    
    	if (!$full_search) {
    		 
    		/*** Calculating offset for Previous page ***/
    		if ((int)$params['offset'] > 0) {
    			//existe pagina anterior
    			$offset1 = (int)$params['offset'] - (int)$params['limit'];
    		} else {
    			//la pagina anterior de la primera pagina sera la ultima pagina
    			$offset1 = ((int)($total_count / (int)$params['limit'])) * (int)$params['limit'];
    			if ($offset1 == $total_count) {
    				$offset1 = $offset1 - (int)$params['limit'];
    			}
    		}
    
    		/*** Calculating offset for Next page ***/
    		if ($total_count <= ((int)$params['limit'] + (int)$params['offset'])) {
    			//la pagina siguiente de la ultima pagina sera la primera pagina
    			$offset2 = 0;
    		} else {
    			//existe pagina siguiente
    			$offset2 = (int)$params['limit'] + (int)$params['offset'];
    		}
    	}
    
    	/*** Query to get Previous page ***/
    	$count1 = 0;
    
    	if (!$full_search) {
    		$this->db->limit($params['limit'], $offset1);
    	}
        if (strlen($params['negative_id_search']) > 0) {
    		$this->db->like('negative_id', $params['negative_id_search']);
    	}
    	if (strlen($params['filename_search']) > 0) {
    		$this->db->like('img_name', $params['filename_search']);
    	}
    	if (strlen($params['box_search']) > 0) {
    		$this->db->like('box', $params['box_search']);
    	}
    	if (strlen($params['section_search']) > 0) {
    		$this->db->like('section', $params['section_search']);
    	}
    	if (strlen($params['location_search']) > 0) {
    		$this->db->like('location', $params['location_search']);
    	}
    	if (strlen($params['imgnro_search']) > 0) {
    		$this->db->like('img_imgnro', $params['imgnro_search']);
    	}
    	
    	if ($full_search) {
    		$this->db->select('negative_id');
    	}
    	$this->db->order_by('negative_id', 'asc');
    	$query1 = $this->db->get('adm_negative_wk');
    	$array1 = $query1->result_array();
    
    	//$dbgquery = $this->db->last_query();
    	//log_message('debug', 'archivo: query1:'.$dbgquery);
    
    	$count1 = count($array1);
    
    	/*** Query to get Next page ***/
    	$count2 = 0;
    
    	if (!$full_search) {
    		$this->db->limit($params['limit'], $offset2);
    	}
        if (strlen($params['negative_id_search']) > 0) {
    		$this->db->like('negative_id', $params['negative_id_search']);
    	}
    	if (strlen($params['filename_search']) > 0) {
    		$this->db->like('img_name', $params['filename_search']);
    	}
    	if (strlen($params['box_search']) > 0) {
    		$this->db->like('box', $params['box_search']);
    	}
    	if (strlen($params['section_search']) > 0) {
    		$this->db->like('section', $params['section_search']);
    	}
    	if (strlen($params['location_search']) > 0) {
    		$this->db->like('location', $params['location_search']);
    	}
    	if (strlen($params['imgnro_search']) > 0) {
    		$this->db->like('img_imgnro', $params['imgnro_search']);
    	}
    	
    	if ($full_search) {
    		$this->db->select('negative_id');
    	}
    	$this->db->order_by('negative_id', 'asc');
    	$query2 = $this->db->get('adm_negative_wk');
    	$array2 = $query2->result_array();
    
    	//$dbgquery = $this->db->last_query();
    	//log_message('debug', 'archivo: query2:'.$dbgquery);
    
    	$count2 = count($array2);
    
    	log_message('debug', 'archivo: count:'.$count);
    	log_message('debug', 'archivo: count1:'.$count1);
    	log_message('debug', 'archivo: count2:'.$count2);
    
    	$i = 0;
    	while($i < $count) {
    		log_message('debug', 'archivo: current negative_id:'.$array[$i]['negative_id']);
    
    		if ($i > 0) {
    			$array[$i]['previous_negative_id'] = $array[$i-1]['negative_id'];
    		} else {
    			$array[$i]['previous_negative_id'] = $array1[$count1-1]['negative_id'];
    		}
    
    		if ($i < ($count - 1)) {
    			$array[$i]['next_negative_id'] = $array[$i+1]['negative_id'];
    		} else {
    			$array[$i]['next_negative_id'] = $array2[0]['negative_id'];
    		}
    
    		if (isset($array[$i]['previous_negative_id'])) {
    			log_message('debug', 'archivo: previous_negative_id '.$array[$i]['previous_negative_id']);
    		}
    		if (isset($array[$i]['next_negative_id'])) {
    			log_message('debug', 'archivo: next_negative_id: '.$array[$i]['next_negative_id']);
    		}
    
    		$i++;
    	}
    
    	return $array;
    }
    
    public function get_negative_wk($negative_id = null) {
    	log_message('debug','archivo: get_negative_wk: '.$negative_id);
    	$query = $this->db->get_where('adm_negative_wk', array('negative_id' => $negative_id));
    	return $query->row_array();
    }
    
    public function get_negative_cards_wk($negative_id = null) {
    	log_message('debug','archivo: get_negative_cards_wk: '.$negative_id);
    	$query = $this->db->get_where('adm_card_wk', array('negative_id' => $negative_id));
    	return $query->result_array();
    }
    
    public function insert_negative_wk($negative) {
    
    	if (is_null($negative)) {
    		return 0;
    	}
    	
    	$data = array(
    			'box' => $negative['box'],
    			'section' => $negative['section'],
    			'location' => $negative['location'],
    			'is_restored' => $negative['is_restored'],
    			'height' => $negative['height'],
    			'width' => $negative['width'],
    			'thickness' => $negative['thickness'],
    			'img_path' => $negative['img_path'],
    			'img_imgnro' => $negative['img_imgnro'],
    			'img_server' => $negative['img_server'],
    			'create_user' => $negative['create_user'],
    			'img_name' => $negative['img_name']
    	);
    
    	$this->db->set('create_date', 'NOW()', FALSE);
    	$this->db->insert('adm_negative_wk', $data);
    	return $this->db->insert_id();
    
    }
    
    public function insert_card_wk($card) {
    
    	if (is_null($card)) {
    		return 0;
    	}
    	
    	$data = array(
    			'negative_id' => $card['negative_id'],
    			'archive_id' => $card['archive_id'],
    			'card_number' => $card['card_number'],
    			'title' => $card['title'],
    			'description' => $card['description'],
    			'observation' => $card['observation'],
    			'create_user' => $card['create_user']
    	);
    
    	$this->db->set('create_date', 'NOW()', FALSE);
    	$this->db->insert('adm_card_wk', $data);
    	return $this->db->insert_id();
    
    }
   
}
?>