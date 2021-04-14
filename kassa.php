<?php 

    include "includes/header.inc.php";

    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
    }

    if(isset($_GET["barcode"])) {
        $barcode = $_GET["barcode"];
        $sql = "SELECT * FROM articles WHERE code='$barcode'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $product = ["id" => $row["id"], "name" => $row["name"], "description" => $row["description"], "price" => $row["price"]];

            if(!isset($_SESSION["products"])) {
                $_SESSION["products"] = [];
            }
            array_push($_SESSION["products"], $product);

        } else {
            #Popup with search by product-name
        }
    }
    
?>

<div class="block left">
    <div class="block-header">
        <div class="block-header-account center"><i class="fas fa-user-circle"></i></div>
        <div class="block-header-text center">Kassa</div>
    </div>

    <div class="block-main">
        <div class="block-content">
            <form>
                <input type="text" name="barcode" readonly="true" placeholder="Barcode..." id="barcode"/>
                <div class="numpad-wrapper center">
                    <div class="numpad">
                        <div onclick="AddInput(this)">1</div>
                        <div onclick="AddInput(this)">2</div>
                        <div onclick="AddInput(this)">3</div>
                        <div onclick="AddInput(this)">4</div>
                        <div onclick="AddInput(this)">5</div>
                        <div onclick="AddInput(this)">6</div>
                        <div onclick="AddInput(this)">7</div>
                        <div onclick="AddInput(this)">8</div>
                        <div onclick="AddInput(this)">9</div>
                        <div class="hidden"></div>
                        <div onclick="AddInput(this)">0</div>
                        <div class="hidden"></div>
                    </div>
                </div>
                <input type="submit" value="Product toevoegen"/>
            </form>
        </div>
    </div>
</div>

<div class="block right">
    <div class="block-header">
        <div class="block-header-account center"></div>
        <div class="block-header-text center">Ingevoerde producten</div>
    </div>

    <div class="block-main">
        <div class="block-content">
            <div class="products">
                <?php
                    $price = 0;
                    if(isset($_SESSION["products"])) {
                        foreach($_SESSION["products"] as $product) {
                            echo "
                                <div class='product'>
                                    <div class='product-header'>
                                        <div class='product-name'>" . $product["name"] . "</div>
                                        <div class='product-price'>€" . $product["price"] . "</div>
                                    </div>
                                    <div class='product-description'>" . $product["description"] . "</div>
                                </div>
                            ";

                            $price += floatval($product["price"]);
                        }
                    } else {
                        echo "Geen producten toegevoegd.";
                    }
                ?>
            </div>

            <div class="submit center">
                <div class="afrekenen center" onclick="location.href = 'bon.php';">Afrekenen</div>
            </div>

            <div class="price-total">
                <div class="price">
                    Prijs inclusief BTW<br>
                    <span class="big"><?= $price ?></span>
                </div>
                <div class="price">
                    Prijs exclusief BTW<br>
                    <span class="big"><?= number_format($price / 1.21, 2) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function AddInput(elem) {
        document.querySelector("#barcode").value += elem.innerHTML;
    }
</script>

<?php include "includes/footer.inc.php"; ?>