<?php
class Tag_Picture extends BaseSql{

    protected $id = -1;
    protected $tag_id = -1;
    protected $picture_id = -1;

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
     * @return int
     */
    public function getTagId()
    {
        return $this->tag_id;
    }

    /**
     * @param int $tag_id
     */
    public function setTagId($tag_id)
    {
        $this->tag_id = $tag_id;
    }

    /**
     * @return int
     */
    public function getPictureId()
    {
        return $this->picture_id;
    }

    /**
     * @param int $picture_id
     */
    public function setPictureId($picture_id)
    {
        $this->picture_id = $picture_id;
    }



}