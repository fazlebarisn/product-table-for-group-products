<?php

namespace Group\Ptable\Admin;

class Enqueue{

    function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue'] );
    }

	function enqueue(){
		wp_enqueue_style('faq-admin-style', WOO_FAQ_URL . '/assets/css/admin-group-ptable.css', [], '1.1', 'all');
		wp_enqueue_script('faq-admin-script', WOO_FAQ_URL . '/assets/js/admin-group-ptable.js' , [ 'jquery' ], time(), true );
    }
    
}