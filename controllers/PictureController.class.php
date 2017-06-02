<?php

class PictureController {

    /*
     * Page d'une image (/picture/{id})
     * Si $id non fourni => listing des images sur le site
     */
    public function indexAction($id) {
        $v = new View('picture.index', 'frontend');
        if (empty($id)) {
            // Listing des images

        } else {
            // Affichage d'une image avec $id
            $picture = new Picture();
            $picture = $picture->populate(['id' => $id[0]]);
            $v->assign('picture', $picture);
        }
    }

    /*
     * Ajout d'une image par un user (/picture/create)
     */
    public function createAction() {

    }

}