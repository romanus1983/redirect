<?php

namespace App\Modules\Links\Models;

use App\Core\Database;
use App\Core\Redis;

class Link {
    private $db;
    private $redis;
    private $table = 'links';

    public function __construct() {
        $this->db = Database::getInstance();
        $this->redis = Redis::getInstance();
    }

    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->query($sql, [$id])->fetch();
    }

    public function getByCode($code) {
        $cacheKey = "link:{$code}";
        $link = $this->redis->get($cacheKey);
        
        if (!$link) {
            $sql = "SELECT * FROM {$this->table} WHERE code = ?";
            $link = $this->db->query($sql, [$code])->fetch();
            if ($link) {
                $this->redis->set($cacheKey, $link, 3600);
            }
        }
        
        return $link;
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (url, code, created_at) VALUES (?, ?, ?)";
        return $this->db->query($sql, [$data['url'], $data['code'], $data['created_at']]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET url = ?, code = ?, updated_at = ? WHERE id = ?";
        return $this->db->query($sql, [$data['url'], $data['code'], $data['updated_at'], $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }

    public function incrementClicks($id) {
        $sql = "UPDATE {$this->table} SET clicks = clicks + 1 WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}
