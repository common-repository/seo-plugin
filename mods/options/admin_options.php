<?php

function admin_option_fields() {
    global $admin_options, $seoplugins;
    $prefix = $seoplugins->prefix;

    $admin_options = array();

     /* Tab */
   $admin_options[] = array(
        "name" => "Settings",
        "type" => "tab",
        "id" => "seoConfig"
    );
   
   $admin_options[] = array(
        "name" => "Autocheck current post",
        "desc" => "",
        "id" => "{$prefix}" . "_" . "autoCheck",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "Autocheck seconds",
        "desc" => "Accept format 1 = 1 second",
        "id" => "{$prefix}" . "_" . "autoCheckTimes",
        "std" => "",
        "type" => "text",
        "width" => "80"
    );
        
    
    $admin_options[] = array(
        "name" => "Title separator",
        "desc" => "Default <b> - </b>",
        "id" => "{$prefix}" . "_" . "separator",
        "std" => "",
        "type" => "text",
        "width" => "120"
    );
        
   $admin_options[] = array(
        "name" => "Seo title position",
        "desc" => "Default <b> Right </b>",
        "id" => "{$prefix}" . "_" . "position",
        "std" => "",
        "type" => "select",
        "options" => array('Left', 'Right')
    );  
        
    $admin_options[] = array(
        "name" => "Show seoplugins score",
        "desc" => "Show score in item listing",
        "id" => "{$prefix}" . "_" . "showScoreSeo",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "On plugin deactivate",
        "desc" => "Remove all current settings on plugin deactivate. Reset to default.",
        "id" => "{$prefix}" . "_" . "deactivate_remove",
        "std" => "",
        "type" => "checkbox"
    );
   
    /* Tab */
    $admin_options[] = array(
        "name" => "SEO rules and settings",
        "type" => "tab",
        "id" => "SeoRules"
    );

    $admin_options[] = array(
        "name" => "Keyword in title tag",
        "desc" => "o Keyword in Title tag - close to beginning <br />
o Title tag 10 - 60 characters, no special characters",
        "id" => "{$prefix}" . "_" . "keyword_title_tag",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "Keywords in description",
        "desc" => "o Less than 200 chars. <br />
o Google no longer relies upon this tag, but frequently uses it.",
        "id" => "{$prefix}" . "_" . "keyword_meta_description",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "Keywords in keywords",
        "desc" => " Less than 10 words.<br />
o Every word in this tag MUST appear somewhere in the body. If not, it will
be penalized for irrelevance. <br />
o NO single word should appear more than twice in the Meta tag as it is
considered spam. <br />
o Google purportedly no longer values this tag, but others do.",
        "id" => "{$prefix}" . "_" . "keyword_meta_keywords",
        "std" => "",
        "type" => "checkbox"
    );    
        
    $admin_options[] = array(
        "name" => "Check density of keyword",
        "desc" => "Default <b>check</b>",
        "id" => "{$prefix}" . "_" . "keyword_meta_density",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "Keyword density",
        "desc" => "Individual keyword density 6% - (each keyword/total words)",
        "id" => "{$prefix}" . "_" . "keyword_density",
        "std" => "",
        "type" => "text",
        "width" => '120'
    );
      
    $admin_options[] = array(
        "name" => "Keywords in H1",
        "desc" => "",
        "id" => "{$prefix}" . "_" . "keyword_meta_H1",
        "std" => "",
        "type" => "checkbox"
    );
        
    $admin_options[] = array(
        "name" => "Keywords in H2",
        "desc" => "",
        "id" => "{$prefix}" . "_" . "keyword_meta_H2",
        "std" => "",
        "type" => "checkbox"
    );
      
   $admin_options[] = array(
        "name" => "Keywords in H3",
        "desc" => "",
        "id" => "{$prefix}" . "_" . "keyword_meta_H3",
        "std" => "",
        "type" => "checkbox"
    );     
        
    $admin_options[] = array(
        "name" => "Keywords in fontsize",
        "desc" => "Keyword font size - In strong, bold, italic, strong.",
        "id" => "{$prefix}" . "_" . "keyword_meta_fontsize",
        "std" => "",
        "type" => "checkbox"
    );   
        
    $admin_options[] = array(
        "name" => "Keyword in alt text",
        "desc" => "Should describe graphic - Do NOT fill with spam",
        "id" => "{$prefix}" . "_" . "keyword_meta_img_alt",
        "std" => "",
        "type" => "checkbox"
    );
        
    /* END admin_option_fields() */
    update_option("{$seoplugins->prefix}_admin_options", $admin_options);
}