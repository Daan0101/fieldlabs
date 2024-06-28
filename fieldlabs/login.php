<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("./includes/head.php"); ?>
</head>

<body>
    <?php include("./includes/header.php"); ?>
    <?php include("./includes/navbar.php"); ?>

    <div class="container">
        <div class="main-content">
            <div class="row">
                <h1 class="title">Login!</h1>
                <div id="form-container">
                    <form method="post">
                        <div class="row">
                            <label for="email">Email</label>
                        </div>
                        <input type="email" class="form-control" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        <div class="row">
                            <button class="styleButton" id="btnLogin" type="submit" name="getQR" class="btn btn-primary">Get QR</button>
                        </div>
                    </form>
                </div>
                <?php

                getQrToken($conn);

                ?>

                    <form method="post" action="">
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="form-group col-lg-4" style="text-align:center">
                                <input type="text" class="form-control" name="pin" minlength="4" maxlength="6" required />
                                <br><br>
                                <button class="styleButton" id="btnLogin" name="submit-pin" type="submit" class="btn btn-primary">Enter</button>
                            </div>
                            <div class="col-lg-4"></div>
                        </div>
                    </form>

                <?php

                login($conn);

                ?>
            </div>
        </div>
    </div>

    <?php include("./includes/footer.php"); ?>
</body>

</html>
