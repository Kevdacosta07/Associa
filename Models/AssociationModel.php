<?php

namespace App\Models;

class AssociationModel extends Model
{
    protected $name;
    protected $description;
    protected $admin_id;

    public function __construct()
    {
        $this->table = "association";
    }

    public function findOneByName($name)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE name = ?", [$name])->fetch();
    }

    public function findAllStartingWith($entry)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE name LIKE '$entry%'")->fetchAll();
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param mixed $admin_id
     */
    public function setAdminId($admin_id): self
    {
        $this->admin_id = $admin_id;
        return $this;
    }
}