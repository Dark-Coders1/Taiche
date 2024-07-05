<?php

// General Functions for Plugin

if(!function_exists('is_post'))
{
    function is_post()
    {
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
            return true;
        else
            return false;
    }    
}

if (!function_exists('is_in_post')) {

    function is_in_post($key='', $val='') {
        if ($key == '') {
            return false;
        } else {
            if (isset($_POST[$key])) {
                if ($val == '')
                    return true;
                else if ($_POST[$key] == $val)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }
}

if(!function_exists('is_get'))
{
    function is_get()
    {
        if(strtolower($_SERVER['REQUEST_METHOD']) == 'get')
            return true;
        else
            return false;
    }    
}


if (!function_exists('is_in_get')) {

    function is_in_get($key='', $val='') {
        if ($key == '') {
            return false;
        } else {
            if (isset($_GET[$key])) {
                if ($val == '')
                    return true;
                else if ($_GET[$key] == $val)
                    return true;
                else
                    return false;
            }
            else
                return false;
        }
    }

}

if (!function_exists('not_null')) {

    function not_null($value) {
        if (is_array($value)) {
            if (sizeof($value) > 0)
                return true;
            else
                return false;
        }
        else {
            if ((is_string($value) || is_int($value)) && ($value != '') && ($value != 'NULL') && (strlen(trim($value)) > 0))
                return true;
            else
                return false;
        }
    }

}



if (!function_exists('get_value')) {

    function get_value($key='') {
        if ($key != '') {
            if (isset($_GET[$key]) && not_null($_GET[$key])) {
                if (!is_array($_GET[$key]))
                    return trim($_GET[$key]);
                else
                    return $_GET[$key];
            }

            else
                return '';
        }
        else
            return '';
    }

}


if (!function_exists('post_value')) {

    function post_value($key='') {
        if ($key != '') {
            if (isset($_POST[$key]) && not_null($_POST[$key])) {
                if (!is_array($_POST[$key]))
                    return trim($_POST[$key]);
                else
                    return $_POST[$key];
            }
            else
                return '';
        }
        else
            return '';
    }

}


if (!function_exists('is_opera')) {

    function is_opera() {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return preg_match('/opera/i', $user_agent);
    }

}

if (!function_exists('is_safari')) {

    function is_safari() {
        $user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        return (preg_match('/safari/i', $user_agent) && !preg_match('/chrome/i', $user_agent));
    }

}

// Check with the magic quotes functionality Start
function stripslashess(&$item) {
    $item = stripslashes($item);
}

if (get_magic_quotes_gpc ()) {
    array_walk_recursive($_GET, 'stripslashess');
    array_walk_recursive($_POST, 'stripslashess');
    array_walk_recursive($_SERVER, 'stripslashess');
}


if (!function_exists('remove_script_tags')) {

    function remove_script_tags($text) {
        $text = str_ireplace("<script>", "", $text);
        $text = str_ireplace("</script>", "", $text);

        return $text;
    }

}

if (!function_exists('upme_date_format_to_standerd')) {

    function upme_date_format_to_standerd($date, $format) {

        $datetime = '';

        $date = str_replace(",", "", $date);
        $datetime =  date("m/d/Y", strtotime($date));

        return $datetime;
    }

}

if (!function_exists('upme_date_format_to_custom')) {

    function upme_date_format_to_custom($date, $format) {

            switch ($format) {
                case 'mm/dd/yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("m/d/Y");
                    break;

                case 'yy/mm/dd':
                    $date = new DateTime($date);
                    $datetime =  $date->format("Y/m/d");
                    break;

                case 'dd/mm/yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("d/m/Y");
                    break;

                case 'yy-mm-dd':
                    $date = new DateTime($date);
                    $datetime =  $date->format("Y-m-d");
                    break;

                case 'dd-mm-yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("d-m-Y");
                    break;

                case 'mm-dd-yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("m-d-Y");
                    break;

                case 'MM d, yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("F j, Y");
                    break;

                case 'd M, y':
                    $date = new DateTime($date);
                    $datetime =  $date->format("j M, y");
                    break;

                case 'd MM, y':
                    $date = new DateTime($date);
                    $datetime =  $date->format("j F, y");
                    break;

                case 'DD, d MM, yy':
                    $date = new DateTime($date);
                    $datetime =  $date->format("l, j F, Y");
                    break;

                default:
                    $date = new DateTime($date);
                    $datetime =  $date->format("m/d/Y");
                    break;
            }
            
            return $datetime;
    }

}


if (!function_exists('upme_get_uploads_folder_details')) {

    function upme_get_uploads_folder_details() {

        // Checking for valid uploads folder
    if ( ! ( $upload_dir = wp_upload_dir() ) )
            return false;

    return $upload_dir;

    }

}

if (!function_exists('upme_manage_string_for_meta')) 
{
    function upme_manage_string_for_meta($string='')
    {
        $badChars =array(' ',',','$','&','\'',':','<','>','[',']','{','}','#','%','@','/',';','=','?','\\','^','|','~','(',')','"','.');
        $string = str_replace($badChars,'_',trim($string));
        $string = trim($string,'_');
        $string = str_replace('___','_',trim($string));
        $string = str_replace('__','_',trim($string));
        return strtolower($string);
    }    
}

if (!function_exists('upme_update_user_cache'))
{
    function upme_update_user_cache($user_id)
    {
        global $wpdb;
        
        $meta_values_query = "SELECT meta_key, meta_value FROM ".$wpdb->usermeta." WHERE meta_key!='_upme_search_cache' AND user_id=".esc_sql($user_id); 
        
        $meta_data = $wpdb->get_results($meta_values_query,'ARRAY_A');
        
        
        $profile_fields = get_option('upme_profile_fields');
        
        $upme_fields_meta = array();
        foreach($profile_fields as $key=>$value)
        {
            if($value['type'] == 'usermeta')
            {
                $upme_fields_meta[] = $value['meta'];
            }    
        }
        
        $search_cache = array();
        
        foreach($meta_data as $k=>$v)
        {
            if($v['meta_key'] == $wpdb->get_blog_prefix()."capabilities")
            {
                $roles = unserialize($v['meta_value']);
                foreach ($roles as $role_key=>$role_value)
                {
                    $search_cache[] = 'role::'.$role_key;
                }
            }
            else
            {
                if(in_array($v['meta_key'], $upme_fields_meta))
                {
                    if($v['meta_value'] == '' || $v['meta_value'] == '0')
                    {
                        $search_cache[] = $v['meta_key'].'::'.$v['meta_value'];
                    }
                    else
                    {
                        $multi_data = explode(',',$v['meta_value']);
                        foreach($multi_data as $data_key=>$data_value)
                        {
                            $search_cache[] = $v['meta_key'].'::'.trim($data_value);
                        }
                    }
                }
            }
            
            
        }
        
        $search_cache_string = '';
        $search_cache_string = implode('||', $search_cache);
        
        update_user_meta($user_id,'_upme_search_cache',$search_cache_string);
    }  
}

if (!function_exists('upme_cron_user_cache'))
{
    function upme_cron_user_cache()
    {
        global $wpdb;

        $current_option = get_option('upme_options');

        // Execute Only if set to yes
        if(isset($current_option['use_cron']) && $current_option['use_cron'] == '1')
        {
            $last_processed_user = get_option('upme_cron_processed_user_id');
            if($last_processed_user == '')
            {
                $last_processed_user = 0;
            }

            $limit = 25;

            $user_query = "SELECT ID FROM ".$wpdb->users." WHERE ID>'".esc_sql($last_processed_user)."' ORDER BY ID ASC LIMIT ".$limit;

            $users = $wpdb->get_results($user_query,'ARRAY_A');

            $count = 0;
            foreach($users as $key=>$value)
            {
                upme_update_user_cache($value['ID']);

                update_option('upme_cron_processed_user_id', $value['ID']);

                $count++;
            }

            // All users completed, so resetting value to 0
            if($count<$limit)
            {
                update_option('upme_cron_processed_user_id', '0');
            }

        }
    }
}

if (!function_exists('upme_activation'))
{
    function upme_activation()
    {
        if (!wp_next_scheduled( 'upme_process_cache_cron' ) )
        {
            wp_schedule_event( time(), 'hourly', 'upme_process_cache_cron');
        }
    }
}

if (!function_exists('upme_deactivation'))
{
    function upme_deactivation()
    {
        wp_clear_scheduled_hook( 'upme_process_cache_cron' );
    }
}

if (!function_exists('upme_video_url_customizer'))
{
    function upme_video_url_customizer($url)
    {
        $url_parts = parse_url($url);
        if($url_parts){
            $host = isset($url_parts['host']) ? $url_parts['host'] : '';
            $query = isset($url_parts['query']) ? $url_parts['query'] : '';
            $path = isset($url_parts['path']) ? $url_parts['path'] : '';
            $player_url = '';
            if('www.youtube.com' == $host){
                $player_url = upme_youtube_url_customizer($query);
            }else if('vimeo.com' == $host){
                $player_url = upme_vimeo_url_customizer($path);
            }
            return $player_url;
        }else{
            return false;
        }
    }
}

if (!function_exists('upme_vimeo_url_customizer'))
{
    function upme_vimeo_url_customizer($path){
        $player_url = '//player.vimeo.com/video'.$path;
        return $player_url; 
    }
}


if (!function_exists('upme_youtube_url_customizer'))
{
    function upme_youtube_url_customizer($query){
        $query_parts = explode('=',$query);
        $video_str = isset($query_parts[1]) ? $query_parts[1]  : '';
        $player_url = '//www.youtube.com/embed/'.$video_str;
        return $player_url;
    }
}

if (!function_exists('upme_video_type_css'))
{
    function upme_video_type_css($url)
    {
        $url_parts = parse_url($url);
        $player_details = array();
        if($url_parts){
            $host = isset($url_parts['host']) ? $url_parts['host'] : '';
            
            if('www.youtube.com' == $host){
                $player_details['height'] = '315';
                $player_details['width'] = '560';
            }else if('vimeo.com' == $host){
                $player_details['height'] = '281';
                $player_details['width'] = '500';
            }
            return $player_details;
        }else{
            return $player_details;
        }
    }
}