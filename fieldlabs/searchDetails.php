<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include("./includes/head.php");
    if (isset($_POST['request'])) {
        echo "";
        try {
            $post_id = $_GET['post_id'];
            $student_id = $_SESSION['uid'];
            $query =
                "SELECT post_id, student_id FROM requests WHERE post_id = :post_id AND student_id = :student_id";
            $stmt = dbConnect()->prepare($query);
            $stmt->execute([':post_id' => $post_id, ':student_id' => $student_id]);
            // $stmt->fetch();
            if (!$stmt->fetch()) {
                $query = "SELECT * FROM posts WHERE post_id = :post_id";
                $stmt = dbConnect()->prepare($query);
                $stmt->execute([':post_id' => $post_id]);
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $record = $stmt->fetch();
                $product_owner_id = $record["product_owner_id"];
                $query =
                    "INSERT INTO 
                requests (student_id, post_id, product_owner_id) 
                VALUES (:student_id, :post_id, :product_owner_id) ";
                $stmt = dbConnect()->prepare($query);
                $stmt->execute([
                    ':student_id' => $student_id,
                    ':post_id' => $post_id,
                    ':product_owner_id' => $product_owner_id
                ]);
            } else {
                echo "<div class='submitError'>ERROR: Je hebt deze opdracht al aangevraagd.</div>";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
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

            <!-- Search Details content -->
            <!-- <h1>Search Details</h1> -->

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
            <div class="form-container">
                <div class="darkBGsearch">
                    <h1><?php echo $title; ?></h1>
                    <article><?php echo $details; ?></article>
                    <p><?php echo $location; ?></p>
                    <p><?php echo $date; ?></p>
                    <h3><?php echo $username; ?></h3>
                    <form method="post" class="formStyle">
                        <input class="secondbutton" type="submit" name="request" value="opdracht aanvragen">
                    </form>
                    <div class="meerRuimte">
                    <a class="meerDetails" id="terugBtn" href="search.php">Terug</a>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php
    include("./includes/footer.php");
    ?>
</body>