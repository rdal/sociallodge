<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 12/2/16
 * Time: 23:04
 * To change this template use File | Settings | File Templates.
 */

class Album {
    private $id;
    private $userId;
    private $mainPicId;
    private $name;

    public function __construct($userId, $mainPicId, $name)
    {
        $this->userId = $userId;
        $this->mainPicId = $mainPicId;
        $this->name = $name;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setMainPicId($mainPicId)
    {
        $this->mainPicId = $mainPicId;
    }

    public function getMainPicId()
    {
        return $this->mainPicId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}