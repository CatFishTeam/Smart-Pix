<?php

class Action extends BaseSql {

    protected $id = -1;
    protected $user_id;
    protected $community_id;
    protected $type_action;
    protected $related_id;
    protected $created_at;

    public function __construct($id = -1, $user_id = -1, $type_action = "", $related_id = -1, $created_id = "")
    {
        parent::__construct();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
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
     * @return mixed
     */
    public function getTypeAction()
    {
        return $this->type_action;
    }

    /**
     * @param mixed $type_action
     */
    public function setTypeAction($type_action)
    {
        $this->type_action = $type_action;
    }

    /**
     * @return mixed
     */
    public function getRelatedId()
    {
        return $this->related_id;
    }

    /**
     * @param mixed $related_id
     */
    public function setRelatedId($related_id)
    {
        $this->related_id = $related_id;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


}
