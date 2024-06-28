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

        <!-- Main content -->
        <div class="main-content">

            <?php
            showButtons($conn);
            ?>

        </div>

    </div>
    </div>

    <?php
    include ("./includes/footer.php");
    ?>
</body>