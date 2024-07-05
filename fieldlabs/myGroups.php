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
    if($_POST['done']){
        $query = "DELETE FROM student_posts WHERE student_id = :student_id";

        
    }
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



            ?>
                    <div>
                        <h4><?php echo $postTitle ?></h4>
                        <p><?php echo "$username heeft deze opdracht aangevraagd. Goedkeuren?"  ?></p>
                        <form method="post">
                            <input type="submit" name="<?php echo "accept" . $request['id'] ?>" value="Goedkeuren">
                            <input type="submit" name="<?php echo "decline" . $request['id'] ?>" value="Afkeuren">
                        </form>
                    </div>
                    <?php
                    if (isset($_POST["accept" . $request['id']])) {
                        deleteRecord($request['id']);
                        // echo $request['id'];
                        $query = "INSERT INTO student_posts (post_id, student_id) VALUES(:post_id, :student_id)";
                        $stmt = dbConnect()->prepare($query);
                        $stmt->execute([':post_id' => $request['post_id'], 'student_id' => $request['student_id']]);
                        echo "adad,lmpauyg";
                    }
                    if (isset($_POST["decline" . $request['id']])) {
                        echo $request['id'];
                        deleteRecord($request['id']);
                        echo "adad,lmpauyg";
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
                    <div class="form-container">
                        <div class="darkBGsearch">
                            <h1><?php echo $title; ?></h1>
                            <article><?php echo $details; ?></article>
                            <p><?php echo $location; ?></p>
                            <p><?php echo $date; ?></p>
                            <h3>Neem contact op met <?php echo $username; ?>.</h3>
                            <input type="submit" name="done" value="Opdracht afronden">
                        </div>
                    </div>
        </div>


        ?>
<?php

                }
            }
?>

    </div>
    </div>

    <?php

    function deleteRecord($requestId)
    {
        $query = "DELETE FROM requests WHERE id = :requestId";
        $stmt = dbConnect()->prepare($query);
        $stmt->execute([':requestId' => $requestId]);
    }
    include("./includes/footer.php");
    ?>
</body>