<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 06/04/15
 * Time: 12:55
 */

class User {

    private $id;
    private $lodgeId;
    private $degreeId;
    private $cim;
    private $profilePicture;
    private $name;
    private $email;
    private $password;
    private $address;
    private $phone;
    private $mobile;
    private $webpage;
    private $aboutme;

    public function __construct($governingBodyId, $lodgeId, $degreeId, $cim, $profilePicture, $name,
                                $email, $address, $phone, $mobile, $webpage, $aboutme)
    {
        $this->governingBodyId = $governingBodyId;
        $this->lodgeId = $lodgeId;
        $this->degreeId = $degreeId;
        $this->cim = $cim;
        $this->profilePicture = (is_null($profilePicture)) ? "default-profile-pic.jpg" : $profilePicture;
        $this->name = $name;
        $this->email = $email;
        $this->address = $address;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->webpage = $webpage;
        $this->aboutme = $aboutme;
    }

//    public function __destruct() {
//        //dsada;
//    }

    /**
     * @param mixed $aboutme
     */
    public function setAboutme($aboutme)
    {
        $this->aboutme = $aboutme;
    }

    /**
     * @return mixed
     */
    public function getAboutme()
    {
        return $this->aboutme;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $cim
     */
    public function setCim($cim)
    {
        $this->cim = $cim;
    }

    /**
     * @return mixed
     */
    public function getCim()
    {
        return $this->cim;
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
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
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
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
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
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return mixed
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param mixed $webpage
     */
    public function setWebpage($webpage)
    {
        $this->webpage = $webpage;
    }

    /**
     * @return mixed
     */
    public function getWebpage()
    {
        return $this->webpage;
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

} 