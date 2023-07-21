
<?php if (sizeof($requests) === 0)
{
echo <<<HTML
    <div class="is-flex is-fullwidth is-justify-content-center">
        <p class="title pt-6"><strong>Aucune requête</strong></p>
    </div>
HTML;

}
?>

<?php foreach ($requests as $req): ?>

    <div class="is-flex is-fullwidth <?php if ($count % 2 == 0) {echo "has-background-info";} else {echo "has-background-info-dark";}?>">
        <div class="is-flex is-fullwidth is-flex-direction-column p-3 is-flex-wrap-wrap" style="width: 50%">
            <h2 class="has-text-white title mb-3"><strong><?php echo $req->name ?></strong></h2>
            <div class="is-flex is-flex-wrap-wrap">
                <p class="is-danger has-text-white mb-2"><?php echo $req->description ?></p>
            </div>

            <div class="is-flex">
                <p class="is-danger has-text-white ml-0">Date de la demande : <?php echo $req->created_at ?></p>
            </div>
        </div>
        <div class="is-flex is-align-items-flex-end is-flex-direction-column is-justify-content-center" style="height 100%; width: 50%">
            <a href='../requests/acceptRequest/<?=$req->id?>' class="button is-primary p-3 mt-3 mr-3">Accepter</a>
            <a href='../requests/denyRequest/<?=$req->id?>' class="button is-danger p-3 m-3">Refuser</a>
        </div>
    </div>

    <?php $count++ ?>

<?php endforeach; ?>
