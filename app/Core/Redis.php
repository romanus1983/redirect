<?php

namespace App\Core;

class Redis {
    private static $instance = null;
    private $redis;
    private $config;

    private function __construct() {
        $this->config = Config::getInstance();
        $redisConfig = $this->config->get('redis');
        
        $this->redis = new \Redis();
        $this->redis->connect(
            $redisConfig['host'],
            $redisConfig['port']
        );
        
        if (!empty($redisConfig['password'])) {
            $this->redis->auth($redisConfig['password']);
        }
        
        if (!empty($redisConfig['database'])) {
            $this->redis->select($redisConfig['database']);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($key) {
        $value = $this->redis->get($key);
        return $value ? json_decode($value, true) : null;
    }

    public function set($key, $value, $ttl = null) {
        $value = json_encode($value);
        if ($ttl) {
            return $this->redis->setex($key, $ttl, $value);
        }
        return $this->redis->set($key, $value);
    }

    public function delete($key) {
        return $this->redis->del($key);
    }
}
