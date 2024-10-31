<?php 

function seoplugins_admin_head() {  
    global $seoplugins;
    $prefix = $seoplugins->prefix;
?>
	<link href="<?php echo ADMIN_CSS ?>/style.css" rel="stylesheet" type="text/css" media="screen" /> 
	<link href="<?php echo ADMIN_CSS ?>/ui.all.css" rel="stylesheet" type="text/css" media="screen" /> 
	
	
	<script src="<?php echo ADMIN_JS ?>/ui.core.js" type="text/javascript" ></script>
	<script src="<?php echo ADMIN_JS ?>/ajaxupload.js" type="text/javascript" ></script>
	<script src="<?php echo ADMIN_JS ?>/jquery.cookie.js" type="text/javascript" ></script>
	<script src="<?php echo ADMIN_JS ?>/ui.tabs.js" type="text/javascript" ></script>
	
	<script src="<?php echo ADMIN_JS ?>/js.js" type="text/javascript" ></script>
    <script src="<?php echo ADMIN_JS ?>/seoplugins.js" type="text/javascript" ></script>
    
    <script type="text/javascript">
    jQuery(document).ready(function() {
        seoplugins.init({
           uri: '<?php echo PLUGIN_URI;?>',
           seoSettings: {
               autoCheck                    : '<?php echo get_option($prefix . '_' . 'autoCheck');?>',
               autoCheckTimes               : '<?php echo get_option($prefix . '_' . 'autoCheckTimes');?>',
               rulesCheck : {
                   keyword_title_tag            : '<?php echo get_option($prefix . '_' . 'keyword_title_tag');?>',
                   keyword_meta_description     : '<?php echo get_option($prefix . '_' . 'keyword_meta_description');?>',
                   keyword_meta_keywords        : '<?php echo get_option($prefix . '_' . 'keyword_meta_keywords');?>',
                   keyword_meta_density         : '<?php echo get_option($prefix . '_' . 'keyword_meta_density');?>',
                   keyword_density              : '<?php echo get_option($prefix . '_' . 'keyword_density');?>',
                   keyword_meta_H1              : '<?php echo get_option($prefix . '_' . 'keyword_meta_H1');?>',
                   keyword_meta_H2              : '<?php echo get_option($prefix . '_' . 'keyword_meta_H2');?>',
                   keyword_meta_H3              : '<?php echo get_option($prefix . '_' . 'keyword_meta_H3');?>',
                   keyword_meta_fontsize        : '<?php echo get_option($prefix . '_' . 'keyword_meta_fontsize');?>',
                   keyword_meta_img_alt         : '<?php echo get_option($prefix . '_' . 'keyword_meta_img_alt');?>'
               }
           }
        });
    });
    </script>
<?php 
}//END seoplugins_admin_head()