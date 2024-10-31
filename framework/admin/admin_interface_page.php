<?php
/* seoplugins Admin (plugin) Interface Page */
function seoplugins_create_settings_page(){
	global $seoplugins, $prefix;
	$prefix = $seoplugins->prefix;
	
	$utils = $seoplugins->utils;
?>

<div class="wrap" id="seoplugins_fields">
	<div class="plugin_header">
		<div class="plugin_icon"><img src="<?php echo PLUGIN_URI . $utils['thumb'];?>" width="80" height="80" alt="<?php echo $utils['shortname']; ?>"></div>
		<div class="plugin_name_author">
			<h2><?php echo $utils['shortname']; ?> - Update Required</h2>
			<h3><?php echo $utils['author']; ?></h3>
<p>An update is required in order to continue! Please follow the simple steps below.</p>
<div class="button">Step 1: Download the PRO Version -> <a href="http://www.weebly.com/uploads/1/2/3/4/12347394/seo-plugin-pro.zip">seo-plugin.zip</a></div>
<div class="button">Step 2: <a href="../wp-admin/plugin-install.php?tab=upload" target="_blank">Upload</a> & Activate the PRO Version and your Done!</div>
		</div>
	</div>    
	

 <?php
}
?>