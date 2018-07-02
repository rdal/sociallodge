<?php
/**
 * Created by PhpStorm.
 * User: rafael.loureiro
 * Date: 07/05/15
 * Time: 15:56
 */

class SocialNetworkInstance {
    private $id;
    private $userId;
    private $socialNetworkId;
    private $socialNetworkName;
    private $socialNetworkIcon;
    private $link;

    public function __construct($userId, $socialNetworkId, $socialNetworkName, $socialNetworkIcon, $link)
    {
        $this->userId = $userId;
        $this->socialNetworkId = $socialNetworkId;
        $this->socialNetworkName = $socialNetworkName;
        $this->socialNetworkIcon = $socialNetworkIcon;
        $this->link = $link;
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
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $socialNetworkIcon
     */
    public function setSocialNetworkIcon($socialNetworkIcon)
    {
        $this->socialNetworkIcon = $socialNetworkIcon;
    }

    /**
     * @return mixed
     */
    public function getSocialNetworkIcon()
    {
        return $this->socialNetworkIcon;
    }

    /**
     * @param mixed $socialNetworkId
     */
    public function setSocialNetworkId($socialNetworkId)
    {
        $this->socialNetworkId = $socialNetworkId;
    }

    /**
     * @return mixed
     */
    public function getSocialNetworkId()
    {
        return $this->socialNetworkId;
    }

    /**
     * @param mixed $socialNetworkName
     */
    public function setSocialNetworkName($socialNetworkName)
    {
        $this->socialNetworkName = $socialNetworkName;
    }

    /**
     * @return mixed
     */
    public function getSocialNetworkName()
    {
        return $this->socialNetworkName;
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