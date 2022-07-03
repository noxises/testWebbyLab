<div class="container">
    <div class="alert alert-danger" role="alert" id="message" style="display: none;">

    </div>
    <?php if ($_SESSION['loggedIn']) { ?>
        <form method="post">
            <input type="text" hidden>
            <button type="button" id="delete" name="<?= $movie['id'] ?>" class="btn btn-danger">Delete</button>
        </form>
    <?php } ?>
    <div class="card" id="<?= $movie['id'] ?>">
        <div class="card-body">
            <h5 class="card-title"><?= $movie['title'] ?></h5>
            <p class="card-text">Format: <?= $movie['format'] ?></p>
            <p class="card-text">Release year: <?= $movie['year'] ?></p>
            <p class="card-text">Starts: <?= $movie['actors'] ?></p>
        </div>
    </div>
</div>