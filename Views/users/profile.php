<div class="is-flex-direction-column is-fullwidth is-flex is-align-items-center is-justify-content-center mt-6">
    <div class="card is-info p-5 is-flex is-justify-content-center is-align-items-center has-background-info">
        <div class="left is-fullheight is-flex is-flex-direction-column is-align-items-center mr-5">
            <h1 class="mt-3  has-text-white" style="font-size: 2.5em; font-weight: 700"><?php echo "$user->firstname " . "$user->lastname"?></h1>
            <div class="is-flex mt-4">
                <a href="../users/logout" class="button is-dark">Déconnexion</a>
                <a href="/users/definePassword" class="button ml-3 is-primary has-text-dark">Définir un mot de passe</a>
            </div>
        </div>

        <div class="is-flex-direction-column is-flex pl-4 pr-4 ml-5">
            <div>
                <div>
                    <h2 class="title mb-3" style="font-weight: 700">Informations personnelles</h2>
                </div>
                <div>
                    <p class="subtitle mb-1 mt-1 has-text-white-bis"><?= $user->email?></p>
                    <p class="subtitle mb-1 has-text-white-bis"><?= $user->phone?></p>
                    <p class="subtitle mb-1 has-text-white-bis"><?= $user->adress?></p>
                </div>
            </div>

            <div class="pt-5">
                <div class="mb-3 is-flex is-align-items-center">
                    <h2 class="title mb-0" style="font-weight: 700">Association</h2>
                    <?php
                    if (isset($_SESSION["assoc"]["isAdmin"])) {echo '<p class="button is-danger mb-1 mt-1 p-2 ml-4">Admin</p>';}
                    ?>
                </div>

                <div>
                </div>

                <div>
                    <p class="subtitle mb-1 mt-1 has-text-white-bis"><?= $assoc->name?></p>
                    <p class="subtitle mb-1 has-text-white-bis" style="max-width: 400px"><?= $assoc->description?></p>
                </div>
            </div>
        </div>
    </div>
</div>