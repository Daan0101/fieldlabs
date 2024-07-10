<nav class="sidenav">
    <ul>
        <?php

        if (isset($_SESSION['uid'])) {
            $query = "SELECT * FROM users WHERE uid = :uid";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':uid', $_SESSION['uid']);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $data = $stmt->fetch();
            $username = $data['username'];
            $role = $data['role']; 
            // Navigatie voor beide rollen
            echo '
            <li><div class="navRow"><p class="username">Ingelogd als: ' . $role . '</p><a href="../fieldlabs/index.php"><i class="fa-solid fa-house"></i>Home</a></div></li>
            <li><div class="navRow"><a href="../fieldlabs/search.php"><i class="fa-solid fa-magnifying-glass"></i>Search</a></div></li>
            <li><div class="navRow"><a href="../fieldlabs/myGroups.php"><i class="fa-solid fa-users"></i>My Groups</a></div></li>
            ';

            // Navigatie voor docenten
            if ($role === 'Docent') {
                echo '
                <li><div class="navRow"><a href="../fieldlabs/post.php"><i class="fa-solid fa-pen-to-square"></i>Post</a></div></li>
                ';
            }
            // Navigatie voor beide rollen
            echo '
            <li><div class="navRow"><a href="../fieldlabs/logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></div></li>
            <li><div class="navRow"><p class="username">Username: ' . $username . '</p></div></li>
            ';
        } else {
            // Links voor degene die niet zijn ingelogd
            echo '
            <li><div class="navRow"><a href="../fieldlabs/register.php"><i class="fa-solid fa-user-plus"></i>Register</a></div></li>
            <li><div class="navRow"><a href="../fieldlabs/login.php"><i class="fa-solid fa-right-to-bracket"></i>Login</a></div></li>
            ';
        }

        ?>
    </ul>
</nav>