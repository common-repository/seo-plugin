<?php

//----------------------------------------------------------------------------//	

// Save text fields
function seoplugins_save_text($option) {

	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && basename($_REQUEST['_wp_http_referer']) == "categories.php") {
		//when add new category
		$_POST[$option['id']] = stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		update_option( $option['ids'] , $_POST[$option['id']]);

	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['page'] == 'seoplugins') {
		//edit categoru and admin panel
		$_POST[$option['id']] = stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		update_option( $option['id'] , $_POST[$option['id']]);
	        
	} else {
	
		$data 		= stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		$post_id 	= $_POST['post_ID'];	
		update_post_meta($post_id , $option['id'], $data);	
		
	}
		
}   //END seoplugins_save_text()


//----------------------------------------------------------------------------//	

// Save default fields
function seoplugins_save_default($option) {

	//$_POST[$option['id']] = stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
	
	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && basename($_REQUEST['_wp_http_referer']) == "categories.php") {
		//when add new category
		$_POST[$option['id']] = stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		update_option( $option['ids'] , $_POST[$option['id']]);

	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['page'] == 'seoplugins') {
		//edit categoru and admin panel
		$_POST[$option['id']] = stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		update_option( $option['id'] , $_POST[$option['id']]);

	} else {
		// add/edit page/post

		$data 		= stripslashes(htmlentities($_POST[$option['id']], ENT_QUOTES));
		$post_id 	= $_POST['post_ID'];
	 
		//if(get_post_meta($post_id , $option['id']) == "")
		//add_post_meta($post_id , $option['id'], $data, true);
		
		//elseif($data != get_post_meta($post_id , $option['id'], true))
		
		update_post_meta($post_id , $option['id'], $data);
		
		//elseif($data == "")
		//delete_post_meta($post_id , $option['id'], get_post_meta($post_id , $option['id'], true));
	
	}
		
}   //END seoplugins_save_default()
    
    
//----------------------------------------------------------------------------//


// Save checkbox
function seoplugins_save_checkbox($option) {

	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && basename($_REQUEST['_wp_http_referer']) == "categories.php") {
		//when add new category
		if(isset( $_POST[$option['id']] )) { update_option( $option['ids'], $_POST[$option['id']] ); } else { update_option($option['ids'], 'false' ); }

	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['page'] == 'seoplugins') {
		//edit categoru and admin panel
		if(isset( $_POST[$option['id']] )) { update_option( $option['id'], $_POST[$option['id']] ); } else { update_option($option['id'], 'false' ); }
		     
	} else {
		
		if(isset($_POST[$option['id']])) { $data = $_POST[$option['id']]; } else { $data = 'false'; }
	
		update_post_meta($_POST['post_ID'] , $option['id'], $data);
	
	}
		
}   //END seoplugins_save_checkbox()
    

//----------------------------------------------------------------------------//

// Save checkbox
function seoplugins_save_boxes($option) {

	$id_count = $option['id'].'_count';  
	update_option( $id_count, $option['count']);
	
	for( $k=1; $k<=$option['count']; $k++){
		 
		$id_page = $option['id'].$k.'_page';
		$id_post = $option['id'].$k.'_post';
		$id_box  = $option['id'].$k; 
		
 		if(isset( $_REQUEST[$id_box])){update_option( $id_box, htmlentities($_REQUEST[ $id_box] ));} else { delete_option( htmlentities( $id_box )); } 
		if(isset( $_REQUEST[$id_page]) && $_REQUEST[$id_page] !='' ){update_option( $id_page, htmlentities($_REQUEST[ $id_page] ));} else { delete_option( htmlentities( $id_page )); } 
		if(isset( $_REQUEST[$id_post]) && $_REQUEST[$id_post] !='' ){update_option( $id_post, htmlentities($_REQUEST[ $id_post] ));} else { delete_option( htmlentities( $id_post )); } 
	}
		
}   //END seoplugins_save_boxes()


    
//----------------------------------------------------------------------------//   

// Save multicheckbox
function seoplugins_save_multicheck($option) {

	$id = $option['id'];
	
	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && basename($_REQUEST['_wp_http_referer']) == "categories.php") {
		
		//when add new category
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt  = $option['id']  . '_' . $key;
			$up_opts = $option['ids'] . '_' . $key;
			if(isset( $_POST[$up_opt] )) { update_option( $up_opts, $_POST[$up_opt] ); } else { update_option( $up_opts, 'false' ); }
		}

	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['page'] == 'seoplugins') {
	
		//edit category and admin panel
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt = $id . '_' . $key;
			if(isset( $_POST[$up_opt] )) { update_option( $up_opt, $_POST[$up_opt] ); } else { update_option( $up_opt, 'false' ); }
		}
  
	} else {
	
		$post_id 	= $_POST['post_ID'];
		
		foreach($option['options'] as $key => $value) {
			if ($key === 0) continue;
			$up_opt = $id . '_' . $key;
			if(isset($_POST[$up_opt])) { $data = $_POST[$up_opt]; } else { $data = 'false'; }
			update_post_meta($post_id , $up_opt, $data);
		}

	}
		
}   //END seoplugins_save_multicheck()
    
    
//----------------------------------------------------------------------------// 

function seoplugins_save_multi($option) {

	$id = $option['id'];
	$mhidden =$_REQUEST[$id . '_hidden']; 

	if (basename( $_SERVER['PHP_SELF']) == "admin-ajax.php" && basename($_REQUEST['_wp_http_referer']) == "categories.php") {

		$ids = $option['ids'];
	
		for($i = 0; $i < $mhidden; $i++)
		{
			update_option( $ids."_".$i, $_REQUEST[$id."_".$i] );	
		}
		
		//delete old data that not ben send this time
		while(seoplugins_option_exist($ids."_".$i) ) { 
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_option( $ids."_".$i );
			$i++; 
		}
		
		update_option( $ids . '_hidden', $_REQUEST[$id . '_hidden'] );

	} elseif (basename($_SERVER['PHP_SELF']) == "categories.php" || $_REQUEST['page'] == 'seoplugins') {
	
		for($i = 0; $i < $mhidden; $i++)
		{
			update_option( $id."_".$i, $_REQUEST[$id."_".$i] );	
		}
		
		//delete old data that not ben send this time
		while(seoplugins_option_exist($id."_".$i) ) { 
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_option( $id."_".$i );
			$i++; 
		}
		
		update_option( $id . '_hidden', $_REQUEST[$id . '_hidden'] );
  
	} else {
	
		$post_id 	= $_POST['post_ID'];
		
		for($i = 0; $i < $mhidden; $i++)
		{
			update_post_meta($post_id , $id."_".$i, $_REQUEST[$id."_".$i]);	
		}
		$i=1;

		//delete old data that not ben send this time
		while(seoplugins_meta_exist($id."_".$i, $post_id) ) { //update_post_meta($post_id , $id . '_aaaaaa'.$i, $id."_".$i );
			if( !isset( $_REQUEST[$id."_".$i]) ) delete_post_meta($post_id , $id."_".$i, get_post_meta($post_id , $id."_".$i, true));
			$i++; 
		} 

		update_post_meta($post_id , $id.'_hidden', $_REQUEST[$id.'_hidden']);

	}
		
}   //END seoplugins_save_multi()
    
    
//----------------------------------------------------------------------------// 

function seoplugins_save_slider($option) {

	$id = $option['id'];
	$slider_type = $_REQUEST[$id . '_type'];
	
	//if slider type is post, save tags
	if($slider_type == 'posts') {
		$nr_of_tags = $_REQUEST[$id . '_posts_tags_hidden'];
		
		$tagsArray = array();
		for($k=0; $k<=$nr_of_tags; $k++) {
			$newTAG = $_REQUEST[$id."_posts_tags_".$k]; 
			if (!in_array($newTAG, $tagsArray) && $newTAG!='' && $newTAG!='0')  $tagsArray[] = $newTAG;
		}	

		update_option( $id.'_type', $slider_type );
		update_option( $id.'_posts_tags', implode(',', $tagsArray) );

	}
	
	
	//if slider type is categories, save categories
	if($slider_type == 'categories') { 
		$nr_of_categories = $_REQUEST[$id . '_cat_hidden'];
		
		$categoriesArray = array();
		for($k=0; $k<=$nr_of_categories; $k++) {
			$newCAT = $_REQUEST[$id."_cat_".$k]; 
			if (!in_array($newCAT, $categoriesArray) && $newCAT!='' && $newCAT!='0')  $categoriesArray[] = $newCAT;
		}							

		update_option( $id.'_type', $slider_type );
		update_option( $id.'_categories', implode(',', $categoriesArray) );
 
	}
	
	
	//UPLOAD
	if($slider_type == 'upload') { 
	
		$uploaded_imgs = $_REQUEST[$id . '_sliderdata']; 
		$k = 0;
		if($uploaded_imgs) {
			foreach($uploaded_imgs as $image) {
				$k++;
				$image_data_name = $id . '_sliderdata_' . $k;
				
				foreach($option['fields'] as $field ) {
					$field_id = $field['id'];
					$field_desc = $field['desc'];
					$image[$field_id] = stripslashes(htmlentities($image[$field_id], ENT_QUOTES));
					$field_val = $image[$field_id];
					if($field_val == $field_desc) $image[$field_id] = '';
				}
				
				

				//save images to db
				if(basename($_SERVER['PHP_SELF']) == 'post.php' || basename($_SERVER['PHP_SELF']) == 'page.php' ) {
					update_post_meta($_POST['post_ID'], $image_data_name, $image);
				} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
					update_option( $image_data_name, $image );
				}
	
			}	
		} else {
			//delete old data that not ben send this time
			$i = 1;
			//$_POST['post_ID'] = stripslashes(htmlentities($_POST['post_ID'], ENT_QUOTES));
			
			if(basename($_SERVER['PHP_SELF']) == 'post.php' || basename($_SERVER['PHP_SELF']) == 'page.php' ) {
			
				while(seoplugins_meta_exist($id . '_sliderdata_' . $i, $_POST['post_ID']) ) { 
					if( !isset( $_REQUEST[$id . '_sliderdata_' . $i]) ) delete_post_meta($_POST['post_ID'] , $id . '_sliderdata_' . $i, get_post_meta($_POST['post_ID'] , $id . '_sliderdata_' . $i, true));
					$i++; 
				}
	
			} elseif ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
			
				while(seoplugins_option_exist($id . '_sliderdata_' . $i) ) {
					if( !isset( $_REQUEST[$id . '_sliderdata_' . $i]) ) delete_option( $id . '_sliderdata_' . $i );
					$i++; 
				}
				
			}	

		}
		
		if ( basename($_SERVER['PHP_SELF']) == 'admin.php' ) {
			update_option( $id.'_img_count', $k );
			update_option( $id.'_type', $slider_type );
		}
		
	}

	
		
}   //END seoplugins_save_slider()
    
    
//----------------------------------------------------------------------------//

?>