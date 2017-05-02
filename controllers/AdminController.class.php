<?php
class AdminController{
    public function indexAction(){
        $v = new View('admin.index','backend');

        $v->assign("test","yolo");
    }

    public function profilAction(){
        $v = new View('admin.profil','backend');
    }

    public function pagesAction(){
        $v = new View('admin.pages','backend');
        $v->assign("specificHeader","<script src=\"hgfjhgjlkhvk\"></script>");
    }

    public function mediasAction(){
        $v = new View('admin.medias','backend');
    }

    public function settingsAction(){
        $v = new View('admin.settings','backend');
    }

    public function commentsAction(){
        $v = new View('admin.comments','backend');
    }

    public function statsAction(){
        $v = new View('admin.stats','backend');
    }
}
