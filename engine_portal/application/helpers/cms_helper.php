<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('indonesia_date_format')){
    /**
     * 
     * @param type $format
     * @param type $time
     */
    function indonesia_date_format($format='d-m-Y', $time=NULL){
        
        //create date object
        if (!$time) $time = time();
        $date_obj  =  getdate($time);
        
        //set Indonesian month name
        $bulan = array(
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli',
            'Agustus', 'September', 'Oktober', 'Nopember', 'Desember'
        );
        
        $bulan_short = array(
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agu', 'Sep', 'Okt', 'Nop', 'Des'
        );
        
        $hari = array(
            'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
        );
        
        $format_search = array(
            'd'=>$date_obj['mday'],
            'D'=>$hari[$date_obj['wday']],
            'm'=>$date_obj['mon'],
            'M'=>$bulan[$date_obj['mon']-1],
            'S'=>$bulan_short[$date_obj['mon']-1],
            'y'=>$date_obj['year'],
            'Y'=>$date_obj['year'],
            'H'=>$date_obj['hours'],
            'i'=>$date_obj['minutes'],
            's'=>$date_obj['seconds']
        );
        
        //split requested format to array
        $req_format = str_split($format);
        
        $return_formated_date = array();
        foreach($req_format as $element){
            if (ctype_alpha($element)){
                $return_formated_date [] = $format_search[$element];
            }else{
                $return_formated_date [] = $element;
            }
        }
        
        return implode('', $return_formated_date);
    }
}

if (!function_exists('btn_new')){
    function btn_new($uri='#', $attributes=''){
        return anchor($uri, '<i class="icon-file"></i> Create New ', $attributes );
    }
}

if (!function_exists('btn_edit')){
    function btn_edit($uri='#', $attributes=''){
        return anchor($uri, '<i class="icon-edit"></i>', $attributes);
    }
}

if (!function_exists('btn_delete')){
    function btn_delete($uri){
        return anchor($uri, '<i class="icon-remove" title="Remove"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');",
                'title' =>  'Delete item'
	));
    }
}

if (!function_exists('btn_upload')){
    function btn_upload($uri){
        return anchor($uri, '<i class="icon-upload" title="Upload"></i>');
    }
}

if (!function_exists('btn_syncronize')){
    function btn_syncronize($uri, $title=''){
        return anchor($uri, '<i class="icon-refresh"></i>' . $title, array(
		'onclick' => "return confirm('Syncronize with API will replace old with new data and takes time. Are you sure?');",
                'title' => 'Syncronize'
	));
    }
}

if (!function_exists('create_pagination')){
    function create_pagination($total_pages, $current_page, $url_format='%i'){
        $str = '';
        if ($total_pages > 1){
            $str.= '<div class="pagination">';
            $str.= '<ul>';
            
            if ($total_pages > 2){
                $str.= '<li'.($current_page==0?' class="disabled"':'').'><a'.($current_page>0?' href="'.str_replace('%i',($current_page-1),$url_format).'"':''). '>Prev</a></li>';
            }
            
            for($i=0;$i<$total_pages;$i++){
                $str.= '<li'. ($current_page==$i?' class="active"':'') .'><a href="'.  str_replace('%i',$i,$url_format) .'">'.($i+1).'</a></li>';
            }
            
            if ($total_pages > 2){
                $str.= '<li'.($current_page==($total_pages-1)?' class="disabled"':'').'><a'.($current_page<($total_pages-1)?' href="'.str_replace('%i',($current_page+1),$url_format).'"':''). '>Next</a></li>';
            }
            
            $str.= '</ul>';
            $str.= '</div>';
        }
        
        return $str;
    }
}

if (!function_exists('smart_paging_js')){
    function smart_paging_js($totalPages, $page=1, $jsClick='', $adjacents=2, $offsetTag='$'){  
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = $totalPages-1;		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;			//last page minus 1
	
	/* 
         * Now we apply our rules and draw the pagination object. 
         * We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = '';
	if($lastpage >=1)
	{	
            $pagination .= '<div class="pagination"><ul class="pagination">';
            //previous button
            if ($page > 1) 
                $pagination.= '<li><a href='.  parseJs($jsClick, $prev, $offsetTag).'>&laquo;</a></li>';
            else
                $pagination.= '<li class="disabled"><a>&laquo;</a></li>';
		
            //pages	
            if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
            {	
                for ($counter = 1; $counter <= $totalPages; $counter++)
		{
                    if ($counter == $page)
                        $pagination.= '<li class="active"><a class="current">'.$counter.'</a></li>';
                    else
                        $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';				
		}
            }
            
            elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
            {
                //close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))		
		{
                    for ($counter = 1; $counter < 5 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a class="current">'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';			
                    }
                    $pagination.='<li><a>...</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lpm1).'>'.$lpm1.'</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lastpage).'>'.$lastpage.'</a></li>';
                    
                }
                //in middle; hide some front and some back
                elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
                    $pagination.= '<li><a href='.  parseJs($jsClick, 1).'>1</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, 2).'>2</a></li>';
                    $pagination.='<li><a>...</a></li>';
                    for ($counter = $page - $adjacents; $counter <= $page+1 + $adjacents; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
			else
                            $pagination.= '<li><a href='.  parseJs($jsClick, $counter).'>'.$counter.'</a></li>';
                    }
                    $pagination.='<li><a>...</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lpm1).'>'.$lpm1.'</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, $lastpage).'>'.$lastpage.'</a></li>';
                }
                //close to end; only hide early pages
		else
		{
                    $pagination.= '<li><a href='.  parseJs($jsClick, 1).'>1</a></li>';
                    $pagination.= '<li><a href='.  parseJs($jsClick, 2).'>2</a></li>';
                    $pagination.='<li><a>...</a></li>';
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $totalPages; $counter++)
                    {
                        if ($counter == $page)
                            $pagination.= '<li class="active"><a>'.$counter.'</a></li>';
                        else
                            $pagination.= '<li><a href='.parseJs($jsClick, $counter).'>'.$counter.'</a></li>';				
                    }
		}
            }
            
            //next button
            if ($page < $totalPages) 
                $pagination.= '<li><a href='. parseJs($jsClick, $next).'>&raquo;</a></li>';
            else
                $pagination.= '<li class="disabled"><a>&raquo;</a></li>';

            $pagination.= '</ul></div>';
	}
		
	
        
        return $pagination;
    }
    
    function parseJs($js, $var, $tag='$'){
        return str_replace($tag, $var, $js);
    }
}

if (!function_exists('my_urlencode')){
    function my_urlencode($segments,$separator=','){
        $url = explode($separator, $segments);
        
        return implode('-', $url);
    }
}

if (!function_exists('my_urldecode')){
    function my_urldecode($decode_url){
        $url = explode('-', $decode_url);
        
        return implode('/',$url);
    }
}

if (!function_exists('cleanString')){
    function cleanString($subject, $replace='', $search=array('\'','"')){
        return str_replace($search, $replace, $subject);
    }
}
/*
 * file location: /application/helpers/cms_helper.php
 */
?>
