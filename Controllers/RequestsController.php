<?php

namespace App\Controllers;

use App\Models\RequestsModel;
use App\Models\UsersModel;
use App\Models\AssociationModel;

class RequestsController extends Controller
{
    // Page qui contient le formulaire de création d'associations
    public function association()
    {
        $error = $this->checkAssoCreation();

        $title = "Associa | Fonder une association";
        $this->render("requests/association", ["title" => $title, "error"=>$error]);
    }

    // Fonction qui fait les vérifications pour la création d'une demande
    public function checkAssoCreation(): ?string
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

            $lastname = strip_tags($_POST["lastname"]);
            $firstname = strip_tags($_POST["firstname"]);
            $adress = strip_tags($_POST["adress"]);
            $mail = strip_tags($_POST["mail"]);
            $phone = strip_tags($_POST["phone"]);
            $assocName = strip_tags($_POST["assocName"]);
            $assocDesc = strip_tags($_POST["assocDesc"]);

            if (strlen($lastname) <= 1)
            {
                return "Veuillez saisir un nom valable.";
            }

            if (strlen($firstname) <= 2)
            {
                return "Veuillez saisir un prénom valable.";
            }

            if (strlen($adress) <= 7)
            {
                return "Veuillez saisir une adresse valable.";
            }

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                return "Veuillez entrer une adresse e-mail valable.";
            }

            if (strlen($phone) < 10)
            {
                return "Veuillez saisir un numéro de téléphone valide.";
            }

            if (strlen($assocName) < 3)
            {
                return "Veuillez saisir un nom d'association valide.";
            }

            if (strlen($assocDesc) < 50)
            {
                return "Veuillez saisir une description de minimum 50 caractères.";
            }

            $requestModel = new RequestsModel();
            $userModel = new UsersModel();
            $associationModel = new AssociationModel();

            if ($userModel->findOneByMail($mail) || $requestModel->findOneByMail($mail))
            {
                return "Cette adresse mail est déjà utilisée.";
            }

            if ($requestModel->findOneByName($assocName))
            {
                return "Une demande avec ce nom d'association est déjà cours.";
            }

            if ($associationModel->findOneByName($assocName))
            {
                return "Une association avec le même nom est déjà existant.";
            }

            $request = $requestModel->setFirstname($firstname)
                ->setLastname($lastname)
                ->setAdress($adress)
                ->setEmail($mail)
                ->setPhone($phone)
                ->setName($assocName)
                ->setDescription($assocDesc);

            $request = $requestModel->hydrate($request);

            $requestModel->create($request);
            return "success";
        }



        return null;
    }

    // Fonction qui s'exécute lorsque l'on refuse une demande
    public function denyRequest($id)
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        $requestModel = new RequestsModel();

        $id = implode($id);

        $request = $requestModel->findById($id);

        $title = "Associa | Motif de refus";

        if (!empty($_POST))
        {
            $requestModel->delete([$id]);

            header("Location: /admin/requests");
        }

        $this->render("requests/denyRequest", ["title"=>$title, "name"=>$request->name]);
    }

    // Fonction qui s'exécute lorsque l'on accepte une demande
    public function acceptRequest($id)
    {
        if (!$_SESSION['user']["superAdmin"])
        {
            header("Location: /users/login");
        }

        // On récupère les infos de la bdd concernant la requête
        $requestModel = new RequestsModel();

        $id = implode($id);

        $request = $requestModel->findById($id);

        print_r($request);

        // Création de l'association
        $assocModel = new AssociationModel();
        $assoc = $assocModel
            ->setAdminId("")
            ->setName($request->name)
            ->setDescription($request->description);

        $assoc = $assocModel->hydrate($assoc);

        $assocModel->create($assoc);

        // On récupère l'id de l'association
        $assoc = $assocModel->findOneByName($request->name);

        // Création de l'utilisateur qui possède l'association
        $userModel = new UsersModel();


        $user = $userModel->setPhone($request->phone)
            ->setAdress($request->adress)
            ->setFirstname($request->firstname)
            ->setLastname($request->lastname)
            ->setEmail($request->email)
            ->setIsAdmin(0)
            ->setAssocId($assoc->id)
            ->setUsername($userModel->generateUsername($request->firstname, $request->lastname))
            ->setPassword($userModel->generatePassword());

        $user = $userModel->hydrate($user);

        $userModel->create($user);


        // On récupère l'id de l'utilisateur
        $userId = $userModel->findOneByMail($request->email)->id;

        // On passe l'utilisateur admin de l'association
        $assocModel->update(["admin_id"=>$userId], $assoc->id);

        // On supprime la requête
        $requestModel->delete([$request->id]);

        $this->render("requests/acceptRequest");

    }

}