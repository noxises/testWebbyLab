<?php
$array = json_encode($movies);
?>
<div class="container mt-2">
    <div class="alert alert-danger" role="alert" id="message" style="display: none;">

    </div>
    <h4>Count movies:<?= count($movies) ?></h4>
    <?php if (isset($message)) { ?>
        <h1><?= $message ?></h1>
    <?php } ?>
    <button type="button" class="btn btn-primary" id="sort_by_title">Sort by Title</button>
    <button type="button" class="btn btn-primary" id="sort_by_actors">Sort by Actors</button>
    <button type="button" class="btn btn-primary" id="sort_by_year">Sort by Year</button>
    <button type="button" class="btn btn-primary" id="remove_sort">Remove sort</button>
    <?php if ($_SESSION['loggedIn']) { ?>
        <button type="submit" class="btn btn-danger" form="delete_selected">Delete selected</button>
    <?php } ?>
    <form method="post" class="mt-2" id="delete_selected" name="delete_selected">
        <table class="table table-bordered border-primary">
            <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Title</th>
                <th scope="col">Release Year</th>
                <th scope="col">Format</th>
                <th scope="col">Actors</th>
                <th scope="col">Link</th>
                <?php if ($_SESSION['loggedIn']) { ?>
                    <th scope="col"><input type="checkbox" id="select_all"></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($movies as $movie) { ?>
                <tr>
                    <th><?= $movie['id'] ?></th>
                    <td><?= $movie['title'] ?></td>
                    <td> <?= $movie['year'] ?></td>
                    <td><?= $movie['format'] ?></td>
                    <td> <?= $movie['actors'] ?></td>
                    <td><a href="/movie/<?= $movie['id'] ?>">More</a></td>
                    <?php if ($_SESSION['loggedIn']) { ?>
                        <td><input type="checkbox" name="products[]" value="<?= $movie['id'] ?>"></td>
                    <?php } ?>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </form>
</div>


<script>
    function SortByTitle(a, b) {
        var aName = a.title.toLowerCase();
        var bName = b.title.toLowerCase();
        return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
    }

    function SortByActors(a, b) {
        var aName = a.actors.toLowerCase();
        var bName = b.actors.toLowerCase();
        return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
    }

    function SortByYear(a, b) {
        var aName = a.year.toLowerCase();
        var bName = b.year.toLowerCase();
        return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
    }

    $('#sort_by_title').click(function () {
        $('tbody').html('');
        let array = <?= $array ?>;
        array.sort(SortByTitle);
        $.each(array, function () {
            $('tbody').append(`
            <tr>
                <th>${this.id}</th>
                <td>${this.title}</td>
                <td>${this.year}</td>
                <td>${this.format}</td>
                <td> ${this.actors}</td>
                <td><a href="/movie/${this.id}">More</a></td>
                <?php if ($_SESSION['loggedIn']) { ?>
                <td><input type="checkbox" name="products[]" value="${this.id}"></td>
                <?php }?>
            </tr>
        `)
        });
    });
    $('#sort_by_actors').click(function () {
        $('tbody').html('');
        let array = <?= $array ?>;
        array.sort(SortByActors);
        $.each(array, function () {
            $('tbody').append(`
            <tr>
                <th>${this.id}</th>
                <td>${this.title}</td>
                <td>${this.year}</td>
                <td>${this.format}</td>
                <td> ${this.actors}</td>
                <td><a href="/movie/${this.id}">More</a></td>
                <?php if ($_SESSION['loggedIn']) { ?>
                <td><input type="checkbox" name="products[]" value="${this.id}"></td>
                <?php }?>
                            </tr>
        `)
        });
    });
    $('#sort_by_year').click(function () {
        $('tbody').html('');
        let array = <?= $array ?>;
        array.sort(SortByYear);
        $.each(array, function () {
            $('tbody').append(`
            <tr>
                <th>${this.id}</th>
                <td>${this.title}</td>
                <td>${this.year}</td>
                <td>${this.format}</td>
                <td> ${this.actors}</td>
                <td><a href="/movie/${this.id}">More</a></td>
                <?php if ($_SESSION['loggedIn']) { ?>
                <td><input type="checkbox" name="products[]" value="${this.id}"></td>
                <?php }?>
            </tr>
        `)
        });
    });
    $('#remove_sort').click(function () {
        $('tbody').html('');
        let array = <?= $array ?>;
        $.each(array, function () {
            $('tbody').append(`
            <tr>
                <th>${this.id}</th>
                <td>${this.title}</td>
                <td>${this.year}</td>
                <td>${this.format}</td>
                <td> ${this.actors}</td>
                <td><a href="/movie/${this.id}">More</a></td>
                <?php if ($_SESSION['loggedIn']) { ?>
                <td><input type="checkbox" name="products[]" value="${this.id}"></td>
                <?php }?>
            </tr>
        `)
        });
    });


    $("#select_all").click(function () {
        if ($(this).is(':checked')) {
            $.each($("input[name='products[]']"), function (index) {
                $(this).prop('checked', true)
            });
        } else {
            $.each($("input[name='products[]']"), function (index) {
                $(this).prop('checked', false)
            });
        }
    });

</script>
