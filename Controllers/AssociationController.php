<?php

namespace App\Controllers;

use App\Models\AssociationModel;
use App\Models\EventsModel;
use App\Models\UsersModel;

class AssociationController extends Controller
{

    // Page qui contient tous les membres d'une association
    public function members()
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /users/profile");
        }

        $userModel = new UsersModel();
        $users = $userModel->findAllByAssocId($_SESSION["user"]["assocId"]);

        $assocModel = new AssociationModel();
        $assoc = $assocModel->findById($_SESSION["user"]["assocId"]);

        $count = 0;

        if (!empty($_POST))
        {
            $entry = strip_tags($_POST["search"]);

            if (strlen($entry) !== 0)
            {
                $users = $userModel->findAllByNameStartsWithAssoc($entry, $_SESSION["user"]["assocId"]);
            }
        }

        $this->render("association/members", ["users"=>$users, "assoc"=>$assoc, "count"=>$count], null);
    }

    // Page qui permet de modifier les informations personnelles d'un utilisateur (ASSOC ADMIN)
    public function memberUpdate($id)
    {
        $id = implode($id);

        $userModel = new UsersModel();
        $user = $userModel->findById($id);

        $title = "Associa - Modification utilisateur";

        $error = $this->checkMemberUpdate($user->email, $id);

        $this->render("association/memberUpdate", ["user"=>$user, "error"=>$error], null);
    }


    // Fonction qui vérifie que le formulaire de modification ait été rempli correctement
    public function checkMemberUpdate($baseMail, $id): ?string
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

            $lastname = strip_tags($_POST["lastname"]);
            $firstname = strip_tags($_POST["firstname"]);
            $adress = strip_tags($_POST["adress"]);
            $phone = strip_tags($_POST["phone"]);
            $mail = strip_tags($_POST["mail"]);

            if ($mail !== $baseMail)
            {
                $userModel = new UsersModel();
                $user = $userModel->findOneByMail($mail);

                if ($user)
                {
                    return "Cette adresse mail est déjà utilisée!";
                }

                if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
                {
                    return "Veuillez saisir une adresse mail valable!";
                }
            }

            if (strlen($phone) !== 10)
            {
                return "Veuillez entrer un numéro de téléphone valable!";
            }

            if (strlen($adress) < 10)
            {
                return "Veuillez entrer une adresse postale valable!";
            }

            if (strlen($lastname) < 3)
            {
                return "Veuillez entrer un nom de famille valable!";
            }

            if (strlen($firstname) < 3)
            {
                return "Veuillez entrer un prénom valable!";
            }

            $userModel = new UsersModel();
            $userModel->update(["firstname"=>$firstname, "lastname"=>$lastname, "adress"=>$adress, "phone"=>$phone, "email"=>$mail], $id);

            return "success";
        }

        return null;
    }

    // Fonction qui supprime un utilisateur membre (ASSOC ADMIN)
    public function memberDelete($id)
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /users/login");
        }

        $userModel = new UsersModel();
        $userModel->delete($id);

        header("Location: ../../association/members");

        $this->render("association/memberDelete", [], null);
    }

    // Page qui contient le formulaire de création d'un nouvel utilisateur pour une association (ASSOC ADMIN)
    public function memberCreate()
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /users/login");
        }

        $error = $this->checkMemberCreate();

        $this->render("association/memberCreate", ["error"=>$error], null);
    }

    // Fonction qui vérifie que le formulaire de création d'utilisateur ait été rempli correctement
    public function checkMemberCreate(): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $key => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs.";
                }
            }

            $lastname = strip_tags($_POST["lastname"]);
            $firstname = strip_tags($_POST["firstname"]);
            $adress = strip_tags($_POST["adress"]);
            $phone = strip_tags($_POST["phone"]);
            $mail = strip_tags($_POST["mail"]);

            if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                return "Veuillez entrer une adresse mail valable!";
            }

            if (strlen($phone) !== 10)
            {
                return "Veuillez entrer un numéro de téléphone valable!";
            }

            if (strlen($adress) < 10)
            {
                return "Veuillez entrer une adresse postale valable!";
            }

            if (strlen($lastname) < 3)
            {
                return "Veuillez entrer un nom de famille valable!";
            }

            if (strlen($firstname) < 3)
            {
                return "Veuillez entrer un prénom valable!";
            }

            $userModel = new UsersModel();

            $user = $userModel->findOneByMail($mail);

            if ($user)
            {
                return "Un utilisateur est déjà enregistré avec cette adresse mail";
            }


            $user = $userModel->setFirstname($firstname)
                ->setLastname($lastname)
                ->setAdress($adress)
                ->setEmail($mail)
                ->setPhone($phone)
                ->setUsername($userModel->generateUsername($firstname, $lastname))
                ->setPassword(password_hash("123", PASSWORD_BCRYPT))
                ->setIsAdmin(0)
                ->setAssocId($_SESSION["user"]["assocId"]);

            $user = $userModel->hydrate($user);

            $userModel->create($user);

            return "success";
        }

        return null;
    }

    // Page événements
    public function events()
    {
        if (!isset($_SESSION["user"]))
        {
            header("location: /users/login");
        }

        $eventsModel = new EventsModel();
        $events = $eventsModel->findAllByAssocId($_SESSION["user"]["assocId"]);

        $title = "Associa | Événements";

        $this->render("association/events", ["events"=>$events, "title"=>$title], null);
    }

    // Page qui contient le formulaire de création d'événements (ASSOC ADMIN)
    public function eventCreate()
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /association/events");
        }

        $error = $this->checkEventCreate();

        $this->render("association/eventCreate", ["error"=>$error], null);
    }

    // Fonction qui vérifie que le formulaire de création d'événements ait été correctement rempli
    public function checkEventCreate(): ?string
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

            $title = strip_tags($_POST["title"]);
            $content = strip_tags($_POST["content"]);
            $assocId = $_SESSION["user"]["assocId"];
            $owner = $_SESSION["user"]["id"];

            if (strlen($title) < 5)
            {
                return "Veuillez saisir un titre valable.";
            }

            if (strlen($title) < 10)
            {
                return "Le contenu de l'événement doit faire au moins 10 caractères.";
            }


            $eventModel = new EventsModel();
            $event = $eventModel->setTitle($title)->setContent($content)->setOwner($owner)->setAssocId($assocId);
            $event = $eventModel->hydrate($event);
            $eventModel->create($event);

            return "success";
        }

        return null;
    }

    // Page qui contient le formulaire pour modifier un événement (ASSOC ADMIN)
    public function eventUpdate($id)
    {
        if (!isset($_SESSION["user"]))
        {
            header("location: /users/login");
        }

        $id = implode($id);

        $eventsModel = new EventsModel();
        $event = $eventsModel->findById($id);

        if ($event->owner !== $_SESSION["user"]["id"] && !$_SESSION["assoc"]["isAdmin"])
        {
            header("Location: /association/events");
        }

        if ($event->assocId !== $_SESSION["user"]["assocId"])
        {
            header("Location: /association/events");
        }

        $error = $this->checkEventUpdate($id);

        $event = $eventsModel->findById($id);

        $title = "Associa | Modification d'événement";

        $this->render("association/eventUpdate", ["error"=>$error, "event"=>$event, "title"=>$title], null);
    }


    // Fonction qui vérifie que le formulaire de modification d'événement ait été correctement rempli
    public function checkEventUpdate($id): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $key => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs correctement";
                }
            }

            $title = strip_tags($_POST["title"]);
            $content = strip_tags($_POST["content"]);

            $eventModel = new EventsModel();
            $eventModel->update(["title"=>$title, "content"=>$content], $id);

            return "success";

        }

        return null;
    }

    // Supprimer un événement (ASSOC ADMIN)
    public function eventDelete($id)
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /users/login");
        }

        $id = implode($id);

        $eventsModel = new EventsModel();
        $event = $eventsModel->findById($id);

        if ($event->owner !== $_SESSION["user"]["id"] && !$_SESSION["assoc"]["isAdmin"])
        {
            header("Location: /association/events");
        }

        if ($event->assocId !== $_SESSION["user"]["assocId"])
        {
            header("Location: /association/events");
        }

        $eventsModel->delete([$id]);

        header("Location: /association/events");

        $this->render("association/eventDelete", [], null);
    }

    // Page qui permet de modifier les informations de l'association (ASSOC ADMIN)
    public function parametres()
    {
        if (!isset($_SESSION["assoc"]["isAdmin"]))
        {
            header("location: /users/login");
        }

        $error = $this->checkSettingsUpdate();

        $assocModel = new AssociationModel();
        $assoc = $assocModel->findById($_SESSION["user"]["assocId"]);

        $this->render("association/parametres", ["error"=>$error, "assoc"=>$assoc], null);
    }

    public function checkSettingsUpdate(): ?string
    {
        if (!empty($_POST))
        {
            foreach ($_POST as $key => $value)
            {
                if (empty($value))
                {
                    return "Veuillez remplir tous les champs correctement";
                }
            }

            $name = strip_tags($_POST["name"]);
            $description = strip_tags($_POST["description"]);

            if (strlen($name) < 5)
            {
                return "Le nom de votre association doit contenir 5 caractères au minimum!";
            }

            if (strlen($description) < 50)
            {
                return "La description de votre assocation doit contenir 50 caractères au minimum";
            }

            $assocModel = new AssociationModel();
            $assocModel->update(["name"=>$name, "description"=>$description], $_SESSION["user"]["assocId"]);

            return "success";

        }

        return null;
    }

}