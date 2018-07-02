<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 15/09/15
 * Time: 13:57
 */

class Lodge {

    private $id;
    private $logo;
    private $governingBodyId;
    private $templeId;
    private $number;
    private $name;
    private $description;

    public function __construct($logo, $governingBodyId, $templeId, $number, $name, $description)
    {
        $this->logo = $logo;
        $this->governingBodyId = $governingBodyId;
        $this->templeId = $templeId;
        $this->number = $number;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $governingBodyId
     */
    public function setGoverningBodyId($governingBodyId)
    {
        $this->governingBodyId = $governingBodyId;
    }

    /**
     * @return mixed
     */
    public function getGoverningBodyId()
    {
        return $this->governingBodyId;
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
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $templeId
     */
    public function setTempleId($templeId)
    {
        $this->templeId = $templeId;
    }

    /**
     * @return mixed
     */
    public function getTempleId()
    {
        return $this->templeId;
    }

    /**
     * @param mixed $logo
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return mixed
     */
    public function getLogo()
    {
        return $this->logo;
    }
} 