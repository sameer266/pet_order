<?php
session_start();
require_once '../connection.php';
if (isset($_GET['id'])) {
    // Retrieve the dog ID from the URL
    $dogId = $_GET['id'];
    
    // Fetch data from the database for the specific dog using the ID
    $sql = "SELECT dogs.*, breed.breed_name, size ,color
        FROM dogs 
        JOIN breed ON dogs.breed_id = breed.id 
                
        WHERE dogs.id = $dogId";


    $result = mysqli_query($conn, $sql);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

#header {
    display: flex;
    align-items: center;
    height: 80px;
    justify-content: space-between;
    padding: 20px 80px;
    background-color: black;
    position: sticky;
    top: 0;
    left: 0;
    z-index: 1;
}

nav ul {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

nav li {
    list-style: none;
    padding: 0 20px;
}

nav li a {
    position: relative;
    text-decoration: none;
    font-size: 20px;
    color: white;
    transition: 0.3s ease;
    padding: 5px 20px;
    border-radius: 5px;
}

nav li a:hover {
    background-color: grey;
    color: white;
}

nav ul ul {
    position: absolute;
    display: none;
    padding: 5px;
}

nav ul .dropdown:hover ul {
    position: absolute;
    display: block;
    flex-direction: column;
    right: 0;
}

nav ul ul li {
    margin-top: 12px;
}

nav ul ul li a {
    color: white;
}
#header .fa-paw {
    color: white;
    position: relative;
    font-size: 60px;
    right: 55px;
}
.container {
    position: relative;
    width:100%;
    margin-top: 10px;
}

.item {
    position: relative;
    height: 220px;
    box-sizing: border-box;
    background-color: #010700;
    
    
}



.image img {
    width: 20%;
    height: 195px;
    position: relative;
    top: 12px;
    left: 10px;
    
}

.details {
    padding: 20px;
}
.title{ 
    box-sizing: border-box;
    position: absolute;
    left: 310px;
    top: 40px;
    color: azure;
   
    
    
}

.title h1{
    position: relative;
    bottom: 2px;
    font-family: sans-serif;
    font-size: 25px;
    margin-bottom: 10px;
    color: #eaf0f7;
}

.price {
    font-weight: bold;
    color: #d96405;
}

/* Icons */
.icons {
    position: relative;
    display: flex;
    justify-content:end;
    top: 20px;
    gap: 15px;
    align-items: center;
}

.icon {
    color: #6c757d;
    font-size: 20px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.icon:hover {
    color: orange;
}
.buy button{
    position: relative;
    border: none;
    background-color:  #0770fa;
    padding: 10px 20px;
    color: white;
    border-radius: 4px;
    bottom:200px;
    left: 61%;
    cursor: pointer;
}
.add-to-cart button{
    position: relative;
    border: none;
    background-color: #cc8b0a;
    padding: 10px 20px;
    color: white;
    border-radius: 4px;
    bottom: 185px;  
    right: 560px;
    cursor: pointer;
}






/* /////////////////////////////////content//////////////////////// */

</style>

<body>

<div id="header">
    <a href="#"><i class="fas fa-paw"></i></a>
       <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index_about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
               
                <a href="index_view_cart.php" id="cart-icon" class="icon"><i class="fas fa-shopping-cart"></i> <span id="cart-badge" class="badge"></span></a>
            </ul>
        </nav>
    </div>

    <div class="container">
        <?php while($dog=mysqli_fetch_assoc($result)) { ?>
            <div class="item">
                <div class="image">
                    <img src="../admin/uploads/<?= $dog['image'] ?>" alt="<?= $dog['breed'] ?>">
                </div>
                <div class="title">
                    <h1><?= $dog['breed_name'] ?></h1>
                    <p>Gender:<?= $dog['gender'] ?></p>
                    <p>Age: <?= $dog['age'] ?></p>
                    <p>Size: <?= $dog['size'] ?></p>
                    <p>Color: <?= $dog['color'] ?></p>
                    <p>Description: <?= $dog['description'] ?></p>
                    <p>Price: <?= $dog['price'] ?></p>
                </div>
            </div>
            <div class="icons">
            <a href="" class="icon add-to-cart" data-dog-id="<?= $dog['id'] ?>" >
            <button onclick="redirectToLogin(event)">Add to Cart</button></a>
                        
            </div>
           
            <div class="buy">
                <a href=""><button>Buy Now</button></a>
            </div>
        <?php } ?>
    </div>
    <script>
    function redirectToLogin(event) {
        // Prevent the default action of following the link
        event.preventDefault();
        
        // Show an alert message to the user
        alert('You must log in to add this pet to cart.');
        
        // Redirect the user to the login page
        window.location.href = '../customer/customer_login.php';
    }
</script>
    

</body>

</html>
