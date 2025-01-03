<?php
session_start();
require_once '../connection.php';

// Check if the user is logged in
if (!isset($_SESSION['is_login']) || $_SESSION['is_login'] !== true) {
    $_SESSION['error'] = 'You must log in first';
    header('Location: customer_login.php');
    exit;
}

// Fetch data from the database
$sql = "SELECT dogs.*, breed.breed_name FROM dogs JOIN breed ON dogs.breed_id = breed.id";
$result = mysqli_query($conn, $sql);

$dogsData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dogsData[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Index</title>
    <link rel="stylesheet" href="css/customer_index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div id="header">
        <a href="#"><i class="fa-solid fa-paw"></i></a>
        <nav>
            <ul>
                <li><a href="customer_index.php">Home</a></li>
                <li><a href="customer_about.php">About</a></li>
                <li><a href="customer_contact.php">Contact</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="../index/index.php">Logout</a></li>
                <a href="customer_view_cart.php" id="cart-icon" class="icon"><i class="fas fa-shopping-cart"></i></a>
            </ul>
        </nav>
    </div>

    <div id="content">
        <h1>Pet Pal</h1>
        <h2>One Friend, Thousand More Funs!</h2>
        <a href="#shopnow"><button>Shop Now</button></a>
    </div>

    <div id="featured-pets">
        <h2>Featured Pets</h2>
        <div class="line"></div>
        <p>Check out our selection of pets</p>
        <a href="#shopnow"><button>Shop More</button></a>
    </div>

    <div class="container" id="shopnow">
        <?php foreach ($dogsData as $dog) : ?>
            <div class="item">
                <div class="image">
                    <img src="../admin/uploads/<?= htmlspecialchars($dog['image']) ?>" alt="<?= htmlspecialchars($dog['breed_name']) ?>">
                </div>
                <div class="details">
                    <h3 class="breed"><?= htmlspecialchars($dog['breed_name']) ?></h3>
                    <p class="price">Rs <?= htmlspecialchars($dog['price']) ?></p>
                    <a href="customer_view.php?id=<?= $dog['id'] ?>" class="view-button"><button>View</button></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer>
        <div class="footer">
            <div class="heading">
                <i class="fa-solid fa-shield-dog"></i>
                <h2>PetPal</h2>
            </div>
            <div class="content">
                <div class="services">
                    <p>Welcome to PetPal, your go-to platform for finding your perfect canine companion. Welcome to PetPal: Your Ultimate Dog Ordering System
                    PetPal is your go-to platform for finding and ordering your perfect canine companion.
                    Whether you're looking for a loyal companion, an energetic playmate, or a cuddly friend, 
                    PetPal has a wide selection of dogs to choose from.
                    With PetPal, you can browse through various breeds, ages, and sizes of dogs, all conveniently categorized to help you find your ideal match.
                    Our intuitive interface allows you to explore detailed profiles of each dog, including their photos, descriptions, and adoption status.</p>
                </div>
                <div class="links">
                    <h4>Quick Links</h4>
                    <!-- <p><a href="customer_index.php">Home</a></p> -->
                    <p><a href="customer_about.php">About</a></p>
                    <p><a href="customer_contact.php">Contact</a></p>
                    <p><a href="#shopnow">Shop</a></p>
                </div>
                <div class="details">
                    <h4>Address</h4>
                    <p>Bhaktapur,Suryabinayak</p>
                    <h4>Mobile</h4>
                    <p><a href="#">+977 9810102344</a></p>
                    <h4>Email</h4>
                    <p><a href="#">petpal@gmail.com</a></p>
                </div>
            </div>
            <div class="l-footer">
                <p>Copyright © 2024 All Rights Reserved</p>
            </div>
        </div>
    </footer>
</body>
</html>
