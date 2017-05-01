<?php

class UserController {

    public function indexAction() {
        $v = new View('user.index', 'frontend');
    }

    public function addAction() {
        $v = new View('user.add', 'frontend');
    }
}