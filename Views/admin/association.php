<form method="post" class="is-fullwidth is-flex is-justify-content-center">
    <div class="field is-grouped p-5" style="width: 60%">
        <p class="control is-expanded">
            <input class="input" type="text" name="search" id="search" placeholder="Entrer le nom d'une association" value="<?php if (isset($_POST["search"])) {echo $_POST["search"];}?>">
        </p>
        <p class="control">
            <button class="button is-info" type="submit">
                Chercher
            </button>
        </p>
    </div>
</form>

<?php if (sizeof($assoc) === 0)
{
    echo <<<HTML
    <div class="is-flex is-fullwidth is-justify-content-center">
        <p class="title pt-6"><strong>Aucune association</strong></p>
    </div>
HTML;

}
?>

<?php foreach ($assoc as $a): ?>


<?php

$membersList = sizeof($userModel->findAllByAssocId($a->id));

?>
    <div class="is-flex is-fullwidth <?php if ($count % 2 == 0) {echo "has-background-info";} else {echo "has-background-info-dark";}?>">
        <div class="is-flex is-fullwidth is-flex-direction-column p-3 is-flex-wrap-wrap is-justify-content-center" style="width: 50%">
            <h2 class="has-text-white title mb-3"><strong><?php echo $a->name ?></strong></h2>
            <div class="is-flex is-flex-wrap-wrap">
                <p class="is-danger has-text-white ml-0"><?php echo $a->description ?></p>
            </div>
            <div class="is-flex is-flex-wrap-wrap pt-3">
                <p class="is-danger has-text-white ml-0">Nombre de membres : <?php echo $membersList ?></p>
                <p class="is-danger has-text-white ml-3">Créée le : <?php echo $a->created_at ?></p>
                <p class="is-danger has-text-white ml-3">ID : <?php echo $a->id ?></p>
            </div>
        </div>
        <div class="is-flex is-align-items-flex-end is-flex-direction-column is-justify-content-center" style="height 100%; width: 50%">
            <a href="/admin/associationDelete/<?=$a->id?>" class="button is-danger p-3 mt-3 mr-3">Supprimer</a>
            <a href="/admin/associationUpdate/<?=$a->id?>" class="button is-warning p-3 m-3">Modifier</a>
        </div>
    </div>

    <?php $count++ ?>

<?php endforeach; ?>