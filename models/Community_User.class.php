<?php
class Community_User extends BaseSql {

    protected $id = -1;
    protected $community_id;
    protected $user_id;
    protected $permission;

    public function __construct($id='DEFAULT', $community_id=null, $user_id=null, $permission=null) {
        parent::__construct();
        $this->community_id = $community_id;
        $this->user_id = $user_id;
        $this->permission = $permission;
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

    /**
     * Get the value of Permission
     *
     * @return mixed
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * Set the value of Permission
     *
     * @param mixed permission
     *
     * @return self
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;

        return $this;
    }

}
