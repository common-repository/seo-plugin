<?php
error_reporting(0);

require_once(realpath('classes/seo.php'));
$seoplugins = seoplugins::getInstance();


$recives = array(
    'keyword'            => $_REQUEST['primary_keyword'],
    'meta_title'         => $_REQUEST['meta_title'],
    'meta_description'   => $_REQUEST['meta_description'],
    'meta_keywords'      => $_REQUEST['meta_keywords'],
    'content'            => $_REQUEST['content']
);

// defautl set all to false
$scoreArray = array(
    'keyword_title_tag' => 0,
    'keyword_meta_description' => 0,
    'keyword_meta_keywords' => 0,
    'keyword_meta_H1' => 0,
    'keyword_meta_H2' => 0,
    'keyword_meta_H3' => 0,
    'keyword_meta_fontsize' => 0,
    'keyword_meta_img_alt'  => 0
);

if(trim($recives['keyword']) == ""){
    // print as json
    echo json_encode($scoreArray);
    die;
}

// Keyword in title tag
$__['keyword_title_tag'] = $seoplugins->rule_keyword_in_string($recives['meta_title'], $recives['keyword']);
if($__['keyword_title_tag'] > 0){
    $scoreArray['keyword_title_tag'] = 1;
}

// Keywords in description
$__['keyword_meta_description'] = $seoplugins->rule_keyword_in_string($recives['meta_description'], $recives['keyword']);
if($__['keyword_meta_description'] > 0){
    $scoreArray['keyword_meta_description'] = 1;
}

// Keywords in keywords
$__['keyword_meta_keywords'] = $seoplugins->rule_keyword_in_string($recives['meta_keywords'], $recives['keyword']);
if($__['keyword_meta_keywords'] > 0){
    $scoreArray['keyword_meta_keywords'] = 1;
}

// Keywords in H1
$__['keyword_meta_H1'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'h1');
if($__['keyword_meta_H1'] > 0){
    $scoreArray['keyword_meta_H1'] = 1;
}

// Keywords in H2
$__['keyword_meta_H2'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'h2');
if($__['keyword_meta_H2'] > 0){
    $scoreArray['keyword_meta_H2'] = 1;
}

// Keywords in H3
$__['keyword_meta_H3'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'h3');
if($__['keyword_meta_H3'] > 0){
    $scoreArray['keyword_meta_H3'] = 1;
}

// Keywords in fontsize
$__['keyword_meta_b'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'b');
$__['keyword_meta_bold'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'bold');
$__['keyword_meta_strong'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'strong');
$__['keyword_meta_em'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'em');
if($__['keyword_meta_fontsize'] > 0 ||
        $__['keyword_meta_bold'] > 0 ||
        $__['keyword_meta_strong'] > 0 ||
        $__['keyword_meta_em'] > 0 ||
        $__['keyword_meta_b'] > 0
   ){
    $scoreArray['keyword_meta_fontsize'] = 1;
}

// Keywords in H3
$__['keyword_meta_img_alt'] = $seoplugins->rule_keyword_in_tag($recives['content'], $recives['keyword'], 'img_alt');
if($__['keyword_meta_img_alt'] > 0){
    $scoreArray['keyword_meta_img_alt'] = 1;
}

// Keywords density
$__['keyword_meta_density'] = $seoplugins->count_occurences($recives['content'], $recives['keyword'], false);
$wordsCount = $seoplugins->word_count($recives['content']);
$density = ($__['keyword_meta_density'] / $wordsCount) * 100;
$density = number_format($density, 1);
$scoreArray['keyword_meta_density'] = $density;


// print as json
echo json_encode($scoreArray);