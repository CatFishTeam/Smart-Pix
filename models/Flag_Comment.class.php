<?php
class Flag_Comment extends BaseSql{
    protected $id = -1;
    protected $user_id;
    protected $comment_id;

    public function __construct($id='DEFAULT',$user_id=null,$comment_id=null){
        parent::__construct();
        $this->setUserId($user_id);
        $this->setCommentId($comment_id);
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
     * Get the value of Comment Id
     *
     * @return mixed
     */
    public function getCommentId()
    {
        return $this->comment_id;
    }

    /**
     * Set the value of Comment Id
     *
     * @param mixed comment_id
     *
     * @return self
     */
    public function setCommentId($comment_id)
    {
        $this->comment_id = $comment_id;

        return $this;
    }

}
