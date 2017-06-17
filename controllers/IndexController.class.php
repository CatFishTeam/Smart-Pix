<?php
class IndexController{
    public function indexAction(){
        $v = new View();
        $pictures = new Picture();
        $pictures = $pictures->getAllBy();
        $v->assign('pictures', $pictures);
    }

}
