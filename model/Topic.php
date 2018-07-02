<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 14/04/15
 * Time: 12:49
 */

class Topic {
    private $id;
    private $lodgeId;
    private $userId;
    private $degreeId;
    private $subject;
    private $dateCreated;
    private $dateUpdated;

    public function __construct($lodgeId, $userId, $degreeId, $subject, $dateCreated, $dateUpdated)
    {
        $this->lodgeId = $lodgeId;
        $this->userId = $userId;
        $this->degreeId = $degreeId;
        $this->subject = $subject;
        $this->dateCreated = $dateCreated;
        $this->dateUpdated = $dateUpdated;
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
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param mixed $degreeId
     */
    public function setDegreeId($degreeId)
    {
        $this->degreeId = $degreeId;
    }

    /**
     * @return mixed
     */
    public function getDegreeId()
    {
        return $this->degreeId;
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