<?php
class Reference_model extends CI_Model {

    public function __construct() {
		$this->load->database();        
    }

    public function get_photo_types() {
        $query = $this->db->get('adm_photo_type_mz');
        return $query->result_array();
    }

    public function get_primary_topics() {
        $query = $this->db->get('adm_primary_topic_mz');
        return $query->result_array();
    }    
    
    public function get_secondary_topics() {
        $query = $this->db->get('adm_secundary_topic_mz');
        return $query->result_array();
    }  

    public function get_negative_types() {
        $query = $this->db->get('adm_negative_type_mz');
        return $query->result_array();
    }  

    public function get_categories() {
        $query = $this->db->get('adm_category_mz');
        return $query->result_array();
    } 

    public function get_observations() {
        $query = $this->db->get('adm_observation_mz');
        return $query->result_array();
    } 

    public function get_formats() {
        $query = $this->db->get('adm_format_mz');
        return $query->result_array();
    } 

    public function get_processes() {
        $query = $this->db->get('adm_process_mz');
        return $query->result_array();
    } 

    //adm_format_mz

}
?>