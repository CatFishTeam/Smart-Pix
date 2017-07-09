<?php
class IndexController{
    public function test($id){
        echo 'test ' . $id . $_GET['page'];
    }
}
