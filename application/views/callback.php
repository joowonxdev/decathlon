<!DOCTYPE html>
<html>
<body>
<style>
    input{
        width:300px;
    }
</style>
<form action="https://bs-provider.prod.connect.eu-west-3.k8s.fewlines.net/oauth/token" method="post" enctype="application/x-www-form-urlencoded">
    code : <input type="text" name="client_id" value="<?=$client_id?>"><br>
    client_id : <input type="text" name="client_secret" value="<?=$client_secret?>"><br>
    client_secret : <input type="text" name="code" value="<?=$code?>"><br>
    grant_type : <input type="text" name="grant_type" value="<?=$grant_type?>"><br>
    redirect_uri : <input type="text" name="redirect_uri" value="<?=$redirect_uri?>"><br>
    <input type="submit">
</form>

</body>
</html>