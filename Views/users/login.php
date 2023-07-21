<section class="hero is-info has-text-centered">
    <div class="hero-body">
        <p class="title">
            Connexion
        </p>
        <p class="subtitle">
            Connectez-vous pour accéder à votre association !
        </p>
    </div>
</section>


<form style="display: flex; align-items: center; flex-direction: column" method="post" action="">
    <div class="card m-6" style="width: 30%">
        <header class="card-header has-background-dark">
            <p class="card-header-title is-size-4 is-centered has-text-light">
                Login
            </p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" for="email">Adresse email</label>
                    <div class="control">
                        <input class="input" type="email" name="email" placeholder="Votre adresse email" value=<?php if (isset($_POST["email"])) {echo $_POST["email"];} ?>>
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="password">Votre mot de passe</label>
                    <div class="control">
                        <input class="input" type="password" name="password" placeholder="Votre mot de passe">
                    </div>
                </div>
            </div>
        </div>
        <footer class="card-footer control">
            <button class="button is-link card-footer-item is-medium" type="submit"><strong>Connexion</strong></button>
        </footer>
    </div>

    <?php if(isset($error))
    {
        echo '<div class="is-flex is-justify-content-center mb-6">';
        echo '<p class="pt-0 p-5 card has-background-danger has-text-white">'.$error.'</p>';
        echo '</div>';
    }

    ?>
</form>