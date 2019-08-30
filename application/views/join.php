<div class="container">
    <h1 class="text-center"> JOIN </h1>
        <form class="form-horizontal" method="post"  action="/decathlon/oauth/add_user">
            <div class="col-12">
                <label for="username">USER ID</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="userid" name="userid" placeholder="USER ID" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your user id is required.
                    </div>
                </div>
            </div>
            <div class="col-12">
                <label for="username">USER NAME</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="username" name="username" placeholder="USER NAME" required>
                    <div class="invalid-feedback" style="width: 100%;">
                        Your username is required.
                    </div>
                </div>
            </div>
            <hr class="col-12">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Join</button>
        </form>
</div>