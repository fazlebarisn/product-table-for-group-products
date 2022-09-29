<?php

namespace Group\Ptable;

class Admin{

    function __construct()
    {
        new Admin\Enqueue();
        new Admin\AdminNotice();
    }
    
}
