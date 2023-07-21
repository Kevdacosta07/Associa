<?php

namespace App\Models;


class UsersModel extends Model
{
    public $id;
    protected $firstname;
    protected $lastname;
    protected $adress;
    protected $phone;
    protected $username;
    protected $email;
    protected $password;
    protected $assocId;
    protected $isAdmin;

    public function __construct()
    {
        $this->table = "users";
    }

    public function findOneByMail($mail)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE email = ?", [$mail])->fetch();
    }

    public function findOneByUsername($username)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE username = ?", [$username])->fetch();
    }

    public function findAllByNameStartsWith($entry)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE firstname LIKE '$entry%' OR lastname LIKE '$entry%'")->fetchAll();
    }

    public function findAllByNameStartsWithAssoc($entry, $id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE firstname LIKE '$entry%' OR lastname LIKE '$entry%' AND assocId = ?", [$id])->fetchAll();
    }

    public function findAllByAssocId($id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE assocId = ?", [$id])->fetchAll();
    }

    public function isUserAdmin($username): int
    {
        $req = $this->request("SELECT * FROM {$this->table} WHERE username = ?", [$username])->fetch();

        return $req->isAdmin;
    }

    public function generateUsername($firstname, $lastname): string
    {
        $firstname = strtolower($firstname);
        $lastname = strtolower($lastname);

        $lastname = preg_replace("#[aeiou\s]+#i", "", $lastname);

        $baseUsername = $firstname . "." . $lastname;

        $user = $this->findOneByUsername($baseUsername);

        if (!$user)
        {
            return $baseUsername;
        }

        for ($x = 0; $x != 100; $x++)
        {
            if (strlen($baseUsername) < 7)
            {
                $rint = random_int(100, 999999);

                $baseUsername .= $rint;

                $user = $this->findOneByUsername($baseUsername);

                if (!$user)
                {
                    return $baseUsername;
                }
            }

            $baseUsername = substr_replace($baseUsername, "", -1);

            $user = $this->findOneByUsername($baseUsername);

            if (!$user)
            {
                return $baseUsername;
            }
        }

        return "";
    }

    public function generatePassword(): string
    {
        $c = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $chars = str_split($c);
        $length = 10;
        $finalStr = "";

        for ($x = 0; $x != $length; $x++)
        {
            $rint = random_int(0, strlen($c) - 1);

            $char = $chars[$rint];

            $finalStr .= $char;
        }

        return password_hash($finalStr, PASSWORD_BCRYPT);
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAssocId()
    {
        return $this->assocId;
    }

    /**
     * @param mixed $assocId
     */
    public function setAssocId($assocId): self
    {
        $this->assocId = $assocId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdress()
    {
        return $this->adress;

    }

    /**
     * @param mixed $adress
     */
    public function setAdress($adress): self
    {
        $this->adress = $adress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * @param mixed $isAdmin
     */
    public function setIsAdmin($isAdmin): self
    {
        $this->isAdmin = $isAdmin;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }


}