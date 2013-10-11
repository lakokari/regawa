<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wow
 *
 * @author Regawa
 */
class Wow extends Tapi {

    protected $_req_auth = FALSE;
    protected $_log_requests = FALSE;

    public function getlist($event_id = NULL) {
        $this->return['success'] = TRUE;
        //$this->return['retCode'] = 'E0000';
        //$this->return['retCodeMessage'] = $this->ERR_CODE['E0000'];

        $offset = intval($this->input->get('offset', TRUE));
        if (!$offset)
            $offset = 0;
        $limit = intval($this->input->get('limit', TRUE));
        if (!$limit)
            $limit = 10;

        $this->return['offset'] = $offset;
        $this->return['limit'] = $limit;

        $items = array();
        $total_size = 0;

        //get total size
        $sql = 'SELECT COUNT(*) as total_records FROM uz_wow_items WHERE (approved=1) AND (transcoded=1)';
        if ($event_id) {
            $sql .= ' AND (event_id=' . $event_id . ')';
        }
        $check = $this->db->query($sql)->row();

        if ($check) {
            $total_size = $check->total_records;
        }



        if ($total_size > 0) {

            $sql = 'SELECT wi.id, wi.item_name as title, wi.item_description as description, 
                    wi.item_url as movie_url, wi.item_thumbnail as thumbnail_url, wi.item_like_count as like_count, 
                    wi.view_count, wi.author, wi.event_id, we.name as event_name, wi.genre as genre_id, 
                    wg.name as genre_name,  wi.upload_date, usr.name as name, wi.nominee, wi.wowticket
                    FROM uz_wow_items as wi, uz_users as usr, uz_wow_genre as wg, uz_wow_event as we
                    WHERE (wi.created_by=usr.id) AND (wi.genre=wg.id) AND (wi.event_id=we.id) 
                    AND (approved=1) AND (transcoded=1)';
            if ($event_id) {
                $sql .= ' AND (wi.event_id=' . $event_id . ')';
            }
            $sql .= ' ORDER BY wi.upload_date DESC
                    LIMIT ' . $offset . ',' . $limit;

            $result = $this->db->query($sql)->result();
            if ($result) {
                foreach ($result as $item) {
                    $item->movie_url = base_url('userfiles/wow/' . $item->movie_url);
                    $item->thumbnail_url = base_url('userfiles/wow/thumbnail/' . $item->thumbnail_url);
                    $item->nominee = $item->nominee == 0 ? 'no' : 'yes';
                    $item->wowticket = $item->wowticket == 0 ? 'no' : 'yes';
                    $items [] = $item;
                }
            }
        }

        $this->return['size'] = count($items);
        $this->return['totalSize'] = $total_size;

        $this->return['dataList'] = $items;

        $this->_send_output();
    }

    public function getEventByCategory($event_id = NULL) {
        $this->return['success'] = TRUE;
        //$this->return['retCode'] = 'E0000';
        //$this->return['retCodeMessage'] = $this->ERR_CODE['E0000'];

        $offset = intval($this->input->get('offset', TRUE));
        if (!$offset)
            $offset = 0;
        $limit = intval($this->input->get('limit', TRUE));
        if (!$limit)
            $limit = 10;

        $this->return['offset'] = $offset;
        $this->return['limit'] = $limit;

        $items = array();
        $total_size = 0;

        //get total size
        $sql = 'SELECT count(*) as total_records FROM uz_wow_gallery_category';
        if ($event_id) {
            $sql .= ' WHERE (event_id=' . $event_id . ')';
        }
        $check = $this->db->query($sql)->row();

        if ($check) {
            $total_size = $check->total_records;
        }



        if ($total_size > 0) {

            $sql = 'SELECT id as event_id,gal.category_name as event_name,category_id, cat.category_title  FROM uz_wow_gallery_category gal join uz_wow_category cat ON cat.category_id=gal.event_id ';
            if ($event_id) {
                $sql .= ' WHERE (event_id=' . $event_id . ')';
            }
            $sql .= ' ORDER BY id ASC
                    LIMIT ' . $offset . ',' . $limit;

            $result = $this->db->query($sql)->result();
            if ($result) {
                foreach ($result as $item) {
                    $items [] = $item;
                }
            }
        }

        $this->return['size'] = count($items);
        $this->return['totalSize'] = $total_size;

        $this->return['dataList'] = $items;

        $this->_send_output();
    }
    
    public function getNomineByEvent($event_id = NULL) {
        $this->return['success'] = TRUE;

        $offset = intval($this->input->get('offset', TRUE));
        if (!$offset)
            $offset = 0;
        $limit = intval($this->input->get('limit', TRUE));
        if (!$limit)
            $limit = 10;

        $this->return['offset'] = $offset;
        $this->return['limit'] = $limit;   
        $items = array();
        $total_size = 0;

        //get total size
        $sql = 'SELECT count(*) as total_records FROM uz_wow_items WHERE (approved=1) AND (transcoded=1)';
        if ($event_id) {
            $sql .= ' AND (event_id=' . $event_id .')';
        }
        
        $check = $this->db->query($sql)->row();
        
        if ($check) {
            $total_size = $check->total_records;
        }
        
        

        if ($total_size > 0) {

            $sql = 'SELECT *  FROM uz_wow_items WHERE (approved=1) AND (transcoded=1)';
            if ($event_id) {
                $sql .= ' AND (event_id=' . $event_id . ')';
            }
            $sql .= ' ORDER BY id ASC
                    LIMIT ' . $offset . ',' . $limit;
            $result = $this->db->query($sql)->result();

            if ($result) {
                foreach ($result as $item) {
                    $items [] = $item;
                }
            }
        }

        $this->return['size'] = count($items);
        $this->return['totalSize'] = $total_size;

        $this->return['dataList'] = $items;
        $this->_send_output();
    }
    
    public function getGaleryByEvent($event_id = NULL) {
        $this->return['success'] = TRUE;

        $offset = intval($this->input->get('offset', TRUE));
        if (!$offset)
            $offset = 0;
        $limit = intval($this->input->get('limit', TRUE));
        if (!$limit)
            $limit = 10;
        $kind = $this->input->get('kind', TRUE);
        if (!$kind)
            $kind = 'video';
        $category = $this->input->get('category', TRUE);

        
        
        if ($kind!= '' && !$this->isValidKind($kind)) {
            $kind = '';
        }
        
        if (!$event_id || $event_id == 1) {
            $event_id = false;
        }
        
        $this->return['offset'] = $offset;
        $this->return['limit'] = $limit;   
        $items = array();
        $total_size = 0;

        //get total size
        $sql = 'SELECT count(*) as total_records FROM uz_wow_gallery_items WHERE (transcoded=1)';
        
        if ($event_id) {
            $sql .= ' AND (event_id=' . $event_id . ')';
        }
        
        if ($kind) {
            $sql .= ' AND (item_type="' . $kind . '")';
        }        

        if ($category) {
            $sql .= ' AND (gallery_category_id="' . $kind . '")';
        }                
        

        $check = $this->db->query($sql)->row();
        
        if ($check) {
            $total_size = $check->total_records;
        }
        
        

        if ($total_size > 0) {

            $sql = 'SELECT *  FROM uz_wow_gallery_items WHERE (transcoded=1)';
            if ($event_id) {
                $sql .= ' AND (event_id=' . $event_id . ')';
            }
            if ($kind) {
                $sql .= ' AND (item_type="' . $kind . '")';
            }              
            if ($category) {
                $sql .= ' AND (gallery_category_id="' . $kind . '")';
            }                            
            $sql .= ' ORDER BY id ASC
                    LIMIT ' . $offset . ',' . $limit;
            
            $result = $this->db->query($sql)->result();

            if ($result) {
                foreach ($result as $item) {
                    $items [] = $item;
                }
            }
        }

        $this->return['size'] = count($items);
        $this->return['totalSize'] = $total_size;

        $this->return['dataList'] = $items;
        $this->_send_output();
    }    
    
    private function isValidKind($kindName) {
        switch (strtolower($kindName)) {
            case 'video':
            case 'image':                
                return true;
            break;    
            default:
                return false;
        }
    }
}

/*
 * file location: wow.php
 */
?>
