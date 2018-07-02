<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 13/04/15
 * Time: 14:03
 */

class TopicMessage {

    private $id;
    private $topicId;
    private $userId;
    private $dateAndTime;
    private $message;

    public function __construct($topicId, $userId, $dateAndTime, $message)
    {
        $this->topicId = $topicId;
        $this->userId = $userId;
        $this->dateAndTime = $dateAndTime;
        $this->message = $message;
    }

    /**
     * @param mixed $dateAndTime
     */
    public function setDateAndTime($dateAndTime)
    {
        $this->dateAndTime = $dateAndTime;
    }

    /**
     * @return mixed
     */
    public function getDateAndTime()
    {
        return $this->dateAndTime;
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
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $topicId
     */
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }

    /**
     * @return mixed
     */
    public function getTopicId()
    {
        return $this->topicId;
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


} 