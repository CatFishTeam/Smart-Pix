<?php
class Picture extends BaseSql{

    protected $id = -1;
    protected $user_id;
    protected $album_id;
    protected $community_id;
    protected $title;
    protected $description;
    protected $url;
    protected $weight;
    protected $is_visible;
    protected $is_archived;
    protected $created_at;
    protected $updated_at;

    public function __construct($id='DEFAULT', $album_id=null, $user_id=1, $title=null,$description=null, $url=null, $weight=null, $is_visible='DEFAULT', $created_at='DEFAULT', $updated_at='DEFAULT'){
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
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * Get the value of Album Id
     *
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->album_id;
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
     * Get the value of Community Id
     *
     * @return mixed
     */
    public function getCommunityId()
    {
        return $this->community_id;
    }

    /**
     * Set the value of Community Id
     *
     * @param mixed community_id
     *
     * @return self
     */
    public function setCommunityId($community_id)
    {
        $this->community_id = $community_id;

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
    public function setUrl($ext)
    {
        $this->url = parent::clean($this->title).'_'.uniqid().'.'.$ext;
        return $this;
    }

    /**
     * Get the value of Weight
     *
     * @return mixed
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of Weight
     *
     * @param mixed weight
     *
     * @return self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }


    /**
     * Get the value of Is Archived
     *
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->is_archived;
    }

    /**
     * Set the value of Is Archived
     *
     * @param mixed is_archived
     *
     * @return self
     */
    public function setIsArchived($is_archived)
    {
        $this->is_archived = $is_archived;

        return $this;
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
     * Return list array of thumbnail of the user
     *
     */
    public static function getThumbs(){
        var_dump(parent::select('*'));
        // try{
        //     $req = $db->prepare("SELECT * FROM picture WHERE user_id = 1");
        //     $req->execute();
        // } catch (Exception $e) {
        //     die($e->getMessage());
        // }

    }

}
