<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 04/05/15
 * Time: 13:07
 */

class News {

    private $id;
    private $lodgeId;
    private $subject;
    private $contents;
    private $dateCreated;
    private $dateUpdated;

    public function __construct($lodgeId, $subject, $contents, $dateCreated, $dateUpdated)
    {
        $this->lodgeId = $lodgeId;
        $this->subject = $subject;
        $this->contents = $contents;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @param mixed $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return mixed
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lodgeId
     */
    public function setLodgeId($lodgeId)
    {
        $this->lodgeId = $lodgeId;
    }

    /**
     * @return mixed
     */
    public function getLodgeId()
    {
        return $this->lodgeId;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }



} 
