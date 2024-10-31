<?php
function seoplugins_upload($option) {
	global $post;
	
	$upload = $option ['std'];
	$id = $option ['id'];
	$type = $option ['type'];
	
	if (basename ( $_SERVER ['PHP_SELF'] ) == "page.php" || basename ( $_SERVER ['PHP_SELF'] ) == "page-new.php" || basename ( $_SERVER ['PHP_SELF'] ) == "post-new.php" || basename ( $_SERVER ['PHP_SELF'] ) == "post.php" || basename ( $_SERVER ['PHP_SELF'] ) == "media-upload.php") {
		
		if ($type == 'slider')
			$uploader .= '<input type="hidden" id="' . $id . '_type" name="' . $id . '_type" value="upload" /> ';
		else
			$upload = get_post_meta ( $post->ID, $id, true );
	
	} elseif (seoplugins_option_exist ( $id )) {
		
		$upload = get_option ( $id );
	
	}
	
	//$uploader = '<br />';
	

	if (! empty ( $upload ) and $type == 'upload') {
		$val = $upload;
	}
	
	$uploader .= '<input class="upload-input-text" name="' . $id . '" id="' . $id . '_upload" type="text" value="' . $val . '" />';
	
	$uploader .= '<div class="upload_button_div"><a href="#" class="button upload_button" id="' . $id . '">Upload Image</a> ';
	
	if (! empty ( $upload ) and $type == 'upload') {
		$hide = '';
	} else {
		$hide = 'hide';
	}
	
	$uploader .= '<a href="#" class="button reset_button ' . $hide . '" id="reset_' . $id . '" title="' . $id . '">Remove</a> ';
	$uploader .= '<a href="#" class="uploadtext" id="uploadtext_' . $id . '" ></a>';
	$uploader .= '</div>' . "\n";
	$uploader .= '<div class="clear"></div>' . "\n";
	
	$uploader .= '<a id="uploaded_image_' . $id . '" href="' . $upload . '" target="_blank">';
	if (! empty ( $upload ) and $type == 'upload') {
		$uploader .= '<img id="image_' . $id . '" src="' . home_url() . '/wp-content/plugins/' . PLUGIN_NAME . '/' . '/thumb.php?src=' . $upload . '&w=120" alt="" target="_blank" />';
	}
	$uploader .= '</a>';
	$uploader .= '<div class="clear"></div>' . "\n";
	
	return $uploader;

} // END seoplugins_upload


add_action ( 'wp_ajax_smart_ajax_post_action', 'smart_ajax_upload_callback' );

function smart_ajax_upload_callback() {
	global $wpdb, $seoplugins;
	
	$clickedID = $_POST ['data']; // Acts as the name
	

	//get options depending of page
	if ($_POST ['page'] == 'post.php' || $_POST ['page'] == 'post-new.php') {
		$options = get_option ( "{$seoplugins->prefix}_post_options" );
	} elseif ($_POST ['page'] == 'page.php' || $_POST ['page'] == 'page-new.php') {
		$options = get_option ( "{$seoplugins->prefix}_page_options" );
	} elseif ($_POST ['page'] == 'admin.php') {
		$options = get_option ( "{$seoplugins->prefix}_admin_options" );
	} else
		$options = array ();
	
	foreach ( $options as $option ) {
		if ($option ['id'] == $clickedID) {
			$slider_options = $option;
			break;
		}
	}
	
	//Upload
	if ($_POST ['type'] == 'upload') {
		
		$override ['test_form'] = false;
		$override ['action'] = 'wp_handle_upload';
		
		$filename = $_FILES [$clickedID];
		
		$uploaded_file = wp_handle_upload ( $filename, $override );
		
		$upload_tracking [] = $clickedID;
		
		if (! empty ( $uploaded_file ['error'] )) {
			echo json_encode ( array ("error" => "Upload Error: " . $uploaded_file ['error'] ) );
		} else {
			
			echo json_encode ( array ("url" => $uploaded_file ['url'], "fields" => $slider_options ) );
		
		} // Is the Response
	

	} 

	elseif ($_POST ['type'] == 'image_reset') {
		
		if (! isset ( $_POST ['referer'] ))
			delete_option ( $clickedID );
		else
			delete_post_meta ( $_POST ['referer'], $clickedID, get_post_meta ( $_POST ['referer'], $clickedID, true ) );
	}
	
	die ();

} //END smart_ajax_upload_callback()


?>