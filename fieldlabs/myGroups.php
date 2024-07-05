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


            <?php
            $query = "SELECT role FROM users WHERE uid = :uid";
            $stmt = dbConnect()->prepare($query);
            $stmt->execute([':uid' => $_SESSION['uid']]);
            if ($stmt->fetch()['role'] == 'Docent') {
                $query = "SELECT * FROM requests WHERE product_owner_id = :product_owner_id";
                $stmt = dbConnect()->prepare($query);
                $stmt->execute([':product_owner_id' => $_SESSION['uid']]);
                $requests = $stmt->fetchAll();
                foreach ($requests as $request) {
                    // Post title
                    $query = "SELECT title FROM posts WHERE post_id = :post_id";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([':post_id' => $request['post_id']]);
                    $postTitle = $stmt->fetch()['title'];

                    $query = "SELECT username FROM users WHERE uid = :student_id";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([':student_id' => $request['student_id']]);
                    $username = $stmt->fetch()['username'];
                    
                    if(isset($_POST["accept".$request['id']])){
                        echo $request['id'];
                        echo "adad,lmpauyg";
                    }
                    if(isset($_POST["decline".$request['id']])){
                        echo $request['id'];
                        echo "adad,lmpauyg";
                    }

            ?>
                    <div>
                        <h4><?php echo $postTitle ?></h4>
                        <p><?php echo "$username heeft deze opdracht aangevraagd. Goedkeuren?"  ?></p>
                        <div>
                            <input type="submit" name="<?php echo "accept".$request['id'] ?>" value="Goedkeuren">
                            <input type="submit" name="<?php echo "decline".$request['id'] ?>" value="Afkeuren">
                        </div>
                    </div>
            <?php

                    // if()
                }
            }

            ?>

        </div>
    </div>

    <?php
    include("./includes/footer.php");
    ?>
</body>