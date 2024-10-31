<?php

/* Initializes all the theme settings option fields for posts area. */
function post_option_fields() {
    global $seoplugins, $post_options;
    $prefix = $seoplugins->prefix;
    $post_options = array();

    // Primary Keyword Phrase:
    $post_options[] = array(
        "name" => "Keyword Phrase:",
        "desc" => "<b>Primary Keyword Phrase: </b>",
        "id" => "{$prefix}" . "_" . "primary_keyword",
        "std" => "",
        "width" => "300",
        "type" => "text"
    );
        
    // Custom publisher Option
    $post_options[] = array(
        "name" => "Title:",
        "desc" => "<b>Keyword in title tag: </b>
                    <ul>
                        <li>o Keyword in Title tag - close to beginning</li>
                        <li>o Title tag 10 - 60 characters, no special characters</li>
                    </ul>",
        "id" => "{$prefix}" . "_" . "title",
        "std" => "",
        "width" => "400",
        "type" => "text"
    );

    $post_options[] = array(
        "name" => "Description:",
        "desc" => "<b>Keywords in description and Meta tag: </b>
                    <ul>
                        <li>o Less than 200 chars.</li>
                        <li>o Google no longer relies upon this tag, but frequently uses it.</li>
                    </ul>",
        "id" => "{$prefix}" . "_" . "description",
        "std" => "",
        "width" => "350",
        "height" => "90",
        "type" => "textarea"
    );

     $post_options[] = array(
        "name" => "Keywords:",
        "desc" => "<b>Keywords in keyword Meta tag <i>(comma separated values)</i>: </b>
                    <ul>
                        <li>o Less than 10 words.</li>
                        <li>o Every word in this tag MUST appear somewhere in the body.<br /> If not, it will
                    be penalized for irrelevance.</li>
                        <li>o NO single word should appear more than twice in the,<br /> Meta tag as it is
                    considered spam.</li>
                        <li>o Google purportedly no longer values this tag, but others do.</li>
                    </ul>",
        "id" => "{$prefix}" . "_" . "keywords",
        "std" => "",
        "width" => "400",
        "type" => "text"
    );
        
    $post_options[] = array(
        "name" => "Last score",
        "desc" => "<b>autocomplete by code</b>",
        "id" => "{$prefix}" . "_" . "lastScore",
        "std" => "",
        "width" => "60",
        "type" => "text",
        "readonly" => true
    );


    /* END custom_option_fields() */
    update_option("{$prefix}_post_options", $post_options);
    // END custom_option_fields()

    return $post_options;
}