<?php
class GlobalController{
    
    public static function flash(){
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
            echo $flash;
            unset($_SESSION['messages']);
        }
    }
}
