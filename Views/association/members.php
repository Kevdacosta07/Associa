<form method="post" class="is-fullwidth is-flex is-justify-content-center">
    <div class="field is-grouped p-5" style="width: 60%">
        <p class="control is-expanded">
            <input class="input" type="text" name="search" id="search" placeholder="Entrer un nom ou prénom" value="<?php if (isset($_POST["search"])) {echo $_POST["search"];}?>">
        </p>
        <p class="control">
            <button class="button is-info" type="submit">
                Chercher
            </button>
        </p>
    </div>
</form>

<div class="is-flex is-justify-content-center is-align-items-center pb-4">
    <a href="/association/memberCreate" class="button has-text-white has-background-info-dark">Créer un utilisateur</a>
</div>

<?php foreach ($users as $user): ?>

    <?php

    if ($user->assocId !== 0)
    {
        $isAssocAdmin = false;

        $assocAdmins = $assoc->admin_id;

        $adminId = explode(",", $assocAdmins);

        foreach ($adminId as $item)
        {
            if (intval($item) === $user->id)
            {
                $isAssocAdmin = true;
            }
        }
    }
    ?>

    <div class="is-flex is-fullwidth <?php if ($count % 2 == 0) {echo "has-background-info";} else {echo "has-background-info-dark";}?>">
        <div class="is-flex is-fullwidth is-flex-direction-column p-3 is-flex-wrap-wrap" style="width: 50%">
            <div class="is-flex">
                <h2 class="has-text-white title mb-3"><strong><?php echo $user->firstname . " ". $user->lastname ?></strong></h2>
                <?php if ($isAssocAdmin) {echo "<p class='button is-danger ml-3 p-1'>ADMIN</p>";}?>
            </div>
            <div class="is-flex is-flex-wrap-wrap">
                <p class="is-danger has-text-white ml-0"><?php echo $user->email ?></p>
                <p class="is-danger has-text-white ml-3"><?php echo $user->username ?></p>
                <p class="is-danger has-text-white ml-3"><?php echo $user->phone ?></p>
                <p class="is-danger has-text-white ml-3"><?php echo $user->adress ?></p>
            </div>

            <div class="is-flex">
                <p class="is-danger has-text-white ml-0">Membre depuis : <?php echo $user->created_at ?></p>
            </div>
        </div>
        <div class="is-flex is-align-items-flex-end is-flex-direction-column is-justify-content-center" style="height 100%; width: 50%">
            <a href='memberDelete/<?= $user->id ?>' class="button is-danger p-3 mt-3 mr-3">Supprimer</a>
            <a href="memberUpdate/<?= $user->id ?>" class="button is-warning p-3 m-3">Modifier</a>
        </div>
    </div>

    <?php $count++ ?>

<?php endforeach; ?>
