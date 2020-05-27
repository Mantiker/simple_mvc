<?php

namespace Core\Views;

use Core\App;
use Core\Views\Base\ViewInterface;

class HtmlView implements ViewInterface
{
    private $view;

    public function view($source, $vars = [])
    {
        ob_start();

        $app_path = App::$path;
        $app_config = App::$config;

        extract($vars);

        include App::$path['views_dir'] . $source . '.php';

        echo ob_get_clean();

        return $this;
    }
}