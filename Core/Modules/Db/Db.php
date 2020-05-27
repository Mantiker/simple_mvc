<?php

namespace Core\Modules\Db;

use Core\App;

class Db
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var \PDO
     */
    private $db;

    public function __construct($params, $debug = false)
    {
        $this->params = $params;
        $this->debug = $debug;
    }

    public function connection()
    {
        if (empty($this->params)) {
            return null;
        }

        try {
            $this->db = new \PDO('mysql:host=' . $this->params['hostname'] . ';dbname=' . $this->params['dbname'],
                $this->params['username'],
                $this->params['password']);

            $this->db->query('SET NAMES utf8');
            $this->db->query('SET CHARACTER_SET utf8_unicode_ci');

            if ($this->debug) {
                $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
        } catch (\PDOException $e) {
            if ($this->debug) {
                echo 'Ошибка БД: ' . $e->getMessage();
            } else {
                // TODO: logging
            }
        }

        return $this->db;
    }
}