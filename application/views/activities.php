<div class="container" >
    <hr/>
    <div class="row ">
        <div class="col-3 left-main">
            <ul class="sport-list list-group">

            </ul>
        </div>
        <div class="col-9 right-main">
            <div class="class-info d-none">
                <h3 class="class-name"></h3>
                <h5 class="class-price"></h5>
                <hr/>
                <button type="button" class="btn btn-primary btn-lg apply-class d-none" >apply class</button>
                <button type="button" class="btn btn-primary btn-lg regist-class d-none" disabled>regist class</button>
                <hr/>
                <p class="class-description"></p>
                <hr/>
            </div>
            <ul class="class-list list-group">

            </ul>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".container").ready(function() {
        sports_cate();
    });
</script>

