<?php

namespace Group\Ptable\Frontend;

class Enqueue{

    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
		wp_enqueue_style('gp-table-style', GROUP_PTABLE_URL . '/assets/css/group-ptable.css', [], '1.1', 'all');
		wp_enqueue_script('gp-table-script', GROUP_PTABLE_URL . '/assets/js/group-ptable.js' , [ 'jquery' ], time(), true );
    }
    
}