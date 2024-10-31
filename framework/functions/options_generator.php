<?php

//----------------------------------------------------------------------------//	


//Generate a text field
function seoplugins_text($value) {
	$val = $value ['std'];
	$value ['id'];
	if (seoplugins_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}
	
	return '<input name="' . $value ['id'] . '" style="' . ( $value['width'] != "" ? "width: {$value['width']}px" : "" ) . '" id="' . $value ['id'] . '" type="' . $value ['type'] . '" value="' . $val . '" '.($value['readonly'] === true ? 'readonly' : '').' />';

} //END seoplugins_text()


//----------------------------------------------------------------------------//	


// Generate fields with array type
function seoplugins_array_type($value) {
	global $post;
	
	foreach ( $value ['type'] as $array ) {
        
		$id = $array ['id'];
		$val = $array ['std'];
		$meta = $array ['meta'];
        $style = $array ['style'];
		if (seoplugins_option_exist ( $id ))
			$val = get_option ( $id );
			/*
		if ($_REQUEST ['page'] == 'seoplugins') {
			if (seoplugins_option_exist ( $id ))
				$val = get_option ( $id );
		} else {
			if (seoplugins_meta_exist ( $id ))
				$val = get_post_meta ( $post->ID, $id, true );
		}
		*/
		if ($array ['type'] == 'text') {
			$output .= '<input class="input-text-small" name="' . $id . '" id="' . $id . '" type="text" value="' . $val . '" style="' . ( $style ) .'" /> <span class="meta-two">' . $meta . '</span>';
		}
	}
	
	return $output;

} //END seoplugins_array_type()


//----------------------------------------------------------------------------//


function seoplugins_textarea($value) {
	
	$ta_options = $value ['options'];
	$val = $value ['std'];
	
	if (seoplugins_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}
	
	return '<textarea style="' . ( $value['width'] != "" ? "width: {$value['width']}px;" : "" ) . ' ' . ( $value['height'] != "" ? "height: {$value['height']}px;" : "" ) . '" name="' . $value ['id'] . '" id="' . $value ['id'] . '" cols="' . $ta_options ['cols'] . '" rows="8">' . $val . '</textarea>';

} //END seoplugins_textarea()


//----------------------------------------------------------------------------//


function seoplugins_checkbox($value) {
	
	$val = $value ['std'];
	
	if (seoplugins_option_exist ( $value ['id'] )) {
		$val = get_option ( $value ['id'] );
	}
	
	if ($val == 'true') {
		$checked = 'checked="checked"';
	} else {
		$checked = '';
	}
	
	$output .= '<input type="checkbox" class="single_checkbox" name="' . $value ['id'] . '" id="' . $value ['id'] . '" value="true" ' . $checked . ' />';
	
	return $output;

} //END seoplugins_checkbox()


//----------------------------------------------------------------------------//


//Generate multi checkboxes
function seoplugins_multicheck($value) {
	global $post;
	
	foreach ( $value ['options'] as $key => $option ) {
		if ($key === 0)
			continue;
		
		$val = $value ['std'];
		$rox_key = $value ['id'] . '_' . $key;
		
		if ($_REQUEST ['page'] == 'seoplugins' || basename ( $_SERVER ['PHP_SELF'] ) == "categories.php") {
			if (seoplugins_option_exist ( $rox_key ))
				$val = get_option ( $rox_key );
		} else {
			if (seoplugins_meta_exist ( $rox_key ))
				$val = get_post_meta ( $post->ID, $rox_key, true );
		}
		
		if ($val == 'true' or $val == $key) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}
		
		$output .= '
			<div class="multicheckbox"><input type="checkbox" class="checkbox" name="' . $rox_key . '" id="' . $rox_key . '" value="true" ' . $checked . ' /> 
			' . $option . '</div>';
	}
	
	return $output;

} //END seoplugins_multicheck() 


//----------------------------------------------------------------------------//  


function seoplugins_radio($value) {
	
	foreach ( $value ['options'] as $key => $option ) {
		if ($key === 0)
			continue;
		
		if (seoplugins_option_exist ( $value ['id'] )) {
			$val = get_option ( $value ['id'] );
		} else {
			$val = $value ['std'];
		}
		
		if ($val == $key) {
			$checked = ' checked';
		} else {
			$checked = '';
		}
		
		$output .= '
			<div class="multicheckbox"><input type="radio" class="checkbox ' . $value ['id'] . ' " name="' . $value ['id'] . '"  value="' . $key . '" ' . $checked . ' /> 
			' . $option . '</div>';
	}
	return $output;

} //END seoplugins_radio()


//----------------------------------------------------------------------------//


function seoplugins_select($value) {
	
	$output = '<select name="' . $value ['id'] . '" id="' . $value ['id'] . '">';
	
	foreach ( $value ['options'] as $key => $option ) {
		
		if (seoplugins_option_exist ( $value ['id'] )) {
			$val = get_option ( $value ['id'] );
		} else {
			$val = $value ['std'];
		}
		
		if ($val == $key) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}
		
		$output .= '<option' . $selected . ' value="' . $key . '">';
		$output .= $option;
		$output .= '</option>';
	}
	
	$output .= '</select>';
	
	return $output;

} // END seoplugins_select()


//----------------------------------------------------------------------------//


function seoplugins_listdatabase($value) {
	global $wpdb;
	
	$output = '<table cellspacing="0" class="widefat tag fixed" >
		<tfoot>
			<tr>';
				foreach ($value['options']  as $key => $val){
					$output .= '<th scope="col">'.($val).'</th>';
				}
	$output .= '</tr>
		</tfoot>
		
		<tbody class="list:tag">';

		// get entry
		$entry = (array)$wpdb->get_results( "SELECT ".(implode(" ,", $value['options']))." FROM ".($value['std'])." WHERE 1=1");
		if(count($entry) > 0){
			$cc = 0;
			foreach ($entry as $key => $value2){
							
			$output .= '<tr class="<?php echo $cc % 2 ? \'alternate\' : \'\';?>">';
			
				foreach ($value['options']  as $key => $val){
					$output .= '<td>'.($value2->$val).'</td>';
				}
					
			$output .= '</tr>';
			
						$cc++;
					}
				}else{
			$output .= '
				<tr class="alternate" id="tag-4">
					<td class="name column-name" colspan="'.(count($value['options'])).'"><strong style="color:red">NO entry yet!</strong></td>
				</tr>';
					
				}
		$output .= '</tbody>
	</table>';
	
	return $output;
} // END seoplugins_select()


function seoplugins_multi($value) {
	global $post;
	
	$output .= '<div class="multiple_box">';
	
	$hidden_name = $value ['id'] . '_hidden';
	
	//get nr of entries
	if ($_REQUEST ['page'] == 'seoplugins' || basename ( $_SERVER ['PHP_SELF'] ) == "categories.php") {
		if (seoplugins_option_exist ( $hidden_name ))
			$settings_hidden_name = get_option ( $hidden_name );
	} else {
		if (seoplugins_meta_exist ( $hidden_name ))
			$settings_hidden_name = get_post_meta ( $post->ID, $hidden_name, true );
	}
	
	if ($settings_hidden_name == "" || $settings_hidden_name === false) {
		$settings_hidden_name = 1;
	}
	
	for($i = 0; $i < $settings_hidden_name; $i ++) {
		
		if ($value ['subtype'] == 'page') {
			$select = 'Select additional page?';
			$entries = get_pages ( 'title_li=&orderby=name' );
		} elseif ($value ['subtype'] == 'category') {
			$select = 'Select additional category?';
			$entries = get_categories ( 'title_li=&orderby=name&hide_empty=0' );
		} else {
			$select = 'Select additional category or page?';
			$entries_cat = get_categories ( 'title_li=&orderby=name&hide_empty=0' );
			$entries_page = get_pages ( 'title_li=&orderby=name' );
			$entries = array_merge ( $entries_page, $entries_cat );
		}
		
		$output .= '<select class="postform multiply_me disable_me" id="' . $value ['id'] . '_' . $i . '" name="' . $value ['id'] . '_' . $i . '"> ';
		$output .= '<option value="0">' . $select . '</option>  ';
		
		if ($_REQUEST ['page'] == 'seoplugins' || basename ( $_SERVER ['PHP_SELF'] ) == "categories.php") {
			if (seoplugins_option_exist ( $value ['id'] . '_' . $i ))
				$home_val = trim ( get_option ( $value ['id'] . '_' . $i ) );
		} else {
			if (seoplugins_meta_exist ( $value ['id'] . '_' . $i ))
				$home_val = trim ( get_post_meta ( $post->ID, $value ['id'] . '_' . $i, true ) );
		}
		
		if ($home_val == "home")
			$selected = "selected='selected'";
		else
			$selected = "";
		
		if ($value ['subtype'] != 'category' && $value ['subtype'] != 'page')
			$output .= '<option ' . $selected . ' value="home">Home</option>  ';
		
		foreach ( $entries as $entry ) {
			
			$prefixt = '';
			
			if ($value ['subtype'] == 'page' || $entry->post_title != '') {
				if ($value ['subtype'] != 'category' && $value ['subtype'] != 'page') {
					$prefixt = "Page - ";
				}
				
				$id = "pag_" . $entry->ID;
				$title = $prefixt . $entry->post_title;
			} else {
				if ($value ['subtype'] != 'category' && $value ['subtype'] != 'page') {
					$prefixt = "Category - ";
				}
				
				$id = "cat_" . $entry->term_id;
				$title = $prefixt . $entry->name;
			}
			
			if ($_REQUEST ['page'] == 'seoplugins' || basename ( $_SERVER ['PHP_SELF'] ) == "categories.php") {
				if (seoplugins_option_exist ( $value ['id'] . '_' . $i ))
					$val = get_option ( $value ['id'] . '_' . $i );
			} else {
				if (seoplugins_meta_exist ( $value ['id'] . '_' . $i ))
					$val = get_post_meta ( $post->ID, $value ['id'] . '_' . $i, true );
			}
			
			if ($val == $id) {
				$selected = "selected='selected'";
			} else {
				$selected = "";
			}
			
			$output .= "<option $selected value='" . $id . "'>" . $title . "</option>";
		}
		
		$output .= '</select>';
	}
	
	if (isset ( $settings_hidden_name ))
		$value ['std'] = $settings_hidden_name;
	
	$output .= '<input name="' . $hidden_name . '" class="' . $hidden_name . '" type="hidden" value="' . $settings_hidden_name . '" />';
	
	$output .= '</div>';
	
	return $output;

}  // END seoplugins_multi ()