<?php

// This file is your starting point (= since it's the index)
// It will contain most of the logic, to prevent making a messy mix in the html

// This line makes PHP behave in a more strict way
declare(strict_types=1);

// We are going to use session variables so we need to enable sessions
session_start();

// Use this function when you need to need an overview of these variables
function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

// TODO: provide some products (you may overwrite the example)
$products = [
    ['name' => 'Your favourite drink', 'price' => 2.5],
    ['name' => 'Your favourite sauce', 'price' => 1.5],
    ['name' => 'Your favourite snack', 'price' => 3.5]
];

$totalValue = 0;

function validate()
{
    // TODO: This function will send a list of invalid fields back
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $error = array();
    
        if(empty($_POST['email'])){ $error['email'] = "You forgot to enter your email!";}
        if(empty($_POST['street'])){$error['street'] = "You forgot to enter a street!";}
        if(empty($_POST['streetnumber'])){$error['streetnumber'] = "You forgot to enter a streetnumber!";}
        if(empty($_POST['city'])){$error['city'] = "You forgot to enter a city!";}
        if(empty($_POST['zipcode'])){$error['zipcode'] = "You forgot to enter a zipcode!";}
    
        if(!empty($error))
        {
            return $error;
            //header("Location: normal.php");
        } /*else{
            $_SERVER['PHP_SELF'];
        }*/
    }
    
}

function handleForm($products)
{

    // TODO: form related tasks (step 1)
   /**
    * Initialize empty variable for user inputs
    * remove white spaces from input values
    */
    // Defining variables
    $email = $street = $streetnumber = $city = $zipcode =  "";
    
    // Checking for a POST request
    if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
        $email = test_input($_POST["email"]);
        $street = test_input($_POST["street"]);
        $streetnumber = test_input($_POST["streetnumber"]);
        $city = test_input($_POST["city"]);
        $zipcode = test_input($_POST["zipcode"]);

    }

    // Removing the redundant HTML characters if any exist.
    if(!empty($email) && !empty($street) && !empty($streetnumber) && !empty($city) && !empty($zipcode) && !empty($_POST["products"])){
        $OrderedProducts=[];
        echo "<h2>Your Input:</h2>";
        echo "Email = ".$email." <br> street =  ".$street." <br> street Number = ".$streetnumber." <br> City = ".$city." <br> zipcode = ". $zipcode;
        echo "<br> Products = ".implode(" ",$_POST["products"]);
        foreach($_POST["products"] as $index=>$product){
            for($i=0;$i<count($products);$i++){
                if($index == $i)
                {
                    array_push($OrderedProducts,$products[$i]);
                }
            }
        }
        $showPeoduct =implode(", ", array_map(function ($entry) {
            return ($entry['name']."  ".$entry['price']);
        }, $OrderedProducts));
        echo "<br> Ordered Products = ".$showPeoduct;
    }
    // Validation (step 2)
    $invalidFields = validate();
    if (!empty($invalidFields)) {
        var_dump($invalidFields);
        // TODO: handle errors
    } else {
        // TODO: handle successful submission
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// TODO: replace this if by an actual check
$formSubmitted = false;
//if ($formSubmitted) {
if (isset($_POST['submit'])){
    handleForm($products);
}else{
    echo " testing";
}
//whatIsHappening();
require 'form-view.php';