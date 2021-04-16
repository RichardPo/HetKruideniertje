<?php

    include "includes/header.inc.php";

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]["role"] != "admin") {
            header("Location: kassa.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }

    $message = "";

    if(isset($_POST["remove"])) {
        $user_id = $_POST["remove"];
        $sql = "DELETE FROM users WHERE id='$user_id'";
        mysqli_query($conn, $sql);
        
        header("Location: team.php");
    } elseif(isset($_POST["createAccount"])) {
        $username = $_POST["username"];
        $name = $_POST["name"];
        $password = $_POST["password"];
        $role = $_POST["role"];
        if(empty($username) || empty($name) || empty($password) || empty($role)) {
            $message = "Vul alle velden in.";
        } else {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                $message = "Er is al een gebruiker met die gebruikersnaam!";
            } else {
                $sql = "INSERT INTO users (username, name, password, role) VALUES ('$username', '$name', '$password', '$role')";
                mysqli_query($conn, $sql);
            }
        }
    }

?>

<div class="beheer-header center">Teambeheer</div>

<div class="beheer-main">
    <div class="beheer-sidebar">
        <div class="sidebar-item center-vertical" onclick="location.href = 'logout.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-user-circle"></i></div>
            <div class="sidebar-item-text">Uitloggen</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'voorraad.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-cubes"></i></div>
            <div class="sidebar-item-text">Voorraad</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'team.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-users"></i></div>
            <div class="sidebar-item-text">Team</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'kassa.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-cash-register"></i></div>
            <div class="sidebar-item-text">Kassa</div>
        </div>
        <div class="sidebar-item center-vertical" onclick="location.href = 'camera.php';">
            <div class="sidebar-item-icon center"><i class="fas fa-camera"></i></div>
            <div class="sidebar-item-text">Camera</div>
        </div>
    </div>
    <div class="beheer-content">
        <div class="team">
            <?php
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "
                        <div class='lid'>
                            <b>" . $row["name"] . "</b><br>
                            " . $row["role"] . "
                            <div class='actions'>
                                <a href='team.php?remove_id=". $row["id"] ."'>Verwijderen</a>
                            </div>
                        </div>
                    ";
                }
            ?>
        </div>

        <div class="import">
            <div class="import-header center"><b>Gebruikers aanmaken</b></div>
            <div class="import-content center">
                <form method="post">
                    <label>Gebruikersnaam:</label>
                    <input type="text" name="username"/>
                    <label>Naam:</label>
                    <input type="text" name="name"/>
                    <label>Rol:</label>
                    <select name="role">
                        <option value="cashier">Kassamedewerker</option>
                        <option value="admin">Beheerder</option>
                    </select>
                    <label>Wachtwoord:</label>
                    <input type="password" name="password"/>
                    <label>Account aanmaken?</label>
                    <input type="submit" name="createAccount" value="Aanmaken"/>
                </form>
            </div>
        </div>
    </div>

    <?php
        if(isset($_GET["remove_id"])) {
            echo "
                <div class='popup-background'></div>
                <div class='popup'>
                    <h2>Verwijderen</h2>
                    Weet u zeker dat u deze gebruiker wilt verwijderen?<br><br>
                    <form method='post' class='center'><button type='submit' name='remove' value='" . $_GET["remove_id"] . "'>Ja</button><div onclick='location.href=\"team.php\"' class='center'>Nee</div></form>
                </div>
            ";
        }
    ?>
</div>

<?php 

    if(!empty($message)) {
        echo "<script>alert('" . $message . "');</script>";
    }

    include "includes/footer.inc.php"; 

?>