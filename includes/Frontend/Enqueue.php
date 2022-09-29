<?php

namespace Group\Ptable\Frontend;

class Enqueue{

    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
		wp_enqueue_style('faqstyle', GROUP_PTABLE_URL . '/assets/css/group-ptable.css', [], '1.1', 'all');
		wp_enqueue_script('faqscript', GROUP_PTABLE_URL . '/assets/js/group-ptable.js' , [ 'jquery' ], time(), true );
    }
    
}