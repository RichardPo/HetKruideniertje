<?php

    include "includes/header.inc.php";

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]["role"] != "admin") {
            header("Location: kassa.php");
            exit();
        }
    } else {
        header("Location: index.php");
        exit();
    }

    $products = [];

    $sql = "";
    if(isset($_GET["group"])) {
        $group_id = $_GET["group"];
        if(!empty($group_id)) {
            $sql = "SELECT * FROM articles WHERE group_id='$group_id'";
        } else {
            $sql = "SELECT * FROM articles";
        }
    } else {
        $sql = "SELECT * FROM articles";
    }

    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        $group_id = $row["group_id"];
        $sql = "SELECT * FROM `group` WHERE id='$group_id'";
        $result2 = mysqli_query($conn, $sql);
        $productgroup = mysqli_fetch_assoc($result2);
        $product = $row;
        $product["productgroup"] = $productgroup["name"];
        array_push($products, $product);
    }

    if(isset($_POST["remove"])) {
        $product_id = $_POST["remove"];
        $sql = "DELETE FROM articles WHERE id='$product_id'";
        mysqli_query($conn, $sql);
        
        header("Location: voorraad.php");
    }

?>

<div class="beheer-header center">Voorraad</div>

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
        <div class="filter">
            <form>
                <label>Kies een productgroep...</label>
                <select name="group">
                    <option value="">Niets geselecteerd</option>
                    <?php
                        $sql = "SELECT * FROM `group`";
                        $result = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                        }
                    ?>
                </select>
                <input type="submit" value="Filteren"/>
            </form>
        </div>

        <div class="voorraad">
            <?php  
                if(count($products) > 0) {
                    foreach($products as $product) {
                        echo "
                            <div class='product'>
                                <table>
                                    <tr>
                                        <td><b>Productnaam</b></td>
                                        <td>" . $product["name"] . "</td>
                                        <td><b>Prijs</b></td>
                                        <td>€" . $product["price"] . "</td>
                                    </tr>
                                    <tr>
                                        <td><b>Voorraad</b></td>
                                        <td>" . $product["stock"] . "</td>
                                        <td><b>Leverancier</b></td>
                                        <td>" . $product["supplier"] . "</td>
                                    </tr>
                                    <tr>
                                        <td><b>Productgroep</b></td>
                                        <td>" . $product["productgroup"] . "</td>
                                        <td><b>Afdeling</b></td>
                                        <td>" . $product["unit"] . "</td>
                                    </tr>
                                    <tr>
                                        <td><b>Barcode</b></td>
                                        <td>" . $product["code"] . "</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                        ";
                    }
                } else {
                    echo "Geen producten in de voorraad.";
                }
            ?>
        </div>

        <div class="import">
            <div class="import-header center"><b>Gebruikers aanmaken</b></div>
            <div class="import-content center">
                <div class="import-block-left">
                    <form action="addProduct.php" method="post">
                        <label>Barcode</label>
                        <input type="number" name="barcode"/>
                        <label>Productnaam</label>
                        <input type="text" name="productname"/>
                        <label>Beschrijving</label>
                        <input type="text" name="description"/>
                        <label>Prijs</label>
                        <input type="number" name="price"/>
                        <label>Productgroep</label>
                        <select name="group">
                            <?php
                                $sql = "SELECT * FROM `group`";
                                $result = mysqli_query($conn, $sql);
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
                                }
                            ?>
                        </select>
                        <label>Afdeling</label>
                        <input type="text" name="unit"/>
                        <label>Voorraad</label>
                        <input type="number" name="stock"/>
                        <label>Leverancier</label>
                        <input type="text" name="supplier"/>
                        <label>Aanmaken?</label>
                        <input type="submit" value="Aanmaken"/>
                    </form>
                </div>

                <div class="import-block-right center">
                    <div class="remove-btn" onclick="location.href = 'voorraad.php?popup';">Producten verwijderen...</div>
                </div>
            </div>
        </div>
    </div>

    <?php
        if(isset($_GET["popup"])) {
            echo "
                <div class='popup-background'></div>
                <div class='popup'>
                    <h2>Verwijderen</h2>
                    <form method='get' style='width: 100%;'>
                        <select name='remove_id'>
                ";

                foreach($products as $article) {
                    echo "<option value='" . $article["id"] . "'>" . $article["name"] . "</option>";
                }

                echo "
                        </select><br><br>
                        <button type='submit' name='remove' value='" . $_GET["remove_id"] . "'>Ja</button>
                        <div onclick='location.href=\"voorraad.php\"' class='center'>Sluiten</div>
                    </form>
                </div>
                ";
        }
        else if(isset($_GET["remove_id"])) {
            echo "
                <div class='popup-background'></div>
                <div class='popup'>
                    <h2>Verwijderen</h2>
                    Weet u zeker dat u dit product wilt verwijderen?<br><br>
                    <form method='post' class='center'><button type='submit' name='remove' value='" . $_GET["remove_id"] . "'>Ja</button><div onclick='location.href=\"team.php\"' class='center'>Nee</div></form>
                </div>
            ";
        }
    ?>
</div>

<?php include "includes/footer.inc.php"; ?>