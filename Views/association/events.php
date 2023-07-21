<div class="is-flex p-6 is-justify-content-center is-flex-direction-column is-align-items-center">
    <h1 class="title" style="font-size: 3em"><strong>Événements</strong></h1>
    <p class="subtitle">Retrouvez les événements prévu par votre association.</p>
</div>

<section class="is-flex is-justify-content-center pt-2 is-flex-direction-column is-align-items-center">

    <?php foreach ($events as $post): ?>

        <div class="is-flex card mb-6 mt-1 is-flex-direction-column is-align-items-center p-6 has-background-info" style="width: fit-content">
            <h2 class="title mb-4 has-text-white"><?= $post->title?></h2>
            <p class=" mb-1 pt-1 has-text-centered has-text-white" style="max-width: 500px"><?= $post->content?></p>
            <i class="pt-3 has-text-white"><?= $post->created_at?></i>

                <?php

                if (isset($_SESSION["assoc"]["isAdmin"]) || $post->owner === $_SESSION["user"]["id"])
                {
                    echo '<div class="is-flex is-align-items-center mt-3">';
                    echo '<a href="/association/eventUpdate/'.$post->id.'" class="button is-fullwidth is-warning">Modifier</a>';
                    echo '<a href="/association/eventDelete/'.$post->id.'" class="button is-fullwidth is-danger ml-3">Supprimer</a>';
                    echo '</div>';
                }
                ?>
        </div>

    <?php endforeach; ?>

</section>

<?php if (isset($_SESSION["assoc"]["isAdmin"]))
{
    echo <<<HTML
    <div class="is-flex is-justify-content-center is-align-items-center has-background-info card p-3" style="position:fixed; right: 30px; bottom: 30px">
        <a href="/association/eventCreate" class="has-text-white">Créer un événement</a>
    </div>
HTML;

}
