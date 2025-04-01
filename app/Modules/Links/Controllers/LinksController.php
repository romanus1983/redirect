<?php

namespace App\Modules\Links\Controllers;

use App\Core\BaseController;
use App\Modules\Links\Models\Link;

class LinksController extends BaseController {
    private $linkModel;

    public function __construct() {
        parent::__construct();
        $this->linkModel = new Link();
    }

    public function index() {
        $links = $this->linkModel->getAll();
        $this->render('index', ['links' => $links]);
    }

    public function create() {
        $this->render('create');
    }

    public function store() {
        $url = $_POST['url'] ?? '';
        $code = $_POST['code'] ?? '';
        
        if (empty($url) || empty($code)) {
            $this->redirect('/links/create?error=1');
        }

        $this->linkModel->create([
            'url' => $url,
            'code' => $code,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->redirect('/links');
    }

    public function edit($id) {
        $link = $this->linkModel->getById($id);
        if (!$link) {
            $this->redirect('/links?error=1');
        }
        $this->render('edit', ['link' => $link]);
    }

    public function update($id) {
        $url = $_POST['url'] ?? '';
        $code = $_POST['code'] ?? '';
        
        if (empty($url) || empty($code)) {
            $this->redirect('/links/' . $id . '/edit?error=1');
        }

        $this->linkModel->update($id, [
            'url' => $url,
            'code' => $code,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->redirect('/links');
    }

    public function delete($id) {
        $this->linkModel->delete($id);
        $this->redirect('/links');
    }

    public function redirect($code) {
        $link = $this->linkModel->getByCode($code);
        if (!$link) {
            $this->redirect('/404');
        }
        
        $this->linkModel->incrementClicks($link['id']);
        header('Location: ' . $link['url']);
        exit;
    }
}
