<?php
class IndexController{
    public function indexAction(){
        $v = new View();
        $pictures = new Picture();
        $pictures = $pictures->getAllBy([], 'DESC');
        $v->assign('pictures', $pictures);
        var_dump($pictures);
    }

    public function test($id){
        echo 'test ' . $id . $_GET['page'];
    }

}
