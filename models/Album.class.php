<?php
class Album extends BaseSql{

    protected $id = -1;
    protected $title;
    protected $description;
    protected $background;
    protected $disposition;
    protected $thumbnail_url;
    protected $is_presentation;
    protected $is_published; //0 not published 1 published 2 deleted
    protected $created_at;
    protected $updated_at;
    protected $user_id;

    public function __construct($id='DEFAULT', $title=null, $description=null, $background=null, $disposition=null, $thumbnail_url=null, $is_presentation=0, $is_published=0, $created_at='DEFAULT', $updated_at='DEFAULT', $user_id=1){
        parent::__construct();
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
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of Background
     *
     * @return mixed
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set the value of Background
     *
     * @param mixed background
     *
     * @return self
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get the value of Disposition
     *
     * @return mixed
     */
    public function getDisposition()
    {
        return $this->disposition;
    }

    /**
     * Set the value of Disposition
     *
     * @param mixed disposition
     *
     * @return self
     */
    public function setDisposition($disposition)
    {
        $this->disposition = $disposition;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getThumbnailUrl()
    {
        return $this->thumbnail_url;
    }

    /**
     * @param mixed $thumbnail_url
     */
    public function setThumbnailUrl($ext)
    {
        $this->thumbnail_url = parent::clean($this->title).'_'.uniqid().'.'.$ext;
    }


    /**
     * Get the value of Is Presentation
     *
     * @return mixed
     */
    public function getIsPresentation()
    {
        return $this->is_presentation;
    }

    /**
     * Set the value of Is Presentation
     *
     * @param mixed is_presentation
     *
     * @return self
     */
    public function setIsPresentation($is_presentation)
    {
        $this->is_presentation = $is_presentation;

        return $this;
    }

    /**
     * Get the value of Is Published
     *
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->is_published;
    }

    /**
     * Set the value of Is Published
     *
     * @param mixed is_published
     *
     * @return self
     */
    public function setIsPublished($is_published)
    {
        $this->is_published = $is_published;

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
     * Get the value of User Id
     *
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set the value of User Id
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

}
