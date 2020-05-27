<?php

namespace App\Controllers;

use Core\Controllers\Base\BaseController;

class IndexController extends BaseController
{
    public function index()
    {
        return $this->html->view('index');
    }
}