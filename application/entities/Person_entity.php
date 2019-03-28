<?php

class Person_entity
{
    /**
     * @var $id int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $lastname;
    /**
     * @var string
     */
    private $nickname;
    /**
     * @var bool
     */
    private $isMale;
    /**
     * @var int
     */
    private $accessCode;
    /**
     * @var string
     */
    private $wishlist;
    /**
     * @var bool
     */
    private $isChosen;
    /**
     * @var int
     */
    private $hasChosenPersonId;
    /**
     * @var string
     */
    private $image;

    /**
     * Person_entity constructor.
     * @param int $id
     * @param string $name
     * @param string $lastname
     * @param string $nickname
     * @param string $image
     * @param bool $isMale
     * @param int $accessCode
     * @param string $wishlist
     * @param bool $isChosen
     * @param int $hasChosenPersonId
     */

    function __construct(
        int $id,
        string $name,
        string $lastname,
        string $nickname,
        string $image,
        bool $isMale,
        int $accessCode,
        string $wishlist,
        bool $isChosen,
        int $hasChosenPersonId

    ) {
        $this->id = $id;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->nickname = $nickname;
        $this->isMale = $isMale;
        $this->accessCode = $accessCode;
        $this->wishlist = $wishlist;
        $this->isChosen = $isChosen;
        $this->hasChosenPersonId = $hasChosenPersonId;
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getNickname(): string
    {
        return $this->nickname;
    }

    /**
     * @param string $nickname
     */
    public function setNickname(string $nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
    }

    /**
     * @return bool
     */
    public function getIsMale(): bool
    {
        return $this->isMale;
    }

    /**
     * @param bool $isMale
     */
    public function setIsMale(bool $isMale)
    {
        $this->isMale = $isMale;
    }

    /**
     * @return int
     */
    public function getAccessCode(): int
    {
        return $this->accessCode;
    }

    /**
     * @param int $accessCode
     */
    public function setAccessCode(int $accessCode)
    {
        $this->accessCode = $accessCode;
    }

    /**
     * @return string
     */
    public function getWishlist(): string
    {
        return $this->wishlist;
    }

    /**
     * @param string $wishlist
     */
    public function setWishlist(string $wishlist)
    {
        $this->wishlist = $wishlist;
    }

    /**
     * @return bool
     */
    public function getIsChosen(): bool
    {
        return $this->isChosen;
    }

    /**
     * @param bool $isChosen
     */
    public function setIsChosen(bool $isChosen)
    {
        $this->isChosen = $isChosen;
    }

    /**
     * @return int
     */
    public function getHasChosenPersonId(): int
    {
        return $this->hasChosenPersonId;
    }

    /**
     * @param int $hasChosenPersonId
     */
    public function setHasChosenPersonId(int $hasChosenPersonId)
    {
        $this->hasChosenPersonId = $hasChosenPersonId;
    }
}
