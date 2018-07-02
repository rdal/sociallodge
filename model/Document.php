<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rdal
 * Date: 9/9/15
 * Time: 23:59
 * To change this template use File | Settings | File Templates.
 */

class Document {

    private $id;
    private $lodgeId;
    private $name;
    private $filename;
    private $dateAndTime;

    public function __construct($lodgeId, $name, $filename, $dateAndTime)
    {
        $this->lodgeId = $lodgeId;
        $this->name = $name;
        $this->filename = $filename;
        $this->dateAndTime = $dateAndTime;
    }

    public function setDateAndTime($dateAndTime)
    {
        $this->dateAndTime = $dateAndTime;
    }

    public function getDateAndTime()
    {
        return $this->dateAndTime;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setLodgeId($lodgeId)
    {
        $this->lodgeId = $lodgeId;
    }

    public function getLodgeId()
    {
        return $this->lodgeId;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

}