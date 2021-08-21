<?php
/**
 * @var DatabaseHandler $databaseHandler
 * @var ProductsHandler $productsHandler
 */
include_once './includes/settings.php';
include_once './includes/autoload.php';
include_once './includes/products-handler.php';

$skuErr = $nameErr = $priceErr = $weightErr = $sizeErr = $widthErr = $heightErr = $lengthErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productType = $_POST['product-type'];
    $product = ProductFactory::makeProduct($productType, $_POST);
    $productHandler = ProductHandlerFactory::makeProductHandler($productType, $databaseHandler);

    $errors = $productHandler->validate($product);

    if (empty($errors)) {
        $productHandler->addProduct($product);
        header('Location: index.php');
    } else {
        extract($errors);
    }
}
?>

<link rel="stylesheet" type="text/css" href="styles/index.css" media="screen"/>

<form id="product_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='POST'>
    <header>
        <h1>Product List</h1>
        <script>
            function specificGetter() {
                const selection = document.getElementById('productType');
                const specific = document.getElementById('product-specific');

                const value = selection.options[selection.selectedIndex].value;
                if (value === 'Furniture') {
                    specific.innerHTML = `
                    <p>Please provide height:</p> <input id="height" type="number" name="height"> <span>CM</span>
                    <span class="error"> <?php echo $heightErr; ?></span>

                    <p>Please provide width:</p> <input id="width" type="number"  name="width"> <span>CM</span>
                    <span class="error"> <?php echo $widthErr; ?></span>

                    <p>Please provide length:</p> <input id="length" type="number"  name="length"> <span>CM</span>
                    <span class="error"> <?php echo $lengthErr; ?></span>
    `
                } else if (value === 'Book') {
                    specific.innerHTML = '<p>Please provide weight:</p> <input id="weight" type="number" name="weight"><span>KG</span>        <span class="error"> <?php echo $weightErr; ?></span> '
                } else if (value === 'DVD') {
                    specific.innerHTML = '<p>Please provide size:</p> <input id="size" type="number min=0" name="size"><span>MB</span>         <span class="error"> <?php echo $sizeErr; ?></span>'
                }

            }
        </script>
        <button type="submit">Save</button>
        <button type='button' onclick="window.location.href='index.php'">Cancel</button>
    </header>

    <div id="ultra-main">
        <p>SKU:</p> <input id="sku" type="text" name="sku">
        <span class="error"> <?php echo $skuErr; ?></span>

        <p>Name:</p> <input id="name" type="text" name="name">
        <span class="error"> <?php echo $nameErr; ?></span>

        <p>Price($):</p> <input id="price" type="number" min='0' name="price">
        <span class="error"> <?php echo $priceErr; ?></span>

        <p>Type Switcher:</p>
        Select Your product

        <select onchange="specificGetter()" id="productType" name="product-type">
            <?php
            $possibleOptions = $productsHandler->getAllProductNames();
            foreach ($possibleOptions as $possibleOption) {
                $selected = isset($productType) && $productType == $possibleOption ? 'selected' : '';
                echo "<option $selected value='$possibleOption'> $possibleOption</option>";
            }
            ?>
        </select>
        <div id='product-specific'></div>
</form>
<script>
    specificGetter()
</script>
