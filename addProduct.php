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

    if($_POST) {
        $barcode = $_POST["barcode"];
        $productname = $_POST["productname"];
        $description = $_POST["description"];
        $group_id = $_POST["group"];
        $unit = $_POST["unit"];
        $supplier = $_POST["supplier"];
        $price = $_POST["price"];
        $stock= $_POST["stock"];

        if(empty($barcode) || empty($productname) || empty($description) || empty($group_id) || empty($unit) || empty($supplier) || empty($price) || empty($stock)) {
            #Send error-message
        } else {
            $sql = "SELECT * FROM articles WHERE code='$barcode' OR name='$productname'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                #Send error-message
            } else {
                $sql = "INSERT INTO articles (code, name, description, unit, supplier, price, stock, group_id) VALUES ('$barcode', '$productname', '$description', '$unit', '$supplier', '$price', '$stock', '$group_id')";
                mysqli_query($conn, $sql);
                header("Location: voorraad.php");
            }
        }
    }

?>