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

            <div class="column">
                <a href="../fieldlabs/myGroups.php" class="LoginButton" id="btnMyGroups"><i
                        class="fa-solid fa-arrow-right icon"></i>Mijn groepen <i
                        class="fa-solid fa-arrow-left icon"></i></a>
                <div class="column">
                    <a href="../fieldlabs/post.php" class="LoginButton" id="btnPost"><i
                            class="fa-solid fa-arrow-right icon"></i>Plaats opdracht <i
                            class="fa-solid fa-arrow-left icon"></i></a>
                    <a href="../fieldlabs/search.php" class="LoginButton" id="btnSearch"><i
                            class="fa-solid fa-arrow-right icon"></i>Zoek opdracht <i
                            class="fa-solid fa-arrow-left icon"></i></a>
                </div>
            </div>

        </div>

    </div>
    </div>

    <?php
    include ("./includes/footer.php");
    ?>
</body>