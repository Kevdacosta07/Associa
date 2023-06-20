<h1>Posts</h1>

<section>

    <?php foreach ($data as $post): ?>

    <div>
        <h2><?= $post->title?></h2>
        <p><?= $post->content?></p>
        <i><?= $post->created_at?></i>
    </div>

    <?php endforeach; ?>

</section>
