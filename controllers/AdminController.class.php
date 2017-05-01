<?php
class AdminController{
    public function indexAction(){
        $v = new View('admin.index','backend');

        $yolo = "Test";
        $v->assign($yolo);
    }

    public function profilAction(){
        $v = new View('admin.profil','backend');
    }
}
