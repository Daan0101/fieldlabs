<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("./includes/head.php"); ?>
</head>

<body>
    <?php include("./includes/header.php"); ?>
    <?php include("./includes/navbar.php"); ?>

    <div class="container">
        <div class="main-content">
            <div class="row">
                <h1>Login!</h1>
                <form action="" method="post">
                    <div class="row">
                        <label for="email">Email</label>
                    </div>
                    <input type="email" class="form-control" id="email" name="email">
                    <div class="row">
                        <button type="submit" name="getQR" class="btn btn-primary">Get QR</button>
                    </div>
                </form>
                <?php

                if (isset($_POST['getQR'])) {

                    $email = $_POST['email'];

                    $stmt = $conn->prepare("SELECT token FROM users WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    // check if email is in database
                    if ($stmt->rowCount() == 0) {
                        echo "<script type=\"text/javascript\">toastr.error('There are no emails found')</script>";
                        exit;

                    } else {
                        echo "<script type=\"text/javascript\">toastr.success('Enter the pin from the Authenticator App')</script>";
                    }

                    // Fetched de token uit de database
                    $token = $stmt->fetchColumn();
                    // set token in a session
                    $_SESSION['token'] = $token;

                    // debug
                    //echo $token;
                }

                ?>

                <form method="post" action="">
                    <div class="row">
                        <div class="col-lg-4"></div>
                        <div class="form-group col-lg-4" style="text-align:center">
                            <input type="text" class="form-control" name="pin" minlength="4" maxlength="6" required />
                            <br><br>
                            <button name="submit-pin" type="submit" class="btn btn-primary">Enter</button>
                        </div>
                        <div class="col-lg-4"></div>
                    </div>
                </form>

                <?php

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-pin'])) {
                    $pin = $_POST['pin'];
                    $token = $_SESSION['token'];

                    if (validate_pin($pin, $token) == 'True') {
                        echo "<script type=\"text/javascript\">toastr.success('Login successful')</script>";
                        
                        $stmt = $conn->prepare("SELECT uid FROM users WHERE email = :email");
                        $stmt->bindParam(':email', $email);
                        $stmt->execute();
                        $uid = $stmt->fetchColumn();

                        $_SESSION['uid'] = $uid;

                        header("Location: index.php");
                    } else {
                        // PIN is invalid
                        echo '<h1>Invalid</h1>';
                    }
                }

                function makeApiRequest($apiUrl) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $apiUrl);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    return $response;
                }

                function validate_pin($pin, $token) {
                    $apiUrl = 'https://www.authenticatorapi.com/Validate.aspx?Pin=' . $pin . '&SecretCode=' . $token;
                    $response = makeApiRequest($apiUrl);
                    return trim(strip_tags($response));

                }

                ?>
            </div>
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>
</body>

</html>
