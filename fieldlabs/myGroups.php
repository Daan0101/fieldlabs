<!DOCTYPE html>
<html lang="en">

<head>
    <?php

    include("./includes/head.php");
    // var_dump($_POST);
    ?>
</head>

<body>

<?php
include("./includes/header.php");

// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['done'])) {
    echo "";

    try {
        // Verify that the session variable is set
        if (!isset($_SESSION['uid'])) {
            throw new Exception("Error: User is not logged in.");
        }

        // Debug: Check session value
        echo "";

        // Fetch the student post
        $query = "SELECT * FROM student_posts WHERE student_id = :student_id";
        $stmt = dbConnect()->prepare($query);
        $stmt->execute([':student_id' => $_SESSION['uid']]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Check query result
        if ($row) {
            echo "";
            $post_id = $row['post_id'];
            $student_id = $_SESSION['uid'];

            // Check if the request is already complete
            $query = "SELECT * FROM request_complete WHERE post_id = :post_id AND student_id = :student_id";
            $stmt = dbConnect()->prepare($query);
            $stmt->execute([':post_id' => $post_id, ':student_id' => $student_id]);

            if ($stmt->fetch()) {
                echo "";
            } else {
                // Fetch the product owner ID
                $query = "SELECT * FROM posts WHERE post_id = :post_id";
                $stmt = dbConnect()->prepare($query);
                $stmt->execute([':post_id' => $post_id]);
                $record = $stmt->fetch(PDO::FETCH_ASSOC);

                // Debug: Check posts query result
                if ($record) {
                    echo "";
                    $product_owner_id = $record["product_owner_id"];

                    // Insert the request completion record
                    $query = "INSERT INTO request_complete (student_id, post_id, product_owner_id) VALUES (:student_id, :post_id, :product_owner_id)";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([
                        ':student_id' => $student_id,
                        ':post_id' => $post_id,
                        ':product_owner_id' => $product_owner_id
                    ]);

                    echo "<div class='submitError'>Request successfully completed.</div>";
                }
            }
        } 
    } catch (PDOException $e) {
        echo "";
    } catch (Exception $e) {
        echo "";
    }
}
?>






    <?php
    include("./includes/navbar.php");
    ?>

    <div class="container">
        <div class="main-content">
            <div class="darkBGmygroups">
                <?php
                $query = "SELECT role FROM users WHERE uid = :uid";
                $stmt = dbConnect()->prepare($query);
                $stmt->execute([':uid' => $_SESSION['uid']]);
                if ($stmt->fetch()['role'] == 'Docent') {

                ?>
                    <h3>Requests van studenten.</h3>

                    <?php
                    $request = [];
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



                    ?>
                        <div>

                            <div class="form-container2">
                                <h4><?php echo $postTitle ?></h4>
                                <p class="details"><?php echo "$username heeft deze opdracht aangevraagd. Goedkeuren?"  ?></p>
                                <form method="post" class="formChoice">
                                    <input class="styleButton" type="submit" name="<?php echo "accept" . $request['id'] ?>" value="Goedkeuren"><br>
                                    <input class="styleButton" type="submit" name="<?php echo "decline" . $request['id'] ?>" value="Afkeuren">
                                </form>
                            </div>
                        </div>
                        <?php
                        if (isset($_POST["accept" . $request['id']])) {
                            deleteRecord($request['id']);
                            // echo $request['id'];
                            $query = "INSERT INTO student_posts (post_id, student_id) VALUES(:post_id, :student_id)";
                            $stmt = dbConnect()->prepare($query);
                            $stmt->execute([':post_id' => $request['post_id'], 'student_id' => $request['student_id']]);
                        }
                        if (isset($_POST["decline" . $request['id']])) {
                            deleteRecord($request['id']);
                        }
                    }
                    //  ---------------------------------------------
                    $request = [];
                    $query = "SELECT * FROM request_complete WHERE product_owner_id = :product_owner_id";
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



                        ?>
                        <div>
                            <h4><?php echo $postTitle ?></h4>
                            <p><?php echo "$username wilt deze opdracht afronden. Goedkeuren?"  ?></p>
                            <form method="post" class="formChoice">
                                <input class="styleButton" type="submit" name="<?php echo "accept_complete" . $request['id'] ?>" value="Goedkeuren">
                                <input class="styleButton" type="submit" name="<?php echo "decline_complete" . $request['id'] ?>" value="Afkeuren">
                            </form>
                        </div>
                        <?php
                        if (isset($_POST["accept_complete" . $request['id']])) {
                            $query = "DELETE FROM request_complete WHERE id = :requestId";
                            $stmt = dbConnect()->prepare($query);
                            $stmt->execute([':requestId' =>  $request['id']]);
                            $query = "DELETE FROM student_posts WHERE student_id = :student_id";
                            $stmt = dbConnect()->prepare($query);
                            $stmt->execute(['student_id' => $request['student_id']]);
                            $query = "DELETE FROM posts WHERE post_id = :post_id";
                            $stmt = dbConnect()->prepare($query);
                            $stmt->execute(['post_id' => $request['post_id']]);
                            header("Refresh:0");
                        }
                        if (isset($_POST["decline_complete" . $request['id']])) {
                            $query = "DELETE FROM request_complete WHERE id = :requestId";
                            $stmt = dbConnect()->prepare($query);
                            $stmt->execute([':requestId' =>  $request['id']]);
                            header("Refresh:0");
                        }
                    }
                } else {
                    $query = "SELECT * FROM student_posts WHERE student_id = :student_id";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([':student_id' => $_SESSION['uid']]);

                    if ($post = $stmt->fetch()) {
                        $query = "SELECT * FROM posts WHERE post_id = :post_id";
                        $stmt = dbConnect()->prepare($query);
                        $stmt->execute([':post_id' => $post['post_id']]);
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
                        $stmt->execute(['uid' => $record['product_owner_id']]);
                        $record = $stmt->fetch();
                        $username = $record['username'];
                        // -----------------------------------

                        ?>
                        <div class="form-container3">

                            <h1><?php echo $title; ?></h1>
                            <p class="details"><?php echo $details; ?></p>
                            <p><?php echo $location; ?></p>
                            <p><?php echo $date; ?></p>
                            <h3>Neem contact op met <?php echo $username; ?>.</h3>
                            <form method="post">
                                <input class="styleButton" type="submit" name="done" value="Opdracht afronden">
                            </form>

                        </div>
            </div>

    <?php

                    }
                }
    ?>
        </div>
        
            <?php
            if (getRole() == 'Docent') {
            ?>
            <div class="darkBGmygroups">
                <h2>Jouw groep(en)</h2>
                <?php
                $stmt =  dbConnect()->prepare(
                    "SELECT * FROM student_posts"
                );
                $stmt->execute();
                $result = $stmt->fetchAll();
                foreach ($result as $record) {
                    $stmt = dbConnect()->prepare("SELECT * from users WHERE uid = :uid");
                    $stmt->execute([':uid' => $record['student_id']]); 
                    $username = $stmt->fetch()['username'];
                    $post_id = $record['post_id'];
                    $stmt =  dbConnect()->prepare(
                        "SELECT * FROM posts WHERE post_id = :post_id"
                    );
                    $stmt->execute([':post_id' => $post_id]);
                    $record = $stmt->fetch();
                    if(!$record['product_owner_id' ] == $_SESSION['uid']){ continue; }

                    $title = $record["title"];
                    $details =  $record["details"];
                    $post_id =  $record["post_id"];
                    $location =  $record["location"];
                    $date = $record["date"];
                    // -----------------------------------
                    $query = "SELECT username FROM users WHERE uid = :uid";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute(['uid' => $record['product_owner_id']]);
                    $record = $stmt->fetch();
                    // $username = $record['username'];
                    // -----------------------------------

                ?>
                    <!-- <div > -->
                        <div >
                            <h1><?php echo $title; ?></h1>
                            <article class="details2"><?php echo $details; ?></article>
                            <p><?php echo $location; ?></p>
                            <p><?php echo $date; ?></p>
                            <h3>Student: <?php echo $username; ?></h3>
                    <!-- </div> -->
                    </div>
                     <?php
                    }
                }
                        ?>
        </div>
    </div>


    </div>

    <?php

    function deleteRecord($requestId)
    {
        $query = "DELETE FROM requests WHERE id = :requestId";
        $stmt = dbConnect()->prepare($query);
        $stmt->execute([':requestId' => $requestId]);
        header("Refresh:0");

    }
    include("./includes/footer.php");
    ?>
</body>