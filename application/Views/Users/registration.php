<div class="container">
    <div class="alert alert-danger" role="alert" id="message" style="display: none;">

    </div>
    <form method="post" id="registration_form">
        <div class="mb-3">
            <label for="exampleInputUsername" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="exampleInputUsername" aria-describedby="emailHelp" required/>
        </div>
        <div class="mb-3">
            <label for="exampleInputName" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="emailHelp" required/>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" required/>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>