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
    public function __construct($id='DEFAULT',$album_id='null',$user_id=1,$title=null,$description=null,$url=null,$is_visible=0,$created_at='DEFAULT',$updated_at='DEFAULT'){
        parent::__construct();
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setUrl();
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
     * Get the value of Created At
     *
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
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




}
