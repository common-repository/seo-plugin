<?php
// Saving option to Database
function seoplugins_save_admin_options() {
	if ( $_REQUEST['page'] == 'seoplugins' ) {
	 	if ( 'save' == $_REQUEST['seoplugins_save'] ) {
	 		global $admin_options;
	 		return seoplugins_save_options($admin_options); 
			
	 	} elseif ( 'reset' == $_REQUEST['seoplugins_reset'] ) {

			global $wpdb;
			$query = "DELETE FROM $wpdb->options WHERE option_name LIKE 'seoplugins_%'";
			$wpdb->query($query);
			return 'reset';
		}
	}
}

function seoplugins_save_options($options = null) {
	global $seoplugins;
	$prefix = $seoplugins->prefix;

	foreach ($options as $option) { 
	
		if(is_array($option['type'])) {  
			foreach($option['type'] as $array){
				if($array['type'] == 'text'){
					seoplugins_save_text($array); 
				}
			}
		}

		switch ( $option['type'] ) {		
			case 'text':
				seoplugins_save_text($option);
				break;
	        
	        case 'checkbox':
				seoplugins_save_checkbox($option);
				break;
	        
	        case 'multicheck':
				seoplugins_save_multicheck($option);
				break;
	        
	        case 'multi':
				seoplugins_save_multi($option);
				break;
	        
	        case 'slider':
				seoplugins_save_slider($option);
				break;
	        
	        case 'boxes':
				seoplugins_save_boxes($option);
				break;
	        default:
	        	seoplugins_save_default($option); 
		}
	}
	
	if ( $_REQUEST['page'] == 'seoplugins' && $_REQUEST['seoplugins_save'] == 'save' ) {
		return 'saved';
	}	
}
