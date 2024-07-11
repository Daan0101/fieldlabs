<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("./includes/head.php");

    // Check if the user's role is 'Docent'
    if ($_SESSION['role'] !== 'Docent') {
        // If not, redirect them to an access denied page or the homepage
        header("Location: ./");
        exit(); // Prevent further execution of the script
    }

    include_once("./functions/functions.php"); // Include functions file only once

    try {
        if (isset($_POST['submit'])) {
            $title = $_POST['title'];
            $location = $_POST['location'];
            $details = $_POST['details'];
            $date = $_POST['date'];

            $query = "UPDATE posts SET title =:title, location = :location, product_owner_id = :product_owner_id, date = :date, details = :details WHERE post_id=:post_id";

            $stmt = dbConnect()->prepare($query);

            $stmt->execute([
                ':title' => $title,
                ':location' => $location,
                ':details' => $details,
                ':date' => $date,
                ':product_owner_id' => $_GET['id'],
            ]);
            header('Location: search.php');
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
                    <?php

                    $id = $_GET['id'];

                    $query = "SELECT * from posts WHERE post_id = :id";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([':id' => $id]);
                    $stmt->setFetchMode(PDO::FETCH_OBJ);
                    $post=$stmt->fetch();
                    ?>
                    <h1>Plaats een opdracht</h1>
                    <form method="post">
                        <input type="text" name="title" placeholder="Titel.." value="<?php echo $post->title?>">
                        <input type="text" name="location" placeholder="Locatie.."value="<?php  echo$post->location?>">
                        <textarea rows="4" cols="30" name="details" placeholder="Opdracht details.." ><?php echo $post->details?></textarea>
                        <input type="date" name="date"value="<?php echo $post->date?>">
                        <input class="styleButton" type="submit" name="submit" value="Edit opdracht..">
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