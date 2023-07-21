<section class="hero is-info has-text-centered">
    <div class="hero-body">
        <p class="title">
            Modification utilisateurs
        </p>
        <p class="subtitle">
            Modifier les informations d'un utilisateur
        </p>
    </div>
</section>

<?php if(isset($error))
{


    echo '<div class="is-flex is-justify-content-center mt-6">';
    if ($error == "success")
    {
        echo '<p class="pt-0 p-5 card has-background-primary has-text-white">Modification appliquées !</p>';
        header("refresh: 2; url=/association/members");
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
            <p class="card-header-title is-size-4 is-centered has-text-light"><?=$user->firstname . " " . $user->lastname?></p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" for="lastname">Nom</label>
                    <div class="control">
                        <input class="input" type="text" name="lastname" placeholder="Nom" value="<?=$user->lastname?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="firstname">Prénom</label>
                    <div class="control">
                        <input class="input" type="text" name="firstname" placeholder="Prénom" value="<?=$user->firstname?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="adress">Adresse</label>
                    <div class="control">
                        <input class="input" type="text" name="adress" placeholder="" value="<?=$user->adress?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="phone">Numéro de téléphone</label>
                    <div class="control">
                        <input style="-moz-appearance: textfield" class="input" type="number" name="phone" placeholder="Votre numéro de téléphone" value="<?=$user->phone?>">
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="mail">E-mail</label>
                    <div class="control">
                        <input class="input" type="email" name="mail" placeholder="Adresse e-mail" value="<?=$user->email?>">
                    </div>
                </div>


            </div>
        </div>
        <footer class="card-footer control">
            <button class="button card-footer-item is-primary" type="submit"><strong>Modifier</strong></button>
        </footer>
    </div>
</form>