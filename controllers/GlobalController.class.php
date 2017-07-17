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

    public static function slugify($text)
    {
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);

      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);

      // trim
      $text = trim($text, '-');

      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);

      // lowercase
      $text = strtolower($text);

      if (empty($text)) {
        return 'n-a';
      }

      return $text;
    }

}
