<?php

    include "includes/header.inc.php";

    if(!isset($_SESSION["user"]) || !isset($_SESSION["products"])) {
        header("Location: kassa.php");
        exit();
    }

    $bonProducts = [];

    foreach($_SESSION["products"] as $product) {
        $id = $product["id"];
        $sql = "SELECT stock FROM articles WHERE id='$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $stock = (int) $row["stock"];
        $stock -= 1;
        if($stock < 0) {
            $stock = 0;
        }
        $sql = "UPDATE articles SET stock='$stock' WHERE id='$id'";
        mysqli_query($conn, $sql);

        array_push($bonProducts, $product);
    }

    $_SESSION["products"] = null;

?>

<div class="container center">
    <div class="bon">
        <h2>Bon</h2>
        <?php
            foreach($bonProducts as $product) {
                echo "<div class='bon-product'><b>" . $product["name"] . "</b> €" . $product["price"] . "</div>";
            }
        ?>

        <div class="bon-next center" onclick="location.href = 'kassa.php';">Volgende klant</div>
    </div>
</div>