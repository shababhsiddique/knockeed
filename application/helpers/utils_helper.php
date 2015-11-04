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
