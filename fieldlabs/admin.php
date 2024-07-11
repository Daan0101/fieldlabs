<!DOCTYPE html>
<html lang="en">

<head>
    <?php include ("./includes/head.php"); ?>
</head>

<body>
    <?php include ("./includes/header.php"); ?>
    <?php include ("./includes/navbar.php"); ?>
    <div class="container">
        <!-- Check of de user een admin is -->
        <?php
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: ./login.php");
            exit();
        }

        ?>
        <!-- Main content -->
        <div class="main-content">
            <form action="" method="post">

                <select name="username" id="username">
                    <option value="none" selected disabled>Selecteer een gebruiker</option>
                    <?php
                    $query = "SELECT * FROM users";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute();
                    $result = $stmt->fetchAll();
                    foreach ($result as $row) {
                        echo "<option value='" . $row['uid'] . "'>" . $row['username'] . "</option>";
                    }
                    ?>
                </select>

                <!-- dropdown with all roles -->
                <select name="role" id="role">
                    <option value="none" selected disabled>Selecteer een rol</option>
                    <!-- <option value="Admin">Admin</option> -->
                    <option value="Docent">Docent</option>
                    <option value="Student">Student</option>
                </select>

                <!-- submit button -->
                <input type="submit" name="submit" value="update">
            </form>

            <?php
            try {
                if (isset($_POST['submit'])) {
                    $uid = $_POST['username'];
                    $role = $_POST['role'];
                    $query = "UPDATE users SET role = :role WHERE uid = :uid";
                    $stmt = dbConnect()->prepare($query);
                    $stmt->execute([':role' => $role, ':uid' => $uid]);

                    echo "<script type=\"text/javascript\">toastr.success('The user has been updated')</script>";

                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
            ?>
        </div>
    </div>
    <?php include ("./includes/footer.php"); ?>
</body>

</html>