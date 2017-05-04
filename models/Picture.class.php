<?php
class Picture extends BaseSql{

    protected $id = -1;
    protected $album_id;
    protected $user_id;
    protected $title;
    protected $description;
    protected $url;
    protected $is_visible;
    protected $created_at;
    protected $updated_at;

    //TODO : on connect set USER_ID = USER_ID
    // • Check longueur du titre (< 250 + charctère spéciaux + html tag)
    // • If created in an album get album_id
    public function __construct($id='DEFAULT', $album_id=null, $user_id=1, $title=null,$description=null, $url=null, $is_visible='DEFAULT', $created_at='DEFAULT', $updated_at='DEFAULT'){
        parent::__construct(); //Nécessaire
    }

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set the value of AlbumId
     *
     * @param mixed album_id
     *
     * @return self
     */
    public function setAlbumId($album_id)
    {
        $this->album_id = $album_id;

        return $this;
    }

    /**
     * Set the value of UserId
     *
     * @param mixed user_id
     *
     * @return self
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param mixed title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = trim($title);

        return $this;
    }

    /**
     * Get the value of Description
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of Description
     *
     * @param mixed description
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = trim($description);

        return $this;
    }

    /**
     * Get the value of Is Visible
     *
     * @return mixed
     */
    public function getIsVisible()
    {
        return $this->is_visible;
    }

    /**
     * Set the value of Is Visible
     *
     * @param mixed is_visible
     *
     * @return self
     */
    public function setIsVisible($is_visible)
    {
        $this->is_visible = $is_visible;

        return $this;
    }

    /**
     * Get the value of Url
     *
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set the value of Url
     *
     * @param mixed url
     *
     * @return self
     */
    public function setUrl()
    {
        $this->url = parent::clean($this->title.'_'.$this->id);
        return $this;
    }

    /**
     * Get the value of Album Id
     *
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of Created At
     *
     * @param mixed created_at
     *
     * @return self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of Updated At
     *
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of Updated At
     *
     * @param mixed updated_at
     *
     * @return self
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     *
     * Generate Thumbnail using Imagick class
     *
     * @param string $img
     * @param string $width
     * @param string $height
     * @param int $quality
     * @return boolean on true
     * @throws Exception
     * @throws ImagickException
     */
    // public function generateThumbnail($img, $width, $height, $quality = 90)
    // {
    //     if (is_file($img)) {
    //         $imagick = new Imagick(realpath($img));
    //         $imagick->setImageFormat('jpeg');
    //         $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
    //         $imagick->setImageCompressionQuality($quality);
    //         $imagick->thumbnailImage($width, $height, false, false);
    //         $filename_no_ext = reset(explode('.', $img));
    //         if (file_put_contents($filename_no_ext . '_thumb' . '.jpg', $imagick) === false) {
    //             throw new Exception("Could not put contents.");
    //         }
    //         return true;
    //     }
    //     else {
    //         throw new Exception("No valid image provided with {$img}.");
    //     }
    // }
    //
    // // example usage
    // try {
    //     generateThumbnail('test.jpg', 100, 50, 65);
    // }
    // catch (ImagickException $e) {
    //     echo $e->getMessage();
    // }
    // catch (Exception $e) {
    //     echo $e->getMessage();
    // }

}
