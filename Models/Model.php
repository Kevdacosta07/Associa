<?php

namespace App\Models;

use App\Core\Db;

class Model extends Db
{
    // Table de la bdd (pour les classes qui hériteront, permet de définir le nom de la table dans la bdd)
    protected string $table;

    // Instance base de données
    private Db $db;

    // Méthode pour trouver toutes les données d'une table
    public function findAll()
    {
        $sql = "SELECT * FROM " . $this->table;
        $req = $this->request($sql);
        return $req->fetchAll();
    }

    public function findBy(array $filter)
    {
        $fields = [];
        $values = [];

        foreach ($filter as $field => $value)
        {
            $fields[] = "$field = ?";
            $values[] = "$value";
        }

        // On transforme le tableau en chaîne de caractère
        $list_fields = implode(' AND ', $fields);
        var_dump($list_fields);

        $sql = "SELECT * FROM {$this->table} WHERE {$list_fields}";
        return $this->request($sql, $values)->fetchAll();
    }

    // Méthode pour automatiser les requêtes (préparée ou non)
    public function request(string $sql, array $param = null)
    {
        // Connexion à la bdd
        $this->db = self::getInstance();

        // Check les paramètres
        if ($param == null)
        {
            return $this->db->query($sql);
        }

        $req = $this->db->prepare($sql);
        $req->execute($param);
        return $req;
    }

    public function findById(int $id)
    {
        return $this->request("SELECT * FROM {$this->table} WHERE id = ?", [$id])->fetch();
    }
}