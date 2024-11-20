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

    // Check if item is already in the cart, update quantity if it is
    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]['quantity'] += $quantity;
    } else {
        // Fetch image path from the database
        $sql = "SELECT image_path FROM products WHERE id = $item_id";
        $result = $mysqli->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image_path = $row['image_path'];

            // Add item to cart with initial quantity
            $_SESSION['cart'][$item_id] = array(
                'id' => $item_id,
                'name' => $item_name,
                'price' => $item_price,
                'quantity' => $quantity,
                'image_path' => $image_path // Include image path in the session data
            );
        }
    }

    // Redirect back to the previous page
    header("Location: cart.php");
    exit();
}

// Handle updating quantity
if (isset($_POST['update_quantity'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['cart'][$item_id])) {
        $_SESSION['cart'][$item_id]['quantity'] = $quantity;
    }

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}

// Handle removing item from cart
if (isset($_POST['remove_item'])) {
    $item_id = $_POST['item_id'];

    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
    }

    // Redirect back to the cart page
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        *{
    padding: 0;
    margin: 0;
    text-decoration: none;
    list-style: none;
    box-sizing: border-box;
  }
  body{
    font-family: montserrat;
  }
         nav{
    background: #D2E3C8;
    height: 80px;
    width: 100%;
    position: fixed;
  }

  label.logo{
    background-image: url('logo.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    color: white;
    font-size: 25px;
    line-height: 80px;
    padding: 10px 100px;
    font-weight: bold;
  }
  nav ul{
    float: right;
    margin-right: 20px;
  }
  nav ul li{
    display: inline-block;
    line-height: 80px;
    margin: 0 5px;
  }
  nav ul li a{
    color: black;
    font-size: 17px;
    padding: 7px 13px;
    border-radius: 3px;
    text-transform: uppercase;
  }
 a.active,a:hover{
    background: #4F6F52;
    transition: .5s;
  }
  .checkbtn{
    font-size: 30px;
    color: white;

    float: right;
    line-height: 80px;
    margin-right: 40px;
    cursor: pointer;
    display: none;
  }
  #check{
    display: none;
  }
  @media (max-width: 952px){
    label.logo{
      font-size: 30px;
      padding-left: 90px;
    }
    nav ul li a{
      font-size: 16px;
    }
  }
  @media (max-width: 858px){
    .checkbtn{
      display: block;
    }
    ul{
      position: fixed;
      width: 100%;
      height: 100vh;
      background: #739072;
      top: 80px;
      left: -100%;
      text-align: center;
      transition: all .5s;
    }
    nav ul li{
      display: block;
      margin: 50px 0;
      line-height: 30px;
    }
    nav ul li a{
      font-size: 20px;
    }
    a:hover,a.active{
      background: none;
      color: #D2E3C8;
    }
    #check:checked ~ ul{
      left: 0;
    }
  }
  section{
    background: url(bg1.jpg) no-repeat;
    background-size: cover;
    padding-top: 80px;
    /* height: calc(100vh - 80px); */
  }

        .container {
            padding: 20px;
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-img-top {
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            max-height: 200px;
            object-fit: cover;
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-size: 18px;
            font-weight: bold;
        }
        .card-text {
            margin-bottom: 10px;
        }
        .form-control {
            width: 100px;
            display: inline-block;
            margin-right: 10px;
            padding: 10px;
            border-radius: 10px;
            border: 1px solid black;
        }
        .btn-primary, .btn-danger {
            margin-top: 10px;
            background-color: #4F6F52;
            color: white;
            padding: 10px;
            border-radius: 10px;
            border: none;
        }
       
    </style>
    <script>
        function confirmUpdate() {
            return confirm("Are you sure you want to update the quantity?");
        }

        function confirmRemove() {
            return confirm("Are you sure you want to remove this item from the cart?");
        }
    </script>
</head>

<body>
    <nav>
        <input type="checkbox" id="check">
        <label for="check" class="checkbtn">
            <i class="fas fa-bars"></i>
        </label>
        <label class="logo"></label>
        <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">viewcart</a></li>
        </ul>
    </nav>
    <section></section>
  
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) : ?>
    <div class="container">
        <div class="row">
            <?php foreach ($_SESSION['cart'] as $item) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">

                        <img src="<?php echo $item['image_path']; ?>" class="card-img-top" alt="<?php echo $item['name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name']; ?></h5>
                            <p class="card-text">Price: <?php echo $item['price']; ?></p>
                            <p class="card-text">Quantity: <?php echo $item['quantity']; ?></p>
                            <form action="" method="post">
                                <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                                <input class="form-control" type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <button class="btn btn-primary mt-2" type="submit" name="update_quantity" onclick="return confirmUpdate()">Update</button>
                                <button class="btn btn-danger mt-2" type="submit" name="remove_item" onclick="return confirmRemove()">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else : ?>
    <p id="empty_cart">Cart is empty.</p>
<?php endif; ?>

</body>

</html>