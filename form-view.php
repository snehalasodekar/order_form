<?php // This file is mostly containing things for your view / html ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>puppylov store</title>
</head>
<body>
<div class="container">
    <div class=" float-end">
        <form method="post">
            <button class="btn btn-primary" type="newOrder" id="newOrder" name="newOrder">New Order</button>
        </form>
    </div>
    <h1>Place your order</h1>
    <?php // Navigation for when you need it ?>
    <?php /*
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    */ ?>
    
     <form method="post" id="userDetails" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input id="email" name="email" class="form-control" <?php
                if(isset( $_SESSION['email'])){
                    $emailVal = $_SESSION['email'];
                   echo "value = '$emailVal'";
                }
                ?>/>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" <?php
                    if(isset( $_SESSION['street'])){
                        $streetVal = $_SESSION['street'];
                    echo "value = '$streetVal'";
                    }
                ?>/>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control"  <?php
                    if(isset( $_SESSION['streetnumber'])){
                        $streetnumberVal = $_SESSION['streetnumber'];
                    echo "value = '$streetnumberVal'";
                    }
                ?>/>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control"  <?php
                    if(isset( $_SESSION['city'])){
                        $cityVal = $_SESSION['city'];
                    echo "value = '$cityVal'";
                    }
                ?>/>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control"  <?php
                    if(isset( $_SESSION['zipcode'])){
                        $zipcodeVal = $_SESSION['zipcode'];
                        echo "value = '$zipcodeVal'";
                    }
                ?>/>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
                    <?php // <?= is equal to <?php echo ?>
                    <input type="checkbox" value="<?php echo $i ?>" name="products[<?php echo $i ?>]" <?php if (isset($_SESSION['products'][$i])){echo 'checked';}?> /> 
                    <?php echo $product['name'] ?> - &euro; <?= number_format($product['price'], 2) ?>
                </label><br />
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" class="btn btn-primary" name="submit" onclick="return comfirm('Please confirm your order');" />Order!</button>
    </form>
    

    <footer>You already ordered <strong>&euro; <?php
                    if(isset( $_SESSION['orderTotal'])){
                        $orderTotalVal = $_SESSION['orderTotal'];
                        echo "value = '$orderTotalVal'";
                    }
                ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>

<script>
function clickMe(){
//var result ="<?php hideDiv(); ?>"
document.write(result);
}
</script>
</body>
</html>
