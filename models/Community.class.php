<?php
class Community extends BaseSql{

    protected $id = -1;
    protected $name;
    protected $slug;
    protected $description;
    protected $created_at;
    protected $updated_at;

    //TODO voir user
    // • Récupérer les comments liés à un user (détenteur)

    public function __construct($id='DEFAULT',$name=null,$description=null){
        parent::__construct();
        $this->setName($name);
        $this->setDescription($description);
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
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Slug
     *
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set the value of Slug
     *
     * @param mixed slug
     *
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

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

}
