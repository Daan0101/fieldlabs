<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include("./includes/head.php");

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

            <!-- Search Details content -->
            <h1>Search Details</h1>

            <?php
            $post_id = $_GET['post_id'];
            $query = "SELECT * FROM posts WHERE post_id = :post_id";

            $stmt = dbConnect()->prepare($query);

            $stmt->execute([':post_id' => $post_id]);

            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $record = $stmt->fetch();
            $title = $record["title"];
            $details =  $record["details"];
            $post_id =  $record["post_id"];
            $location =  $record["location"];
            $date = $record["date"];
            // -----------------------------------
            $query = "SELECT username FROM users WHERE uid = :uid";
            $stmt = dbConnect()->prepare($query);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute(['uid' => $_SESSION['uid']]);
            $record = $stmt->fetch();
            $username = $record['username'];
            // -----------------------------------

            ?>
            <div>
                <h1><?php echo $title; ?></h1>
                <article><?php echo $details; ?></article>
                <p><?php echo $location; ?></p>
                <p><?php echo $date; ?></p>
                <h5><?php echo $username; ?></h5>
            </div>
            

        </div>
    </div>

    <?php
    include("./includes/footer.php");
    ?>
</body>