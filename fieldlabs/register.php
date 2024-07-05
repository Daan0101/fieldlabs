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
        <div id="form-container">
            <!-- Register content -->
            <h1>Register</h1>
                    <form method="post">
                        <div class="row">
                            <label for="email">Email</label>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="row">
                            <label for="username">username</label>
                        </div>
                        <input type="text" class="form-control" id="username" name="username" required>

                        <div class="row">
                            <label for="role">Role</label>
                        </div>
                        <select id="role" name="role" class="form-control" required>
                            <option value="Student">Student</option>
                            <option value="Docent">Docent</option>
                        </select>
                        <div class="row">
                            <button class="styleButton" id="btnLogin" type="submit" name="register" class="btn btn-primary">Register</button>
                        </div>
                    </form>
            </div>
            <?php

            register($conn);

            ?>

        </div>
    </div>

    <?php

    register($conn) 
    
    ?>

    <?php
    include ("./includes/footer.php");
    ?>
</body>