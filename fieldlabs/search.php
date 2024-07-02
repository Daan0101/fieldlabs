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

    <div class="container">
        <div class="main-content">
            <div>
                <!-- Search content -->
                <!-- <h1>Search</h1> -->

                <?php
                try {
                    $query = "SELECT * FROM posts";
                    $conn = dbConnect();
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $records = $stmt->fetchAll();
                    foreach ($records as $record) {
                        // var_dump($record);
                        $title = $record["title"];
                        $details = $record["details"];
                        $post_id = $record["post_id"];

                        $url = "searchDetails.php?post_id=$post_id";
                        // -----------------------------------
                        $query = "SELECT username FROM users WHERE uid = :uid";
                        $stmt = dbConnect()->prepare($query);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt->execute(['uid' => $_SESSION['uid']]);
                        $record = $stmt->fetch();
                        $username = $record['username'];
                        // -----------------------------------
                
                        ?>
                        <div class="form-container">
                            <h1><?php echo $title; ?></h1>
                            <article><?php echo $details; ?></article>
                            <h5><?php echo "opdrachtgever: " . $username; ?></h5>
                        <a href="<?php echo $url ?>">Meer details</a>
                        </div>
                        <?php
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }

                ?>

            </div>
        </div>
    </div>

    <?php
    include ("./includes/footer.php");
    ?>
</body>