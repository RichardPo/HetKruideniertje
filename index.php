<?php 

    include "includes/header.inc.php";

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]["role"] == "admin") {
            header("Location: voorraad.php");
        } else {
            header("Location: kassa.php");
        }
    }

    $message = "";

    if(isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        if(empty($username) || empty($password)) {
            $message = "Vul de beide velden in.";
        } else {
            $sql = "SELECT * FROM users WHERE username='$username'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if($row["password"] == $password) {
                    $_SESSION["user"]["id"] = $row["id"];
                    $_SESSION["user"]["username"] = $row["username"];
                    $_SESSION["user"]["name"] = $row["name"];
                    $_SESSION["user"]["role"] = $row["role"];
                    header("Location: index.php");
                    exit();
                } else {
                    $message = "De gebruikersnaam en het wachtwoord komen niet overeen. Probeer het nog een keer.";
                }
            } else {
                $message = "Geen gebruiker gevonden met die gebruikersnaam. Probeer het nog een keer.";
            }
        }
    }
    
?>

<div class="container center">
    <form method="post" action="">
        <h2>Inloggen</h2>
        <label>Gebruikersnaam:</label><br>
        <input type="text" name="username"/><br><br>
        <label>Wachtwoord:</label><br>
        <input type="password" name="password"/><br><br>
        <input type="submit" name="login" value="Inloggen"/><br><br>
        <?= empty($message) ? "" : "<div class='message red'>" . $message . "</div>" ?>
    </form>
</div>

<?php include "includes/footer.inc.php"; ?>