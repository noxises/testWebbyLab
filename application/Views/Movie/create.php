<div class="container">
    <a href="" style="display: none;" id="link_to_movie"> To created Movie</a>
    <div class="alert alert-danger" role="alert" id="message" style="display: none;">
    </div>
    <h3>Add</h3>
    <form method="post" id="create" name="create">
        <div class="form-floating mb-3">
            <input type="text" name="title" class="form-control" id="floatingInput" placeholder="Title">
            <label for="floatingInput">Title</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="year" class="form-control" id="floatingPassword" placeholder="2000">
            <label for="floatingPassword">Release year</label>
        </div>
        <div class="form-floating mb-3">
            <select class="form-select" name="format" id="floatingSelect" aria-label="Floating label select example">
                <option selected>Open this select menu</option>
                <option value="VHS">VHS</option>
                <option value="DVD">DVD</option>
                <option value="Blu-ray">Blu-ray</option>
            </select>
            <label for="floatingSelect">Format</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="actors" id="floatingPassword" placeholder="Actors">
            <label for="floatingPassword">Actors</label>
        </div>
        <button type="submit" form="create" class="btn btn-primary">Submit</button>
    </form>
    <h3>Add from file</h3>
    <form class="row g-3" method="post" name="txt_film" id="txt_film">
        <div class="col-auto">
            <input type="file" class="form-control" name="file" id="staticEmail2" required/>
        </div>

        <div class="col-auto">
            <button type="submit" form="txt_film" class=" col-auto btn btn-primary mb-3">send</button>
        </div>
    </form>
</div>