<?php
class GlobalController{
    public function __construct(){
        if(isset($_SESSION['messages'])){
            $flash = '<div class="flash-container">';
            foreach ($_SESSION['messages']['warning'] as $message) {
                $flash .=
                "<div class='flash flash-warning'>
                    <div class='flash-cell'>".$message."</div>
                </div>";
            }
            $flash .= '</div>';
            echo $flash;
            unset($_SESSION['messages']);
        }

    }
}
