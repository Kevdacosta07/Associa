<div class="is-fullwidth is-flex is-justify-content-center p-4">
    <div class="p-6">
        <h1 class="title has-text-danger" style="font-size: 4em; font-weight: 800"><strong>Pannel Administrateur</strong></h1>
    </div>
</div>


<div class="is-flex is-fullwidth is-justify-content-center">
    <div class="card p-6 is-flex is-flex-direction-column is-align-items-center">
        <div>
            <h2 class="title" style="font-size: 3em; font-weight: 700">Centre de contrôle</h2>
        </div>

        <div class="mt-3">
            <a href="/admin/users" class="button mt-5 is-info">Utilisateurs</a>
            <a href="/admin/association" class="button mt-5 is-danger">Associations</a>
            <a href="/admin/requests" class="button mt-5 is-info">Requêtes</a>
        </div>

        <div class="mt-5 is-flex is-flex-direction-column is-align-items-center">
            <h3 class="title has-text-danger mt-5 mb-0" style="font-size: 3em; font-weight: 900"><?=$numberUsers?></h3>
            <p class="title mt-0">Utilisateurs</p>
        </div>

        <div class="mt-5 is-flex is-flex-direction-column is-align-items-center">
            <h3 class="title has-text-danger mt-5 mb-0" style="font-size: 3em; font-weight: 900"><?=$numberAssocs?></h3>
            <p class="title mt-0">Associations</p>
        </div>

        <div class="mt-5 is-flex is-flex-direction-column is-align-items-center">
            <h3 class="title has-text-danger mt-5 mb-0" style="font-size: 3em; font-weight: 900"><?=$numberRequests?></h3>
            <p class="title mt-0">Requêtes</p>
        </div>
    </div>
</div>