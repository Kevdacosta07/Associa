<section class="hero is-info has-text-centered">
    <div class="hero-body">
        <p class="title">
            Modifier votre association
        </p>
        <p class="subtitle">
            Modifier les informations liées à votre association
        </p>
    </div>
</section>

<?php if(isset($error))
{


    echo '<div class="is-flex is-justify-content-center mt-6">';
    if ($error == "success")
    {
        echo '<p class="pt-0 p-5 card has-background-primary has-text-white">Informations mises à jour !</p>';
        header("refresh: 2; url= /users/profile");
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
            <p class="card-header-title is-size-4 is-centered has-text-light"><?= $assoc->name?></p>
        </header>
        <div class="card-content">
            <div class="content">
                <div class="field">
                    <label class="label" for="lastname">Nom de l'assocation</label>
                    <div class="control">
                        <input class="input" type="text" name="name" placeholder="Nom de l'association" value="<?php if (isset($_POST["name"])) {echo $_POST["name"];} else {echo $assoc->name;}?>">
                    </div>
                </div>
                <div class="field">
                    <label class="label" for="firstname">Description de l'événement</label>
                    <div class="control">
                        <textarea class="textarea" name="description" placeholder="Description"><?php if (isset($_POST["description"])) {echo $_POST["description"];} else {echo $assoc->description;}?></textarea>
                    </div>
                </div>

            </div>
        </div>
        <footer class="card-footer control">
            <button class="button card-footer-item is-primary" type="submit"><strong>Modifier</strong></button>
        </footer>
    </div>
</form>