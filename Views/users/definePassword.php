<section class="hero is-info has-text-centered">
    <div class="hero-body">
        <p class="title">
            Modifier votre mot de passe
        </p>
        <p class="subtitle">
            Redéfinissez votre mot de passe
        </p>
    </div>
</section>

<?php if(isset($error))
{


    echo '<div class="is-flex is-justify-content-center mt-6">';
    if ($error == "success")
    {
        echo '<p class="pt-0 p-5 card has-background-primary has-text-white">Votre mot de passe a été modifé !</p>';
        header("refresh: 2; url=/users/profile");
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
            <p class="card-header-title is-size-4 is-centered has-text-light">Votre événement</p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" for="password">Votre mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="password" placeholder="Votre mot de passe" value="<?php if (isset($_POST["password"])) {echo $_POST["password"];} ?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="password2">Confirmation du mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="password2" placeholder="Confirmation du mot de passe" value="<?php if (isset($_POST["password2"])) {echo $_POST["password2"];} ?>">
                    </div>
                </div>

            </div>
        </div>
        <footer class="card-footer control">
            <button class="button card-footer-item is-primary" type="submit"><strong>Modifier</strong></button>
        </footer>
    </div>
</form>