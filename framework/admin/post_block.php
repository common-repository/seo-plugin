<?php

/* Use the admin_menu action to define the custom boxes */
add_action('admin_menu', 'seoplugins_custom_box');

/* Adds a custom section to the "side" of the post edit screen */
function seoplugins_custom_box() {
    add_meta_box('seoplugins_post_markers', 'Post SEO Settings', 'seoplugins_post_markers_custom_box', 'post', 'normal', 'high');
    add_meta_box('seoplugins_post_markers', 'Page SEO Settings', 'seoplugins_post_markers_custom_box', 'page', 'normal', 'high');

    /* live scores */
    add_meta_box('seoplugins_livescore_markers', 'seoplugins post score', 'seoplugins_livescore_custom_box', 'post', 'side', 'high');
    add_meta_box('seoplugins_livescore_markers', 'seoplugins page score', 'seoplugins_livescore_custom_box', 'page', 'side', 'high');
}

/* prints the custom field in the new custom post section */
function seoplugins_post_markers_custom_box() {
    //get post meta value
    global $post, $seoplugins;
    $prefix = $seoplugins->prefix;
    
    // use nonce for verification
    echo '<input type="hidden" name="seoplugins_post_markers_noncename" id="seoplugins_post_markers_noncename" value="' . wp_create_nonce('nyc-seoplugins') . '" />';

    foreach (post_option_fields () as $key => $value) {
        if ($value['type'] == 'upload') {
            echo '<div style="width: 100%;float: left; margin: 15px 0px 0px 10px;">';
            echo '<div style="float: left;width: 150px;font-weight: bold;">'.($value['name']).'</div>';
            echo '<div style="float: left;width: 450px;font-weight: bold;">'.(seoplugins_upload($value)).'</div>';
            echo '<div style="float: left"><i>'.($value['desc']).'</i></div>';
            echo '</div>';
        }
        if ($value['type'] == 'text') {
            $value ['std'] = get_post_meta($post->ID, $value['id'], true);
            echo '<div style="width: 100%;float: left;margin: 15px 0px 0px 10px; ">';
            echo '<div style="float: left;width: 150px;font-weight: bold;">'.($value['name']).'</div>';
            echo '<div style="float: left;width: 450px;font-weight: bold;">'.(seoplugins_text($value)).'</div>';
            echo '<div style="float: left"><i>'.($value['desc']).'</i></div>';
            echo '</div>';
        }
        if ($value['type'] == 'textarea') {
            $value ['std'] = get_post_meta($post->ID, $value['id'], true);
            echo '<div style="width: 100%;float: left;margin: 15px 0px 0px 10px; ">';
            echo '<div style="float: left;width: 150px;font-weight: bold;">'.($value['name']).'</div>';
            echo '<div style="float: left;width: 450px;font-weight: bold;">'.(seoplugins_textarea($value)).'</div>';
            echo '<div style="float: left"><i>'.($value['desc']).'</i></div>';
            echo '</div>';
        }
    }
    echo '<div style="clear:both"></div>';
    //echo ;
}

/* when the post is saved, save the custom data */
function seoplugins_post_markers_save_postdata($post_id) {
    global $seoplugins;
    $prefix = $seoplugins->prefix;
    // verify this with nonce because save_post can be triggered at other times
    if (!wp_verify_nonce($_POST['seoplugins_post_markers_noncename'], 'nyc-seoplugins'))
        return $post_id;

    // do not save if this is an auto save routine
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $post_id;

    foreach (post_option_fields () as $key => $value) {
        update_post_meta($post_id, $value['id'], $_POST[$value['id']]);
    }
}

/* prints the custom field in the new custom post section */
function seoplugins_livescore_custom_box() {
    //get post meta value
    global $post, $seoplugins;
    $prefix = $seoplugins->prefix;
?>
<div id="seopluginsChecklist">
    <div id="seopluginsOverlay"><h1>Smart SEO check ...</h1></div>
    <div id="progress_bar" class="ui-progress-bar ui-container">
      <div class="ui-progress" style="width: 0%;">
        <span class="ui-label">Efficiency <b class="value">0%</b></span>
      </div>
    </div>

    <br />
    <h2 style="margin-left:4px;">SEO Checklist</h2>
    <!-- seo checklist !-->
    <table class="widefat post fixed seopluginsTable" cellspacing=0">
        <tbody>
            <tr <?php echo get_option($prefix . '_' . 'keyword_title_tag') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_title_tag" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword in title tag</td>
                <td width="18">
                    <a href="javascript: void(0)" class="tooltip" title="o Keyword in Title tag - close to beginning <br />
o Title tag 10 - 60 characters, no special characters">
                        <img src="<?php echo PLUGIN_URI;?>framework/images/info.png" width="18" height="18" alt="info">
                    </a>
                </td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_description') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_description" width="18" height="18" alt="OK"></td>
                <td valign="center">Keywords in description Meta tag</td>
                <td width="18">
                    <a href="javascript: void(0)" class="tooltip" title="o Less than 200 chars. <br />
o Google no longer relies upon this tag, but frequently uses it.">
                        <img src="<?php echo PLUGIN_URI;?>framework/images/info.png" width="18" height="18" alt="info">
                    </a>
                </td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_keywords') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_keywords" width="18" height="18" alt="OK"></td>
                <td valign="center">Keywords in keyword Meta tag</td>
                <td width="18">
                    <a href="javascript: void(0)" class="tooltip" title="o Less than 10 words.<br />
o Every word in this tag MUST appear somewhere in the body. If not, it will
be penalized for irrelevance. <br />
o NO single word should appear more than twice in the Meta tag as it is
considered spam. <br />
o Google purportedly no longer values this tag, but others do.">
                        <img src="<?php echo PLUGIN_URI;?>framework/images/info.png" width="18" height="18" alt="info">
                    </a>
                </td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_density') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_density" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword density in body text - <strong><?php echo get_option($prefix . '_' . 'keyword_density');?>%</strong> (all keywords/ total words). <div>Current density: <strong id="seoCurretDensity">0%</strong></div></td>
                <td width="18"></td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_H1') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_H1" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword in H1</td>
                <td width="18"></td>
            </tr>
            
            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_H2') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_H2" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword in H2</td>
                <td width="18"></td>
            </tr>
            
            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_H3') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_H3" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword in H3</td>
                <td width="18"></td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_fontsize') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_fontsize" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword font size - In strong, bold, italic, strong.</td>
                <td width="18"></td>
            </tr>

            <tr <?php echo get_option($prefix . '_' . 'keyword_meta_img_alt') != "true" ? 'style="display:none;"' : '';?>>
                <td width="18"><img src="<?php echo PLUGIN_URI;?>framework/images/no.png" id="stats-keyword_meta_img_alt" width="18" height="18" alt="OK"></td>
                <td valign="center">Keyword in alt text</td>
                <td width="18">
                    <a href="javascript: void(0)" class="tooltip" title="o Should describe graphic - Do NOT fill with spam">
                        <img src="<?php echo PLUGIN_URI;?>framework/images/info.png" width="18" height="18" alt="info">
                    </a>
                </td>
            </tr>

            <tr>
                <td valign="center" colspan="3" style="position: relative;"><input type="submit" class="button button-highlighted" value="SEO check" id="seopluginsCheck" name="seopluginsCheck" />
                <span class="seoCountDown"> Recheck in: <strong id="seoTimeMarker">10</strong> <i>seconds</i></span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?php
}

/* use save_post action to handle data entered */
add_action('save_post', 'seoplugins_post_markers_save_postdata');

