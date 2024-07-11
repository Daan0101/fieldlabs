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
            <div class="form-container">
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
                        $product_owner_id = $record['product_owner_id'];
                        $url = "searchDetails.php?post_id=$post_id";
                        // -----------------------------------
                        $query = "SELECT username FROM users WHERE uid = :uid";
                        $stmt = dbConnect()->prepare($query);
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        $stmt->execute(['uid' => $record['product_owner_id']]);
                        $record = $stmt->fetch();
                        $username = $record['username'];
                        // -----------------------------------

                ?>
                        <div class="darkBGsearch" <?php
                        if ($product_owner_id == $_SESSION['uid']) {
                            echo 'style="border: 2px solid lightgreen;"' ;
                        }?>>
                            <h1><?php echo $title; ?></h1>
                            <p class="details"><?php echo $details; ?></p>
                            <h5><?php echo "opdrachtgever: " . $username; ?></h5>
                            <a class="meerDetails" href="<?php echo $url ?>">Meer details</a>
                            <?php
                            if ($product_owner_id == $_SESSION['uid']) {
                                $urll = "editPost.php?id=$post_id"
                                ?>
                            <b>Jouw opdracht</b>
                            
                            <a href="<?php echo $urll?>">Edit</a>
                                <?php
                                echo '';
                            }
                            ?>
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
    </div>

    <?php
    include("./includes/footer.php");
    ?>
</body>