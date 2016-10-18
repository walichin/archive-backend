<?php
class Photo_model extends CI_Model {

    public function __construct() {
		$this->load->database();        
    }

    public function get_num_photos() {
        $query = $this->db->get('adm_image_mt');
        return $query->num_rows(); 
    }

	public function get_photos($params = NULL) {

        if (isset($params['textToSearch'])) {
            log_message('debug','archivo: $params.textToSearch OK:'.$params['textToSearch']);
        } else {
            log_message('debug','archivo: $params.textToSearch KO setting to NULL');
            $params['textToSearch'] = NULL;
        }

        $params['limit'] = 10;
        $params['offset'] = 0;

        $this->db->order_by('image_id','asc');
        $this->db->limit($params['limit'], $params['offset']);
        $this->db->like('original_name', $params['textToSearch']);
        $this->db->where('card_id', NULL);
        
        $query = $this->db->get('adm_image_mt');
        //$query = $this->db->query('select ');
        return $query->result_array();
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
	
	public function save_photo($photo) {
	
		if (is_null($photo)) {
			return false;
		}
		$data = array(
				'is_principal' => $photo['is_principal'],
				'is_link_valid' => $photo['is_link_valid'],
				'is_image_valid' => $photo['is_image_valid']
		);
		$this->db->where('image_id',$photo['image_id']);
		$this->db->update('adm_image_mt',$data);
		return true;
	
	}
		
}
?>