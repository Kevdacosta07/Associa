<section class="hero is-info has-text-centered">
    <div class="hero-body">
        <p class="title">
            Fonder une association
        </p>
        <p class="subtitle">
            Soumettez une demande via le formulaire ci-dessous
        </p>
    </div>
</section>

<?php if(isset($error))
{


    echo '<div class="is-flex is-justify-content-center mt-6">';
    if ($error == "success")
    {
        echo '<p class="pt-0 p-5 card has-background-primary has-text-white">Votre demande a été envoyée! Vous recevrez une réponse dans les prochaines 12 heures.</p>';
    }

    else
    {
        echo '<p class="pt-0 p-5 card has-background-danger has-text-black">'.$error.'</p>';
    }
    echo '</div>';
}

?>

<form class="p-6 is-flex is-flex-direction-column is-align-items-center is-justify-content-center" method="post" action="">
    <div class="card m-3" style="width: 30%">
        <header class="card-header has-background-info-dark">
            <p class="card-header-title is-size-4 is-centered has-text-light">Créer votre association</p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" for="lastname">Nom</label>
                    <div class="control">
                        <input class="input" type="text" name="lastname" placeholder="Votre nom" value="<?php if (isset($_POST["lastname"])) {echo $_POST["lastname"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="firstname">Prénom</label>
                    <div class="control">
                        <input class="input" type="text" name="firstname" placeholder="Votre prénom" value="<?php if (isset($_POST["firstname"])) {echo $_POST["firstname"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="adress">Adresse</label>
                    <div class="control">
                        <input class="input" type="text" name="adress" placeholder="Votre adresse" value="<?php if (isset($_POST["adress"])) {echo $_POST["adress"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="phone">Numéro de téléphone</label>
                    <div class="control">
                        <input style="-moz-appearance: textfield" class="input" type="number" name="phone" placeholder="Votre numéro de téléphone" value="<?php if (isset($_POST["phone"])) {echo $_POST["phone"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="mail">E-mail</label>
                    <div class="control">
                        <input class="input" type="email" name="mail" placeholder="Votre adresse e-mail" value="<?php if (isset($_POST["mail"])) {echo $_POST["mail"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="assocName">Nom de l'association</label>
                    <div class="control">
                        <input class="input" type="text" name="assocName" placeholder="Nom de l'association" value="<?php if (isset($_POST["assocName"])) {echo $_POST["assocName"];} ?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="assocDesc">Description de l'association</label>
                    <div class="control">
                        <textarea class="textarea" type="text" name="assocDesc" placeholder="Nom de l'association"><?php if (isset($_POST["assocDesc"])) {echo $_POST["assocDesc"];} ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <footer class="card-footer control">
            <button class="button is-primary card-footer-item is-info" type="submit"><strong>Envoyer une demande</strong></button>
        </footer>
    </div>
</form>