<?php

// Generate custom fields
	
function seoplugins_options_page_content($get_option = null, $only_form = false) {
	global $admin_options, $seoplugins;
	$prefix = $seoplugins->prefix;

    $counter 		= 0;
    $draw_tabs_li 	= '';
    $heading_open 	= false;
    $tab_open 		= false;

    if(empty($get_option)) {
    	$options     = $admin_options;
    } else {
    	$options     = $get_option;
    } 
    
    
    foreach ($options as $value) {
    
    	if ($only_form === false && $value['type'] != "heading" && $value['type'] != "boxes"  && $value['type'] != "tableList" && $value['type'] != "tab" && $value['type'] != "metabox" )
         {
            $output .= '<div class="option option-'. $value['type'] .'">'."\n".'<div class="option-inner">'."\n";
            $output .= '<label class="titledesc">'. $value['name'] .'</label>'."\n";
            $output .= '<div class="formcontainer">'."\n".'<div class="forminp">'."\n";
         }
    
        if ( is_array($value['type']) ) $output .= seoplugins_array_type($value);
         
		switch ( $value['type'] ) {	        
	        case "heading":  
	            if($heading_open){
	               $output .= '</div>'."\n";
	               $heading_open = false;
	            }
	     
	            $output .= '<div class="title postbox">';
	            $output .= '<p class="submit"><input name="save" type="submit" value="Save All Changes" /></p>';
			    $output .= '<h3>'. $value['name'] .'</h3>'."\n";    
	            $output .= '</div>'."\n";
	            $output .= '<div class="option_content">'."\n";
	            $heading_open = true;
	            
	        break;
	        
	        case "tab":
	        
	         if($tab_open) { $output .= "</div></div>\n"; $tab_open = false; }
	        
				$draw_tabs_li .= '<li><a href="#tab_'.$value['id'].'">'.$value['name'].'</a></li>'."\n";
				$output    .= '<div id="tab_'.$value['id'].'">'."\n";
				$tab_open = true;
				$heading_open = false;
				
			break;
			
			case "tableList":
				$output .= 		seoplugins_listdatabase($value);

			break;
			
			
			case 'text':
	             $output .= 		seoplugins_text($value);
	        break;
	        
	        case 'textarea':
				 $output .= 		seoplugins_textarea($value);
        	break;
	        
			case 'select':
				 $output .= 		seoplugins_select($value);
        	break;
        	
        	case 'radio':
				 $output .= 		seoplugins_radio($value);
        	break;
        	
        	case 'checkbox':
				 $output .= 		seoplugins_checkbox($value);
        	break;
        	
        	case 'multicheck':
				 $output .= 		seoplugins_multicheck($value);
        	break;        	
        	
        	case 'dropdown_categories':
				 $output .= 		seoplugins_dropdown_categories($value);
        	break;
        	
        	case 'dropdown_pages':
				 $output .= 		seoplugins_dropdown_pages($value);
        	break;
        	
        	case 'upload':
				 $output .= 		seoplugins_upload($value);
        	break;
        	
        	case 'multi':
				 $output .= 		seoplugins_multi($value);
        	break;
        	
        	case 'slider':
				 $output .= 		seoplugins_slider($value);
        	break;
        	
        	case 'boxes':
				 $output .= 		seoplugins_boxes($value);
        	break;

        	
  
		} //END switch ( $value['type'] )
	

        //-------------------------------------------//
        
        if ($only_form === false && $value['type'] != "heading" && $value['type'] != "boxes"  && $value['type'] != "tableList" && $value['type'] != "tab" && $value['type'] != "metabox") { 
            if ( $value['type'] != "checkbox" ) 
                { 
                $output .= '<br/>';
                }
                
            $output .= '</div><div class="desc">'. $value['desc'] .'</div></div>'."\n";
            $output .= '</div></div><div class="clear"></div>'."\n";
        
        } // END if
		

    } //END foreach ($options as $value)
    
	if(empty($get_option)) {
    	$output .= '</div></div>';
    }    
    
	//generate header for tabs
	$draw_tabs  =  "<ul>\n";
	$draw_tabs .=  $draw_tabs_li;
	$draw_tabs .=  "</ul>\n";
	
	$output_content  = '<div id="tabs">'."\n";
	$output_content .= $draw_tabs . $output;
	$output_content .= '</div>'."\n";
    
	if(empty($get_option)) {
    	return $output_content;
    } else {
    	return $output;
    }

}  //END seoplugins_options_page_content()

?>