<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Decathlon Test </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="/decathlon/css/custom.css">

    <script
            src="http://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="/decathlon/js/basic.js"></script>
</head>
<body>
<?
if(MENU_TOP){
?>
<div class="container">
<div class="row">
    <div class="col-8 float-left">
        <p class="h1 "><?=TITLE?></p>
        <p class="h6 "><a href='/decathlon/oauth/tokenExchange'><?=MOVETO?></a></p>
    </div>
    <div class="col-4">
        <ul class="list-unstyled  float-right">
            <li><a><strong><?=USER_NAME?> </strong>님이 로그인 중이십니다.</a></li>
            <li><a href='/decathlon/oauth/logout'>LOG OUT</a></li>
        </ul>

    </div>
</div>
</div>
<?
}
?>