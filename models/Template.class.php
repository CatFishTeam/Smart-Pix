<?php
class Template extends BaseSql{

    protected $id = -1;
    protected $name;
    protected $background;
    protected $disposition;
    protected $album_id;


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
        $this->name = trim($name);

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
     * Get the value of Album Id
     *
     * @return mixed
     */
    public function getAlbumId()
    {
        return $this->album_id;
    }

    /**
     * Set the value of Album Id
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

}
