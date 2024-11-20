<?php
session_start();

// Assuming you have a database connection already established
$mysqli = new mysqli('localhost', 'root', '', 'greentea');

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['add_to_cart'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $item_price = $_POST['item_price'];
    $quantity = 1; // Set default quantity to 1

    // Fetch image path from the database
    $sql = "SELECT image_path FROM products WHERE id = $item_id";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];

        // Check if item is already in the cart, update quantity if it is
        if (isset($_SESSION['cart'][$item_id])) {
            $_SESSION['cart'][$item_id]['quantity'] += $quantity;
        } else {
            // Add item to cart with initial quantity and image path
            $_SESSION['cart'][$item_id] = array(
                'id' => $item_id,
                'name' => $item_name,
                'price' => $item_price,
                'quantity' => $quantity,
                'image_path' => $image_path
            );
        }

        // Redirect back to the previous page
        header("Location: cart.php");
        exit();
    } else {
        echo "Error: Unable to fetch image path from the database.";
    }
}
?>
