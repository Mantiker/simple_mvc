<?php

namespace Core\Controllers\Base;

use Core\Views\HtmlView;

class BaseController
{
    /**
     * @var HtmlView
     */
    protected $html;

    public function __construct(HtmlView $html)
    {
        $this->html = $html;
    }
}