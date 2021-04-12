<?php 

    include "includes/header.inc.php";
    
    if(!isset($_SESSION["user"])) {
        header("Location: login.php");
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
                <div class="product">
                    <div class="product-header">
                        <div class="product-name">Appels</div>
                        <div class="product-price">€2,99</div>
                    </div>
                    <div class="product-description">Heerlijke sappige appels uit het zomerseizoen bla bla bla (weet ik veel)</div>
                </div>
            </div>

            <div class="submit center">
                <div class="afrekenen center">Afrekenen</div>
            </div>

            <div class="price-total">
                <div class="price">
                    Prijs inclusief BTW<br>
                    <span class="big">€350,50</span>
                </div>
                <div class="price">
                    Prijs exclusief BTW<br>
                    <span class="big">310,15</span>
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