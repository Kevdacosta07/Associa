<?php

namespace App\Controllers;

use App\Models\AssociationModel;
use App\Models\UsersModel;

class UsersController extends Controller
{

    public function profile()
    {
        if (!isset($_SESSION["user"]))
        {
            header("location: /users/login");
        }

        $AssocModel = new AssociationModel();
        $assoc = $AssocModel->findById($_SESSION["user"]["assocId"]);

        $userModel = new UsersModel();
        $user = $userModel->findById($_SESSION["user"]["id"]);

        $title = "Associa - ".$assoc->name;

        $this->render("users/profile", ["assoc" => $assoc,"user"=>$user, "title"=>$title], null);
    }

    // Page de changement du mot de passe
    public function definePassword()
    {
        $error = $this->checkDefinePassword();

        $this->render("users/definePassword", ["error"=>$error], null);
    }

    // Fonction qui éffectue les vérifications lorsque l'utilisateur soumet sa demande de changement de mot de passe
    public function checkDefinePassword(): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $key => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs!";
                }
            }

            $password = htmlentities($_POST["password"]);
            $password2 = htmlentities($_POST["password2"]);

            echo $password."\n";
            echo $password2."\n";

            if (strlen($password) < 8)
            {
                return "Votre nouveau mot de passes doit contenir 8 caractères au minimum";
            }

            if ($password !== $password2)
            {
                return "Les mots de passes ne sont pas identiques";
            }

            $password = password_hash($password, PASSWORD_BCRYPT);

            $userModel = new UsersModel();
            $userModel->update(["password"=>$password], $_SESSION["user"]["id"]);

            return "success";
        }

        return null;
    }

    // Page login
    public function login()
    {
        $title = "Associa | Login";
        $error = $this->checkLogin();

        $this->render('users/login', ["error" => $error, "title" => $title]);
    }

    // Déconnexion
    public function logout()
    {
        unset($_SESSION['assoc']);
        unset($_SESSION['user']);

        header("location: /main");

        $this->render("users/logout", [], null);
    }

    // Fonction qui vérifie le login
    public function checkLogin(): ?string
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

            $mail = strip_tags($_POST["email"]);

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                return "Veuillez entrer une adresse e-mail correcte!";
            }

            $userModel = new UsersModel();
            $user = $userModel->findOneByMail($mail);

            if (!$user)
            {
                return "utilisateur incorrects!";
            }

            if ($user->assocId !== 0)
            {
                $assocModel = new AssociationModel();

                $assoc = $assocModel->findById($user->assocId);

                $assocAdmins = $assoc->admin_id;

                $adminId = explode(",", $assocAdmins);

                foreach ($adminId as $item)
                {
                    if (intval($item) === $user->id)
                    {
                        $_SESSION["assoc"] = [
                            "isAdmin"=>true];
                    }
                }
            }

            $user = $userModel->hydrate($user);

            echo $user->getPassword();

            if (password_verify($_POST["password"], $user->getPassword()))
            {
                $_SESSION["user"] = [
                    "id" => $user->getId(),
                    "firstname" => $user->getFirstname(),
                    "lastname" => $user->getLastname(),
                    "username" => $user->getUsername(),
                    "mail" => $user->getEmail(),
                    "assocId" => $user->getAssocId(),
                ];

                $admin = $userModel->isUserAdmin($user->getUsername());

                if ($admin === 1)
                {
                    $_SESSION["user"] = [
                        "id" => $user->getId(),
                        "firstname" => $user->getFirstname(),
                        "lastname" => $user->getLastname(),
                        "username" => $user->getUsername(),
                        "mail" => $user->getEmail(),
                        "assocId" => $user->getAssocId(),
                        "superAdmin"=>true
                    ];
                }

                header("location: /users/profile");
            }

            else
            {
                return "Identifiants incorrects!";
            }

        }

        return null;
    }
}