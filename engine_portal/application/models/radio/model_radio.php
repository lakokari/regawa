<?php

class Model_radio extends My_Model {
    protected $_table_name = 'radio_items';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = 'id';
    
    function getRadioList_all(){
        $query = $this->db->query("SELECT * FROM uz_radio_items ORDER BY display_order, radio_name");
        return $query->result();
    }
    
    function getRadioList_partner(){
        $query = $this->db->query("SELECT * FROM uz_radio_items where partner = 'Y' ORDER BY radio_name");
        return $query->result();
    }
    
    function getRadioList_filter($tipe){
        $query = $this->db->query("SELECT * FROM uz_radio_items where radio_source = '".$tipe."' ORDER BY radio_name");
        return $query->result();
    }
    
    function get_sod_category(){
        $query = $this->db->get('uz_radio_sod_category');
        return $query->result();
    }
    
    function get_sod_subcategory($idCategory){
        $query = $this->db->query("SELECT * FROM uz_radio_sod_subcategory WHERE id_category = '$idCategory' order by id");
        return $query;
    }
            
    function getSod($id){
        $query = $this->db->query("SELECT * FROM uz_radio_sod_subcategory where id = '".$id."'");
        return $query->result();
    }
    
    function getNameCategory($id){
        $query = $this->db->query("SELECT * FROM uz_radio_sod_category where id = '".$id."'");
        return $query->result();
    }
    
    function getListRadioDataRequest(){
        $query = $this->db->query("select * from uz_radio_items where radio_site != '' order by radio_name");
        return $query->result();
    }
    
    function getUrlApiRadioDataRequest($id){
        $query = $this->db->query("select radio_site from uz_radio_items where id != '$id' ");
        return $query->result();
    }
}
?>
