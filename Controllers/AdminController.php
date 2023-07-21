<?php

namespace App\Controllers;

use App\Models\AssociationModel;
use App\Models\RequestsModel;
use App\Models\UsersModel;
use mysql_xdevapi\Exception;

class AdminController extends Controller
{
    // Page d'accueil du pannel administrateur
    public function index()
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $userModel = new UsersModel();
        $numberUsers = sizeof($userModel->findAll());

        $requestsModel = new RequestsModel();
        $numberRequests = sizeof($requestsModel->findAll());

        $assocModel = new AssociationModel();
        $numberAssocs = sizeof($assocModel->findAll());

        $title = "Pannel administrateur";
        $this->render("admin/index", ["title" => $title, "numberUsers"=>$numberUsers, "numberAssocs"=>$numberAssocs, "numberRequests"=>$numberRequests], false);
    }

    // Page qui contient la liste des utilisateurs
    public function users()
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $userModel = new UsersModel();

        $users = null;

        if (!empty($_POST))
        {

            $entry = strip_tags($_POST["search"]);

            if (strlen($entry) !== 0)
            {
                $users = $userModel->findAllByNameStartsWith($entry);
            }
        }

        if ($users === null)
        {
            $users = $userModel->findAll();
        }

        $assocModel = new AssociationModel();

        $count = 0;

        $title = "Pannel administrateur";
        $this->render("admin/users", ["title" => $title, "users" => $users, "assocModel"=>$assocModel, "count" => $count], false);
    }

    // Suppression d'un utilisateur
    public function userDelete($id)
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $userModel = new UsersModel();

        $userModel->delete($id);

        $this->render("admin/userDelete");
    }

    // Page qui contient le formulaire pour modifier les informations d'une utilisateur
    public function userUpdate($id)
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $id = implode($id);

        $userModel = new UsersModel();

        $error = $this->checkUserUpdate($id);

        $user = $userModel->findById($id);

        $this->render("admin/userUpdate", ["user"=>$user, "error"=>$error], false);
    }

    // Fonction qui vérifie les données du formulaire pour la modification des données des utilisateurs
    public function checkUserUpdate($id): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $field => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs correctement!";
                }
            }

            $firstname = strip_tags($_POST["firstname"]);
            $lastname = strip_tags($_POST["lastname"]);
            $email = strip_tags($_POST["mail"]);
            $adress = strip_tags($_POST["adress"]);
            $phone = strip_tags($_POST["phone"]);
            $assocId = strip_tags($_POST["assocId"]);
            $username = strip_tags($_POST["username"]);
            $isAdmin = strip_tags($_POST["isAdmin"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                return "Veuillez entrer une adresse mail valide!";
            }

            try {
                $isAdmin = intval($isAdmin);
            } catch (Exception)
            {
                return "Veuilez entrer 0 ou 1 pour le champ administrateur";
            }

            $userModel = new UsersModel();

            $userModel->update(["firstname"=>$firstname, "lastname"=>$lastname,
                "email"=>$email, "adress"=>$adress, "assocId"=>$assocId, "isAdmin"=>$isAdmin,
                "username"=>$username, "phone"=>$phone], $id);

            return "success";
        }

        return null;
    }

    // Page qui contient la listes des requêtes
    public function requests()
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $requestModel = new RequestsModel();

        $requests = $requestModel->findAll();

        $count = 0;

        $title = "Admin dashboard";
        $this->render("admin/requests", ["title" => $title, "requests" => $requests, "count" => $count], false);
    }

    // Page qui contient la liste des associations
    public function association()
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $associationModel = new AssociationModel();

        $userModel = new UsersModel();

        $assoc = null;

        if (!empty($_POST))
        {
            $entry = strip_tags($_POST["search"]);

            if (strlen($entry) !== 0)
            {
                $assoc = $associationModel->findAllStartingWith($entry);
            }
        }

        if ($assoc === null)
        {
            $assoc = $associationModel->findAll();
        }

        $count = 0;

        $title = "Admin dashboard";
        $this->render("admin/association", ["title" => $title, "assoc"=>$assoc, "userModel"=>$userModel, "count"=>$count], false);
    }

    // Page qui contient le formulaire pour modifier une association
    public function associationUpdate($id)
    {
        $associationModel = new AssociationModel();

        $id = implode($id);

        $error = $this->checkAssociationUpdate($id);

        $assoc = $associationModel->findById($id);

        $title = "Associa | Modifier une association";

        $this->render("admin/associationUpdate", ["error"=>$error, "assoc"=>$assoc, "title"=>$title], false);
    }


    public function checkAssociationUpdate($id): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $field => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs!";
                }
            }

            $name = strip_tags($_POST["name"]);
            $description = strip_tags($_POST["description"]);
            $admin_id = strip_tags($_POST["admin_id"]);

            $associationModel = new AssociationModel();
            $associationModel->update(["name"=>$name, "description"=>$description, "admin_id"=>$admin_id], $id);

            return "success";
        }
        return null;
    }

    public function associationDelete($id)
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $id = implode($id);

        $associationModel = new AssociationModel();

        $associationModel->delete([$id]);

        $userModel = new UsersModel();

        $users = $userModel->findAllByAssocId($id);

        print_r($users);

        foreach ($users as $user)
        {
            if ($user->isAdmin === 1)
            {
                echo "ADMIN";
                $userModel->update(["assocId"=>0], $user->id);
            }

            else
            {
                $userModel->delete([$user->id]);
            }
        }

        $this->render("admin/associationDelete", [], false);
    }
}