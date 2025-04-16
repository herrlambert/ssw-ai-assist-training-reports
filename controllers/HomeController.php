<?php
class HomeController {
    public function index() {
        require_once APP_ROOT . '/models/Message.php';
        $message = new Message();
        $data = ['message' => $message->getHelloMessage()];
        
        require_once APP_ROOT . '/views/home/index.php';
    }
}