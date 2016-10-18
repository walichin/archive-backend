<?php
class Card_model extends CI_Model {

    public function __construct() {
		$this->load->database();        
    }

    public function get_num_cards($params = NULL) {
        
    	if (!isset($params['title_search'])) {
    		$params['title_search'] = "";
    	}
    	if (!isset($params['description_search'])) {
    		$params['description_search'] = "";
    	}
    	if (!isset($params['card_id_search'])) {
    		$params['card_id_search'] = "";
    	}
    	if (!isset($params['card_number_search'])) {
    		$params['card_number_search'] = "";
    	}
    	
    	if (strlen($params['title_search']) > 0) {
    		$this->db->like('title', $params['title_search']);
    	}
    	if (strlen($params['description_search']) > 0) {
    		$this->db->like('description', $params['description_search']);
    	}
    	if (strlen($params['card_id_search']) > 0) {
    		$this->db->like('card_id', $params['card_id_search']);
    	}
    	if (strlen($params['card_number_search']) > 0) {
    		$this->db->like('card_number', $params['card_number_search']);
    	}
    	
    	$query = $this->db->get('adm_card_mt');
        return $query->num_rows(); 
    }

	public function get_cards($params = NULL) {

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
        if (!isset($params['title_search'])) {
        	$params['title_search'] = "";
        }
        if (!isset($params['description_search'])) {
        	$params['description_search'] = "";
        }
        if (!isset($params['card_id_search'])) {
        	$params['card_id_search'] = "";
        }
        if (!isset($params['card_number_search'])) {
        	$params['card_number_search'] = "";
        }
        
        log_message('debug','archivo:offset:'.$params['offset']);
        log_message('debug','archivo:limit:'.$params['limit']);
        log_message('debug','archivo:title_search:'.$params['title_search']);
        log_message('debug','archivo:description_search:'.$params['description_search']);
        log_message('debug','archivo:card_id_search:'.$params['card_id_search']);
        log_message('debug','archivo:card_number_search:'.$params['card_number_search']);
        
        /*** Main Query ***/
        if (!$full_search) {
        	$this->db->limit($params['limit'], $params['offset']);
        }
        if (strlen($params['title_search']) > 0) {
        	$this->db->like('title', $params['title_search']);
        }
        if (strlen($params['description_search']) > 0) {
        	$this->db->like('description', $params['description_search']);        
        }
        if (strlen($params['card_id_search']) > 0) {
        	$this->db->like('card_id', $params['card_id_search']);
        }
        if (strlen($params['card_number_search']) > 0) {
        	$this->db->like('card_number', $params['card_number_search']);
        }
        
        if ($full_search) {
        	$this->db->select('card_id');
        }
        $this->db->order_by('card_id', 'asc');
        $query = $this->db->get('adm_card_mt');
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
       	if (strlen($params['title_search']) > 0) {
       		$this->db->like('title', $params['title_search']);
       	}
       	if (strlen($params['description_search']) > 0) {
       		$this->db->like('description', $params['description_search']);
       	}
       	if (strlen($params['card_id_search']) > 0) {
       		$this->db->like('card_id', $params['card_id_search']);
       	}
       	if (strlen($params['card_number_search']) > 0) {
       		$this->db->like('card_number', $params['card_number_search']);
       	}
        	
       	if ($full_search) {
       		$this->db->select('card_id');
       	}
       	$this->db->order_by('card_id', 'asc');
       	$query1 = $this->db->get('adm_card_mt');
        $array1 = $query1->result_array();

        //$dbgquery = $this->db->last_query();
        //log_message('debug', 'archivo: query1:'.$dbgquery);
            
        $count1 = count($array1);

        /*** Query to get Next page ***/
        $count2 = 0;

        if (!$full_search) {
        	$this->db->limit($params['limit'], $offset2);
        }
        if (strlen($params['title_search']) > 0) {
        	$this->db->like('title', $params['title_search']);
        }
        if (strlen($params['description_search']) > 0) {
        	$this->db->like('description', $params['description_search']);
        }
        if (strlen($params['card_id_search']) > 0) {
        	$this->db->like('card_id', $params['card_id_search']);
        }
        if (strlen($params['card_number_search']) > 0) {
        	$this->db->like('card_number', $params['card_number_search']);
        }
        
        if ($full_search) {
        	$this->db->select('card_id');
        }
        $this->db->order_by('card_id', 'asc');
        $query2 = $this->db->get('adm_card_mt');
        $array2 = $query2->result_array();

        //$dbgquery = $this->db->last_query();
        //log_message('debug', 'archivo: query2:'.$dbgquery); 

        $count2 = count($array2);

        log_message('debug', 'archivo: count:'.$count); 
        log_message('debug', 'archivo: count1:'.$count1); 
        log_message('debug', 'archivo: count2:'.$count2); 

        $i = 0;
        while($i < $count) {            
            log_message('debug', 'archivo: current card_id:'.$array[$i]['card_id']);

            if ($i > 0) {
            	$array[$i]['previous_card_id'] = $array[$i-1]['card_id'];
            } else {
            	$array[$i]['previous_card_id'] = $array1[$count1-1]['card_id'];
            }
            
            if ($i < ($count - 1)) {
            	$array[$i]['next_card_id'] = $array[$i+1]['card_id'];
            } else {
            	$array[$i]['next_card_id'] = $array2[0]['card_id'];
            }
            
            if (isset($array[$i]['previous_card_id'])) {
                log_message('debug', 'archivo: previous_card_id '.$array[$i]['previous_card_id']);      
            }
            if (isset($array[$i]['next_card_id'])) {
                log_message('debug', 'archivo: next_card_id: '.$array[$i]['next_card_id']);      
            }
            
            $i++;
        }

        return $array;
	}

    public function valida_login($user) {

	// return 0 : login successfully
	// return 1 : username or password empty
	// return 2 : username not registered
	// return 3 : password incorrect

	$result = array();

        if (is_null($user)) {
		$result['code'] = 1;
		$result['desc'] = 'username or password empty-1';
		return $result;
        }

	if (!array_key_exists('username', $user) || !array_key_exists('password', $user)) {
		log_message('debug','username or password index does not exist');
		$result['code'] = 1;
		$result['desc'] = 'username or password empty-2';
		return $result;
	}

        if (is_null($user['username']) || is_null($user['password'])) {
		$result['code'] = 1;
		$result['desc'] = 'username or password empty-3';
		return $result;
        }

        if ($user['username'] === '' || $user['password'] === '') {
		$result['code'] = 1;
		$result['desc'] = 'username or password empty-4';
		return $result;
        }

	$this->db->select('password');
	$this->db->from('adm_user_mt');
	$this->db->where('login',$user['username']);
	$query = $this->db->get();

	if ($query->num_rows() === 0) {
		$result['code'] = 2;
		$result['desc'] = 'username not registered';
		return $result;
	}

	$row = $query->row_array();
	//$array = $query->result_array();

	if ($row['password'] === $user['password']) {
		$result['code'] = 0;
		$result['desc'] = 'login successfully';
		return $result;
	} else {
		$result['code'] = 3;
		$result['desc'] = 'password incorrect';
		return $result;
	}
    }    

    public function valida_login_ANTIGUO_1($user) {

	// return 0 : login successfully
	// return 1 : username or password empty
	// return 2 : username not registered
	// return 3 : password incorrect

        if (is_null($user)) {
		return 1;
        }

        if (is_null($user['username']) || is_null($user['password'])) {
		return 1;
        }

	$this->db->select('password');
	$this->db->from('adm_user_mt');
	$this->db->where('login',$user['username']);
	$query = $this->db->get();

	if ($query->num_rows() === 0) {
		return 2;
	}

	$row = $query->row_array();
	//$array = $query->result_array();

	if ($row['password'] === $user['password']) {
		return 0;
	} else {
		return 3;
	}
    }    

    public function save_card($card) {

        if (is_null($card)) {
            return false;
        }
        $data = array(
            'title' => $card['title']
        );
        $this->db->where('card_id',$card['card_id']);
        $this->db->update('adm_card_mt',$data);
        return true;

    }    

    public function insert_comment($comment) {

        if (is_null($comment)) {
            return false;
        }

		$data = array(
			'card_id' => $comment['card_id'],
			'comment' => $comment['comment'],
			'create_user' => $comment['create_user']
		);

		$this->db->set('create_date', 'NOW()', FALSE);
		$this->db->insert('adm_card_comment_mt', $data);
        return true;

    }    

    public function delete_comment($comment) {

        if (is_null($comment)) {
            return false;
        }

        $this->db->where('card_comment_id',$comment['card_comment_id']);
        $this->db->delete('adm_card_comment_mt');
        return true;

    }

    public function get_card_id_from_comment($comment) {

        if (is_null($comment)) {
            return NULL;
        }

		$this->db->select('card_id');
		$this->db->from('adm_card_comment_mt');
		$this->db->where('card_comment_id',$comment['card_comment_id']);
		$query = $this->db->get();

		if ($query->num_rows() === 0) {
			return NULL;
		}

		$row = $query->row_array();
		return $row['card_id'];

    }

    public function link_photo($image_id = NULL, $card_number = NULL, $card_id = NULL) {
    
    	if (is_null($image_id) || is_null($card_number)) {
    		return false;
    	}
    	$data = array(
    		'imgnro' => $card_number,
    		'card_id' => $card_id,
    		'is_principal' => '0',
    		'is_link_valid' => '1'
    	);
    	$this->db->where('image_id',$image_id);
    	$this->db->update('adm_image_mt',$data);
    	return true;
    
    }
    
    public function link_photo_array($list_image_id = [], $card_number = NULL, $card_id = NULL) {

    	if ($list_image_id === [] || is_null($card_number) || is_null($card_id)) {
            return false;
        }
        
        $count = count($list_image_id);
        log_message('debug', 'archivo: link_photo_array:'.$count);
        $i = 0;
        
        while($i < $count) {
        	$data = array(
        		'imgnro' => $card_number,
        		'card_id' => $card_id,
	    		'is_principal' => '0',
	    		'is_link_valid' => '1'
        	);
        	$this->db->where('image_id',$list_image_id[$i]);
        	$this->db->update('adm_image_mt',$data);
        	$i++;
        }

        return true;
        
    }    

    public function unlink_photo($image_id = NULL) {
    
    	if (is_null($image_id)) {
    		return false;
    	}
    	$data = array(
    		'imgnro' => NULL,
    		'card_id' => NULL,
    		'is_principal' => '0',
    		'is_link_valid' => '0'
    		//'is_image_valid' => '0' //la calidad del escaneado no depende de la ficha
    	);
    	$this->db->where('image_id',$image_id);
    	$this->db->update('adm_image_mt',$data);
    	return true;
    
    }
    
    public function unlink_photo_array($list_image_id = []) {
    
    	if ($list_image_id === []) {
    		return false;
    	}
    
    	$count = count($list_image_id);
    	log_message('debug', 'archivo: unlink_photo_array:'.$count);
    	$i = 0;
    
    	while($i < $count) {
    		$data = array(
    			'imgnro' => NULL,
    			'card_id' => NULL,
    			'is_principal' => '0',
    			'is_link_valid' => '0'
    			//'is_image_valid' => '0' //la calidad del escaneado no depende de la ficha
    		);
    		$this->db->where('image_id',$list_image_id[$i]);
    		$this->db->update('adm_image_mt',$data);
    		$i++;
    	}
    
    	return true;
    
    }
    
    public function get_card_photos($card_id = FALSE) {

        log_message('debug','archivo:get_card_photos called with param: '.$card_id);
        $query = $this->db->get_where('adm_image_mt', array('card_id' => $card_id));
        $photos = array();
        foreach ($query->result_array() as $row){
            $path = $row['path'];
	        //$serverPath = 'https://dc01978c55ee7bd917d63d6076827abc1ebc7cca-www.googledrive.com/host/0B0kjQxFxOJIVN0tTYUN4dUg5dE0/';
            $serverPath = $row['server'];
            log_message('debug','archivo:get_card_photos path: '.$path);
            $path = str_replace('fotos/', $serverPath, $path);
            $row['path'] = $path;
            array_push($photos, $row);
        }
        return $photos;

    }

    public function get_card_comments($card_id = FALSE) {
        log_message('debug','archivo:get_card_comments called with param: '.$card_id);
        $query = $this->db->get_where('adm_card_comment_mt', array('card_id' => $card_id));
        return $query->result_array();
    }

    public function get_card_history($card_id = FALSE) {
        log_message('debug','archivo:get_card_history called with param: '.$card_id);
        $query = $this->db->get_where('adm_card_history_mt', array('card_id' => $card_id));
        return $query->result_array();
    }

    public function get_card($card_id = FALSE) {
        
        $query = $this->db->get_where('adm_card_mt', array('card_id' => $card_id));
        $row = $query->row_array();
        
        // Process
        $query0 = $this->db->get_where('adm_photo_type_mz', array('photo_type_id' => $row['photo_type_id']));
        $row0 = $query0->row_array();
        $row['photo_type'] = $row0['description'];

        // Topic - Primary
        $query1 = $this->db->query('SELECT a.primary_topic_id, a.description FROM adm_primary_topic_mz a, adm_card_primary_topic_ml t WHERE t.archive_id = 1 AND t.card_id = '.$card_id.' AND t.primary_topic_id =  a.primary_topic_id ORDER BY a.description;');
        $row1 = $query1->result_array();
        $row['primary_topics'] = $row1;

        // Topic - Secundary
        $query2 = $this->db->query('SELECT a.secundary_topic_id, a.description FROM adm_secundary_topic_mz a, adm_card_secondary_topic_ml t WHERE t.archive_id = 1 AND t.card_id = '.$card_id.' AND t.secundary_topic_id =  a.secundary_topic_id ORDER BY a.description;');
        $row2 = $query2->result_array();
        $row['secondary_topics'] = $row2;

        // Negative Type
        if ($row['negative_type_id'] === '1') {
            $row['negative_type'] = 'Glass';
            $row['negative_type_code'] = 'NV';
        }
        if ($row['negative_type_id'] === '2') {
            $row['negative_type'] = 'Flexible';
            $row['negative_type_code'] = 'NF';
        }

        // Category
        $query3 = $this->db->get_where('adm_category_mz', array('category_id' => $row['category_id']));
        $row3 = $query3->row_array();
        $row['category'] = $row3['description'];

        // Observations
        $query4 = $this->db->query('SELECT o.observation_id, o.description FROM adm_observation_mz o, adm_card_observation_ml c WHERE c.archive_id = 1 AND c.card_id = '.$card_id.' AND c.observation_id =  o.observation_id AND o.observation_id > 0 ORDER BY o.description;');
        $row4 = $query4->result_array();
        $row['observations'] = $row4;

        // Format
        $query4 = $this->db->get_where('adm_format_mz', array('format_id' => $row['format_id']));
        $row4 = $query4->row_array();
        $row['format'] = $row4['description'];

        // Process
        $query5 = $this->db->get_where('adm_process_mz', array('process_id' => $row['process_id']));
        $row5 = $query5->row_array();
        $row['process'] = $row5['description'];

        // Film Support
        $filmBase = array();
        if ($row['negative_flexible'] === 'Y') { array_push($filmBase, "Flexible"); };
        if ($row['negative_nitrato'] === 'Y') { array_push($filmBase, "Nitrate"); };
        if ($row['negative_poliester'] === 'Y') { array_push($filmBase, "Polyester"); };
        if ($row['negative_vidrio'] === 'Y') { array_push($filmBase, "Glass"); };
        if ($row['negative_acetato'] === 'Y') { array_push($filmBase, "Acetate"); };
        $row['supports'] = $filmBase;

        // Film Condition
        $filmCondition = array();
        if ($row['condition_abrasion'] != '') { array_push($filmCondition, 'Abrasion ['.$row['condition_abrasion'].']'); };
        if ($row['condition_amarillento'] != '') { array_push($filmCondition, 'Amarillento ['.$row['condition_amarillento'].']'); };
        if ($row['condition_desvanecimiento'] != '') { array_push($filmCondition, 'Desvanecimiento ['.$row['condition_desvanecimiento'].']'); };
        if ($row['condition_espejo_plata'] != '') { array_push($filmCondition, 'Espejo Plata ['.$row['condition_espejo_plata'].']'); };
        if ($row['condition_hongos'] != '') { array_push($filmCondition, 'Hongos ['.$row['condition_hongos'].']'); };
        if ($row['condition_lagunas'] != '') { array_push($filmCondition, 'Lagunas ['.$row['condition_lagunas'].']'); };
        if ($row['condition_rayadura'] != '') { array_push($filmCondition, 'Rayadura ['.$row['condition_rayadura'].']'); };
        if ($row['condition_rotura'] != '') { array_push($filmCondition, 'Rotura ['.$row['condition_rotura'].']'); };
        if ($row['condition_additional'] != '') { array_push($filmCondition, $row['condition_additional_description'].' ['.$row['condition_additional'].']'); };
        $row['conditions'] = $filmCondition;

         // # Position
        if ($row['card_position_in_negative'] === 'N') { $row['card_position_in_negative'] = '&#8593;'; };
        if ($row['card_position_in_negative'] === 'E') { $row['card_position_in_negative'] = '&#8594;'; };
        if ($row['card_position_in_negative'] === 'S') { $row['card_position_in_negative'] = '&#8595;'; };
        if ($row['card_position_in_negative'] === 'W') { $row['card_position_in_negative'] = '&#8592;'; };

        return $row;
    }

}
?>
