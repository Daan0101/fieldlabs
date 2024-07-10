<!DOCTYPE html>
<html lang="en">
<head>
<?php

include ("./includes/head.php");

?>
</head>
<body>
<?php
    include ("./includes/header.php");
    ?>

    <?php
    include ("./includes/navbar.php");
    ?>
    <div class="main-content">

    <form action="" method="post">
        <input type="text" name="token" id="token" placeholder="your token"></input>
        <br>
        <input type="submit" value="submit">
    </form>
    </div>
    <?php
    include ("./includes/footer.php");
    ?>
</body>
</html>

<?php

if (isset($_POST['token'])) {
    $token = $_POST['token'];

    $cURLConnection = curl_init();

    $url = 'https://www.authenticatorapi.com/pair.aspx?AppName=YourAppName&AppInfo=YourAppInfo&SecretCode=' . $token;
    curl_setopt($cURLConnection, CURLOPT_URL, $url);

    curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);

    $apiResponse = curl_exec($cURLConnection);

    if(curl_errno($cURLConnection)){
        echo 'cURL error: ' . curl_error($cURLConnection);
    } else {
        
        echo $apiResponse;
    }

    curl_close($cURLConnection);
}

?>