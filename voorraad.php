<?php

    include "includes/header.inc.php";

    if(isset($_SESSION["user"])) {
        if($_SESSION["user"]["role"] != "admin") {
            header("Location: kassa.php");
        }
    } else {
        header("Location: login.php");
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

?>

<div class="beheer-header center">Voorraad</div>

<div class="beheer-main">
    <div class="beheer-sidebar">
        <div class="sidebar-item">
            <div class="sidebar-item-icon center"><i class="fas fa-user-circle"></i></div>
            <div class="sidebar-item-text">Account</div>
        </div>
        <div class="sidebar-item">
            <div class="sidebar-item-icon center"><i class="fas fa-users"></i></div>
            <div class="sidebar-item-text">Teambeheer</div>
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
                                </table>
                            </div>
                        ";
                    }
                } else {
                    echo "Geen producten in de voorraad.";
                }
            ?>
        </div>

        <div class="import-voorraad center">
        </div>
    </div>
</div>

<?php include "includes/footer.inc.php"; ?>