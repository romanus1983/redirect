<?php

namespace App\Core;

class BaseController {
    protected $db;
    protected $redis;
    protected $config;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->redis = Redis::getInstance();
        $this->config = Config::getInstance();
    }

    protected function render($view, $data = []) {
        extract($data);
        require_once __DIR__ . '/../Modules/Links/Views/' . $view . '.php';
    }

    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
