<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" name="token" id="token" placeholder="your token"></input>
        <input type="submit">
    </form>
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