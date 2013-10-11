<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of QBook
 * API to acces QBaca books data
 *
 * @author master
 */

class Qbook {
    
    protected $_api_url = 'http://dev.qbaca.com/bookContent/';
    public $_format = 'array';
    
    protected $_filter = array(
        'http://qbaca.com/book/detail/',
        'http://dev.qbaca.com/book/detail/'
    );


    private $_book_category = array(
        'Business', 'Comic', 'Education', 'Family', 'Inspiration',
        'Kids', 'Novel', 'Religion', 'Technology', 'Travel'
    );
    
    function __construct($format='json') {
        $this->_format = $format;
    }
    
    /**
     * List all book categories
     * @return mix
     */
    public function book_category(){
        return $this->_output(json_encode($this->_book_category));
    }
    /**
     * Get a top 10 list of most downloaded books
     * @return mix
     */
    public function top_download(){
        $result = file_get_contents($this->_api_url .'topDownloaded');
        //$result = str_replace('http://qbaca.com/book/detail/', '', $result);
        
        return $this->_output($result);
    }
    
    /**
     * Get a top 10 list of most sold books
     * @return mix
     */
    public function top_sales(){
        $result = file_get_contents($this->_api_url .'topSales');
        
        return $this->_output($result);
    }
    
    public function featured(){
        
        $result = file_get_contents($this->_api_url);
        return $this->_output($result);
    }
    
    /**
     * Get all lists of books from each featured
     * @param STRING $feature opt:[Bestseller,New,Free,School]
     * @param INT $per_page
     * @param INT $offset
     * @param string $sort opt:[asc|desc]
     * @return mix
     */
    public function get_by_features($feature='Bestseller',$per_page=5,$offset=0,$sort='desc'){
        $helper_url = 'featured/'.$feature.'?per_page='.$per_page.'&offset='.$offset.'&sort='.$sort;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }
    
    /**
     * Get all lists of books from each category
     * @param STRING $category
     * @param INT $per_page
     * @param INT $offset
     * @param string $sort opt:[asc|desc]
     * @return type
     */
    public function get_by_category($category='Business',$per_page=5,$offset=0,$sort='desc'){
        $helper_url = 'category/'.$category.'?per_page='.$per_page.'&offset='.$offset.'&sort='.$sort;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }
    
    /**
     * Get book details
     * @param STRING $book_id
     * @return mix
     */
    public function get_detail($book_id){
        $helper_url = 'detail/'.$book_id;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }
    
    /**
     * Search and listing content
     * @param string $title
     * @param int $per_page
     * @param int $offset
     * @param string $sort opt:[asc|desc]
     * @return type
     */
    public function search_by_title($title='Book',$per_page=5,$offset=0,$sort='desc'){
        $helper_url = 'search/'.$title.'?per_page='.$per_page.'&offset='.$offset.'&sort='.$sort;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }
    
    /**
     * List of user's books
     * @param string $email
     * @param int $per_page
     * @param int $offset
     * @param string $sort opt:[asc|desc]
     * @return type
     */
    public function my_books($email,$per_page=5,$offset=0,$sort='desc'){
        $helper_url = 'mybooks?email='.$email.'&per_page='.$per_page.'&offset='.$offset.'&sort='.$sort;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }
    
    /**
     * Books purchased status
     * @param string $email email add
     * @param string $cid book id
     * @return mix
     */
    public function purchase_status($email, $cid){
        $helper_url = 'purchases?email='.$email.'$cid='.$cid;
        
        $result = file_get_contents($this->_api_url .$helper_url);
        return $this->_output($result);
    }

    /**
     * Helper function to output return value format
     * @param mix $data
     * @return mix
     */
    public function _output($data){
        
        $data = str_replace($this->_filter, '', $data);
        if ($this->_format=='json')
            return $data;
        else
            return json_decode ($data);
    }
}

?>
