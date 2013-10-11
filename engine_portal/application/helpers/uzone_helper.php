<?php
if (!function_exists('row_number')){
    function row_number($number, $length=2, $pad='0', $pad_type=STR_PAD_LEFT){
        return str_pad($number, $length, $pad, $pad_type);
    }
}

if (!function_exists('cleanString')){
    function cleanString($subject, $replace=''){
        $search = array('\'','"');
        
        return str_replace($search, $replace, $subject);
    }
}

if (!function_exists('http_response_label')) {
    function http_response_label($code) {
        $text = '';
        switch ($code) {
            case 100: $text = 'Continue'; break;
            case 101: $text = 'Switching Protocols'; break;
            case 200: $text = 'OK'; break;
            case 201: $text = 'Created'; break;
            case 202: $text = 'Accepted'; break;
            case 203: $text = 'Non-Authoritative Information'; break;
            case 204: $text = 'No Content'; break;
            case 205: $text = 'Reset Content'; break;
            case 206: $text = 'Partial Content'; break;
            case 300: $text = 'Multiple Choices'; break;
            case 301: $text = 'Moved Permanently'; break;
            case 302: $text = 'Moved Temporarily'; break;
            case 303: $text = 'See Other'; break;
            case 304: $text = 'Not Modified'; break;
            case 305: $text = 'Use Proxy'; break;
            case 400: $text = 'Bad Request'; break;
            case 401: $text = 'Unauthorized'; break;
            case 402: $text = 'Payment Required'; break;
            case 403: $text = 'Forbidden'; break;
            case 404: $text = 'Not Found'; break;
            case 405: $text = 'Method Not Allowed'; break;
            case 406: $text = 'Not Acceptable'; break;
            case 407: $text = 'Proxy Authentication Required'; break;
            case 408: $text = 'Request Time-out'; break;
            case 409: $text = 'Conflict'; break;
            case 410: $text = 'Gone'; break;
            case 411: $text = 'Length Required'; break;
            case 412: $text = 'Precondition Failed'; break;
            case 413: $text = 'Request Entity Too Large'; break;
            case 414: $text = 'Request-URI Too Large'; break;
            case 415: $text = 'Unsupported Media Type'; break;
            case 500: $text = 'Internal Server Error'; break;
            case 501: $text = 'Not Implemented'; break;
            case 502: $text = 'Bad Gateway'; break;
            case 503: $text = 'Service Unavailable'; break;
            case 504: $text = 'Gateway Time-out'; break;
            case 505: $text = 'HTTP Version not supported'; break;
            default:
                exit('Unknown http status code "' . htmlentities($code) . '"');
                break;
        }
        
        return $text;
    }
}

if (!function_exists('get_url_headers')){
    function get_url_headers($url, $set_time_out=10){
        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_URL,            $url); 
        curl_setopt($ch, CURLOPT_HEADER,         true); 
        curl_setopt($ch, CURLOPT_NOBODY,         true); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_TIMEOUT,        $set_time_out); 

        $r = curl_exec($ch); 

        if (curl_errno($ch)){
            return FALSE;
        }

        if ($r)
            $r = explode("\n", $r); 
        return $r; 
    }
}
if (!function_exists('is_valid_remote_file')){
    function is_valid_remote_file($url, $time_out=10, $mime_type=NULL, $strict_length=FALSE){
        //try to get header
        $result = get_url_headers($url, $time_out);

        $response_ok = FALSE;
        $length_ok = FALSE;

        if ($result){
            foreach($result as $stream_index){
                //check http status
                if (strpos($stream_index, 'HTTP/')!==FALSE && strpos($stream_index, '200 OK')!==FALSE){
                    $response_ok = TRUE;
                }

                //Content length
                if (strpos($stream_index, 'Content-Length')!==FALSE){
                    $content_length = explode(':', $stream_index);

                    if ((int)$content_length[count($content_length)-1] > 3)
                        $length_ok = TRUE;
                }

                //check mime type if not null
                if ($mime_type && (strpos($stream_index, 'Content-Type')!==FALSE &&  strpos(strtolower($stream_index), strtolower($mime_type))===FALSE)){
                    return FALSE;
                }
            }

            //Past all Test !. It should be valid file
            if ($strict_length){
                return ($response_ok && $length_ok);
            }else{
                return $response_ok;
            }
        }

        return FALSE;
    }
}
?>
