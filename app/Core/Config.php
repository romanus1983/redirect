<?php

namespace App\Core;

class Config {
    private static $instance = null;
    private $config = [];

    private function __construct() {
        $this->loadConfig();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadConfig() {
        // Загружаем конфигурацию из .env
        $envFile = __DIR__ . '/../../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                    list($key, $value) = explode('=', $line, 2);
                    $this->config[trim($key)] = trim($value);
                }
            }
        }

        // Загружаем конфигурацию из файлов модулей
        $configFiles = [
            'app' => __DIR__ . '/../Modules/Links/Config/app.php',
            'database' => __DIR__ . '/../Modules/Links/Config/database.php',
            'redis' => __DIR__ . '/../Modules/Links/Config/redis.php'
        ];

        foreach ($configFiles as $key => $file) {
            if (file_exists($file)) {
                $this->config[$key] = require $file;
            }
        }
    }

    public function get($key, $default = null) {
        return $this->config[$key] ?? $default;
    }
}
