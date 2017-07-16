<?php
class GlobalController{

    public static function flash($type = null){
        if(isset($_SESSION['messages'])){
            $flash = '<div class="flash-container">';
            foreach ($_SESSION['messages'] as $key => $messages) {
                $flash .= '<div class="flash flash-'.$key.'">';
                foreach ($messages as $message) {
                    $flash .= '<div class="flash-cell">'.$message.'</div>';
                }
                $flash .= '</div>';
            }
            $flash .= '</div>';

            if($type == 'json'){
                echo json_encode($flash);
            }else {
                echo $flash;
            }
            unset($_SESSION['messages']);
        }
    }
}
