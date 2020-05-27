<?php

namespace Core;

use Core\Modules\Db\Db;
use Core\Modules\Router\Router;

class App
{
    public static $path = [];

    public static $config = [];

    public static $db;

    public function __construct()
    {
        // basic path
        $this->setBasicPaths();

        // configurator
        $this->setConfig();

        // debug mode
        $this->setDebugMode();

        // db connect
        $this->setDbConnect();

        // router - launch app controller
        new Router();
    }

    private function setBasicPaths()
    {
        self::$path['base_dir'] = $_SERVER['DOCUMENT_ROOT'] . '/../';
        self::$path['config_dir'] = self::$path['base_dir'] . '/config/';
        self::$path['public_dir'] = self::$path['base_dir'] . '/public/';
        self::$path['views_dir'] = self::$path['base_dir'] . '/App/Views/';
    }

    private function setConfig()
    {
        $config_files = scandir(self::$path['config_dir']);

        foreach ($config_files as $config_file) {
            // this can't be a directory and can be file with extension php
            if (!in_array($config_file, [".", ".."])
                && !is_dir(self::$path['config_dir'] . $config_file)
                && pathinfo($config_file, PATHINFO_EXTENSION) === 'php') {

                self::$config[pathinfo($config_file, PATHINFO_FILENAME)] = include self::$path['config_dir'] . $config_file;
            }
        }
    }

    /**
     * Set debug mode from self::$config['app']
     */
    private function setDebugMode()
    {
        if (self::$config['app']['debug']) {
            ini_set('display_errors', 1);
            ini_set('error_reporting', E_ALL);
        } else {
            ini_set('display_errors', 0);
            ini_set('error_reporting', 0);
        }
    }

    /**
     * Set db connection. Use self::$config['datebase']
     */
    private function setDbConnect()
    {
        $db = new Db(self::$config['datebase']);
        self::$db = $db->connection();
    }
}