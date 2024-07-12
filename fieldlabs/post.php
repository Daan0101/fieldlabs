<!DOCTYPE html>
<html lang="en">

<head>
<?php
include("./includes/head.php");

// Check if the user's role is 'Docent'
//if ($_SESSION['role'] !== 'Docent') {
    // If not, redirect them to an access denied page or the homepage
    //header("Location: ./");
    //exit(); // Prevent further execution of the script
//}

include_once("./functions/functions.php"); // Include functions file only once

try {
    if (isset($_POST['submit'])) {
        $title = $_POST['title'];
        $location = $_POST['location'];
        $details = $_POST['details'];
        $date = $_POST['date'];

        $query = "INSERT INTO posts (title, location, product_owner_id, date, details) VALUES (:title, :location, :product_owner_id, :date, :details)";

        $stmt = dbConnect()->prepare($query);

        $stmt->execute([
            ':title' => $title,
            ':location' => $location,
            ':details' => $details,
            ':date' => $date,
            ':product_owner_id' => $_SESSION['uid'],
        ]);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
</head>

<body>

    <?php
    include("./includes/header.php");
    ?>

    <?php
    include("./includes/navbar.php");
    ?>

    <div class="container">
        <div class="main-content">

            <div class="darkBGpost">
                <div class="form-container">
                    <!-- Post content -->
                    <h1>Plaats een opdracht</h1>
                    <form method="post">
                        <input type="text" name="title" placeholder="Titel..">
                        <input type="text" name="location" placeholder="Locatie..">
                        <textarea rows="4" cols="30" name="details" placeholder="Opdracht details.."></textarea>
                        <input type="date" name="date">
                        <input class="styleButton" type="submit" name="submit" value="Plaats opdracht..">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    include("./includes/footer.php");
    ?>
</body>
</html>