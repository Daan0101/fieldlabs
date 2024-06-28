<?php

/***************************************************************************/

function dbConnect()
{
    try {
        $servername = "localhost";
        $database = "fieldlabs";
        $dsn = "mysql:host=$servername;dbname=$database";
        $username = "root";
        $password = "";

        $conn = new PDO($dsn, $username, $password);
        return $conn;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

/***************************************************************************/

function getQrToken($conn) {
    if (isset($_POST['getQR'])) {

        $email = $_POST['email'];

        $stmt = $conn->prepare("SELECT token FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Set email in an session
        $_SESSION['email'] = $email;

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
}

/***************************************************************************/

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

/***************************************************************************/

function login($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit-pin'])) {
        $pin = $_POST['pin'];
        $email = $_SESSION['email'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $array = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($array) {

            $_SESSION['username'] = $array['username'] ?? null;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $array['role'] ?? null;
            $_SESSION['token'] = $array['token'] ?? null;

            $token = $_SESSION['token'];

            if (validate_pin($pin, $token) == 'True') {
                echo "<script type=\"text/javascript\">toastr.success('Login successful')</script>";
                
                // Fetch the UID
                $stmt = $conn->prepare("SELECT uid FROM users WHERE email = :email");
                $stmt->bindParam(':email', $email);
                $stmt->execute();
                $uid = $stmt->fetchColumn();

                $_SESSION['uid'] = $uid;

                header("Location: index.php");
            } else {
                echo "<script type=\"text/javascript\">toastr.error('Invalid PIN')</script>";
            }
        } else {
            echo "<script type=\"text/javascript\">toastr.error('User not found')</script>";
        }
    }
}


/***************************************************************************/

function genToken() {
    $token = bin2hex(random_bytes(32));

    return $token;
}

/***************************************************************************/

function register($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
        $email = $_POST['email'];
        $role = $_POST['role'];
        $token = genToken();

        

        // DEBUG
        //echo $token;
    }
}

/***************************************************************************/

function showButtons ($conn){
    if (isset($_SESSION['role']) && $_SESSION['role'] == 'Docent') {
        echo '<div class="column">
                    <a href="../fieldlabs/post.php" class="styleButton" id="btnPost"><i
                            class="fa-solid fa-arrow-right icon"></i>Plaats opdracht <i
                            class="fa-solid fa-arrow-left icon"></i></a>';
    } else if (isset($_SESSION['role']) && $_SESSION['role'] == 'Student') {
        echo '<div class="column">
        <a href="../fieldlabs/myGroups.php" class="styleButton" id="btnMyGroups"><i
                        class="fa-solid fa-arrow-right icon"></i>Mijn groepen <i
                        class="fa-solid fa-arrow-left icon"></i></a>

            <a href="../fieldlabs/search.php" class="styleButton" id="btnSearch"><i
                            class="fa-solid fa-arrow-right icon"></i>Zoek opdracht <i
                            class="fa-solid fa-arrow-left icon"></i></a>
            
        </div>';
    }
}


?>
