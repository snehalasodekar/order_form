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
        $errors = array();
    
        if(empty($_POST['email'])){ $errors['email'] = "You forgot to enter an email!";}
        if(empty($_POST['street'])){$errors['street'] = "You forgot to enter a street!";}
        if(empty($_POST['streetnumber'])){$errors['streetnumber'] = "You forgot to enter a streetnumber!";}
        if(empty($_POST['city'])){$errors['city'] = "You forgot to enter a city!";}
        if(empty($_POST['zipcode'])){$errors['zipcode'] = "You forgot to enter a zipcode!";}
        if(empty($_POST['products'])){$errors['products'] = 'You need to choose one of our products!'; }

        if(!empty($errors))
        {
            return $errors;
            //header("Location: normal.php");
        } /*else{
            $_SERVER['PHP_SELF'];
        }*/
    }
    
}

function handleForm($products,$totalValue)
{
//echo "BECODE = ".$totalValue."<br/>";
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
        setSession($email,$street,$streetnumber,$city,$zipcode,$products,$totalValue);
    }

    
    // Validation (step 2)
    $invalidFields = validate();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-warning'>";
        echo "Enter valid Email address";
        echo "</div>";
    }
    if (!ctype_digit($zipcode)) {
        echo "<div class='alert alert-warning'>";
        echo "Enter valid zipcode. Zipcode must be numeric";
        echo "</div>";
    }
    if (!empty($invalidFields)) {
       // var_dump($invalidFields);
            forEach($invalidFields as $error){
                echo "<div class='alert alert-warning'>";
                echo $error;
                echo "</div>";
            }
        // TODO: handle errors
    } else {
        // TODO: handle successful submission


        $OrderedProducts=[];
        // if(isset($_POST['confirm'])){

        // }
        // if(isset($_POST['cancel'])){
        //     session_unset();
        // }
        echo "<div class='container' id='orderDetails'><div class='row'><div class='col-12 col-md-4 offset-md-4 p-3 border border-success'>";
        echo "<h2>Your order is successful</h2>";
        
        echo "<div><h5>Email : ".$email."</h5>";
        echo "<div>Address :  <ul style='list-style:none;'><li> street :  ".$street." </li><li> street Number : ".$streetnumber."</li><li> City : ".$city."</li><li>Zipcode : ".$zipcode."</li></ul></div>";
       echo "<div> Ordered Products : <br/><ul style='list-style:none;'>".$showProduct=getOrderedProducts($products)."</ul></div>";
        echo "<div> Total Value = ".$orderTotal = calculateTotalOrderValue($products,$totalValue)."</div>";
        echo "<p>If the information above is correct press confirm otherwise press cancel</p>";
        echo " <form method='post'><button type='reset' name='confirm' class='btn btn-outline-success btn-sm m-1'>Confirm</button>";
        echo "<button type='button' name='reset' class='btn btn-outline-warning btn-sm m-1' onclick='clickMe()'>Cancel</button></form>";
        echo "</div> </div> </div>";
        

        
    }
}

/**
 * get 
*
function hideDiv(){
    orderDetails
}*/
function getOrderedProducts($products){
    $showProduct = implode("<li> ", array_map(function ($entry) {
            return ($entry['name']."  ".$entry['price']);
        }, $products));
    return $showProduct;
}
function calculateTotalOrderValue($products,$totalValue){
    $OrderedProducts =[];
    foreach($products as $index=>$product){
        for($i=0;$i<count($products);$i++){
            if($index == $i)
            {
                array_push($OrderedProducts,$products[$i]);
            }
        }
    }
    //$totalValue = calculateOrder($OrderedProducts);
    $add = 0;
    forEach($OrderedProducts as $index =>$value){
        $add = $add + $value['price'];
    }
    return $add;
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    if(substr($data, -1) == '/') {
        $data = substr($data, 0, -1);
    }
    return $data;
}


/**
 * Set session variables
 * $email,$street,$streetnumber,$city,$zipcode,$products
 */
function setSession($email,$street,$streetnumber,$city,$zipcode,$products,$totalValue){
    $_SESSION["email"] = $email;
        $_SESSION["city"] = $city;
        $_SESSION["street"] = $street;
        $_SESSION["streetnumber"] = $streetnumber;
        $_SESSION["zipcode"] = $zipcode;
        if (isset($_POST['products'])){
            foreach ($_POST['products'] as $i => $product){
                $_SESSION['products'][$i] = $product;
            }
        }
      //  $_SESSION["products"] = $products; // we didn't use showproduct variable because we need ordered products array to use further  
        $_SESSION["orderTotal"] = calculateTotalOrderValue($products,$totalValue);
}
/**
 * End session
 */
if (isset($_POST['newOrder'])){
    session_unset();
}

// TODO: replace this if by an actual check
$formSubmitted = false;
//if ($formSubmitted) {
if (isset($_POST['submit'])){
    handleForm($products,$totalValue);
}else{
   // echo " testing";
}
//whatIsHappening();
require 'form-view.php';

