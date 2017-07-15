<?php

class CommunityController{
    public function checkName(){
        $name = $_POST['name'];
        $community = new Community;
        $community = $community->populate(['name' => $name]);
        // $user = $user->populate(array('username' => $_SESSION['username']));
        if($community){
            echo json_encode('error');
        } else {
            echo json_encode('good');
        }
    }
}
