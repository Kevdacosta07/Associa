<form class="p-6 is-flex is-flex-direction-column is-align-items-center is-justify-content-center" style="display: flex; justify-content: center" method="post" action="">
    <div class="card m-3" style="width: 30%">
        <header class="card-header has-background-danger">
            <p class="card-header-title is-size-4 is-centered has-text-light">Refuser la demande de <?=$name ?></p>
        </header>
        <div class="card-content">
            <div class="content">

                <div class="field">
                    <label class="label" for="assocDesc">Motif</label>
                    <div class="control">
                        <textarea class="textarea" type="text" name="assocDesc" placeholder="Motif du refus"><?php if (isset($_POST["assocDesc"])) {echo $_POST["assocDesc"];} ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <footer class="card-footer control">
            <button class="button is-primary card-footer-item has-background-primary-dark" type="submit"><strong>Envoyer</strong></button>
        </footer>
    </div>

    <?php if(isset($error))
    {
        echo '<div class="is-flex is-justify-content-center mt-3">';
        echo '<p class="pt-0 p-5 card has-background-danger has-text-black">'.$error.'</p>';
        echo '</div>';
    }

    ?>
</form>