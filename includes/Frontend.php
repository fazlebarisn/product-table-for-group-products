<?php

namespace Woo\Faq;

class Frontend{

    function __construct()
    {
        new Frontend\FaqHtml();
        new Frontend\Enqueue();
    }

}