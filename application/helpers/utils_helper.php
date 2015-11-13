<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * get a newline free version of html
 * @param type $str
 * @return type
 */
function sline($str) {

    return trim(preg_replace('/\s\s+/', ' ', $str));
}

/**
 * Make array with default pagination config for bootstrap
 * and recommended per page items
 * @param type $array (custom config entry to replace)
 * @return type
 */
function pagination_config($array) {

    $default = array(
        'per_page' => 5,
        'uri_segment' => 3,
        'num_links' => 2,
        'reuse_query_string' => true,
        'full_tag_open' => '<nav class="pull-right"><ul class="pagination">',
        'full_tag_close' => '</nav></ul>',
        'first_tag_open' => '<li>',
        'first_tag_close' => '</li>',
        'last_tag_open' => '<li>',
        'last_tag_close' => '</li>',
        'next_tag_open' => '<li>',
        'next_tag_close' => '</li>',
        'prev_tag_open' => '<li>',
        'prev_tag_close' => '</li>',
        'num_tag_open' => '<li>',
        'num_tag_close' => '</li>',
        'cur_tag_open' => '<li class="active"><a>',
        'cur_tag_close' => '</a></li>',
        'attributes' => array(
            'class' => 'ko_link'
        )
    );

    return array_merge($default, $array);
}

/**
 * Bootstrap form builder
 */
/**
 * 
 * @param type $oldValueArray
 * @param type $item_name
 */
function inputText(&$oldValueArray, $item_name) {
    $val = '';
    $item_decor_name = ucwords(str_replace("_", " ", $item_name));
    
    if (isset($oldValueArray)) {
        $val = $oldValueArray[$item_name];
    }

    echo '<div class="form-group">
            <label class="col-md-4 control-label" for="textinput">'.$item_decor_name.'</label>  
            <div class="col-md-4">
                <input id="'.$item_name.'" name="'.$item_name.'" placeholder="'.$item_decor_name.'" type="text" class="form-control input-md" value="'.$val.'">
                <span class="help-block"></span>  
            </div>
        </div>';
}

function inputButtons(&$oldValueArray, $item_name,$href= '') {
    
    $pk = '';
    $btnDeleteHtml = '';
    if (isset($oldValueArray)) {
        $pk = $oldValueArray[$item_name];
        $btnDeleteHtml = '<a class="ko_link btn btn-danger" href="'.$href.'/'.$pk.'">Delete</a>';
    }
   
    echo '<div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-8">
                <button id="submit" value="submit" name="action" class="btn btn-success">Submit</button>                
                '.$btnDeleteHtml.'
            </div>
        </div>';    
}
