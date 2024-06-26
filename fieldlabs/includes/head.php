<!-- meta tags -->

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- title -->
<title>Fieldlabs</title>

<!-- Toastr Notification -->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

<!-- Css -->
<link href="../fieldlabs/assets/css/style.css" rel="stylesheet"/>

<!-- Fontawesome -->
<script src="https://kit.fontawesome.com/b801578fa3.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="../fieldlabs/assets/images/favicon.ico">

<!-- PHP Session and connection with database -->

<?php

session_start();

include("./functions/functions.php");
$conn = dbConnect();

if (!isset($_SESSION['uid'])) {
    // echo "<script>location.href='../fieldlabs/login.php'</script>";

    //header("Location: login.php");
}

?>