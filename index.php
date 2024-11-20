
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    
  </head>
  <body>
    <nav>
      <input type="checkbox" id="check">
      <label for="check" class="checkbtn">
        <i class="fas fa-bars"></i>
      </label>
      <label class="logo"></label>
      <ul>
        <li><a class="active" href="#Home">Home</a></li>
        <li><a href="#About">About</a></li>
        <li><a href="#Contact">Contact</a></li>
        <li><a href="#Service">Services</a></li>
        <li><a href="cart.php">viewcart</a></li>
      </ul>
    </nav>
    <section></section>

    <div class="slideshow-container">

      <!-- Full-width images with number and caption text -->
      <div class="mySlides fade" id="Home">
        <div class="numbertext">1 / 4</div>
        <img src="bg.png" style="width:100%;">
        <!-- <div class="text">Caption Text</div> -->
      </div>

      <div class="mySlides fade">
        <div class="numbertext">2 / 4</div>
        <img src="slider0.jpg" style="width:100%;">
        <div class="text">Caption Two</div>
      </div>

      <div class="mySlides fade">
        <div class="numbertext">3 / 4</div>
        <img src="slider.jpg" style="width:100%;">
        <div class="text">Caption Three</div>
      </div>

      <div class="mySlides fade">
        <div class="numbertext">4 / 4</div>
        <img src="slider2.jpg" style="width:100%;">
        <div class="text">Caption Three</div>
      </div>

      <!-- Next and previous buttons -->
      <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
      <!-- <a class="next" onclick="plusSlides(1)">&#10095;</a> -->

      <br>

      <!-- The dots/circles -->
      <div style="text-align:center">
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
      </div>
    </div>
    <!-- new 0-->
    <div class="about-section" id="About">
      <h1>About GreenTea</h1>
      <p>At GreenTea.com, we are passionate about bringing the finest quality green tea products to our customers. Our
        journey began with a simple mission: to share the incredible health benefits and delightful taste of green tea
        with the world.Over the years, we have forged strong partnerships with trusted tea growers and suppliers who share
        our commitment to quality and sustainability. Through meticulous craftsmanship and dedication to preserving the
        integrity of the tea leaves, we ensure that every cup of green tea you enjoy is a true reflection of nature's
        goodness.At GreenTea.com, our mission is to promote well-being and vitality through the consumption of green tea.
        We believe in harnessing the natural power of this ancient beverage to enhance the health and happiness of our
        customers.When you choose GreenTea.com, you can trust that you are getting the best of nature's bounty in every
        cup. Join us on a journey of wellness and discovery as we explore the world of green tea together.</p>
      <p>Resize the browser window to see that this page is responsive by the way.</p>
    </div>
    <!-- new -->
    <section class="item01">
      <div class="row">
        <div class="column">
          <div class="card"><img src="thumb.jpg" alt="cofeeseed">
            <p class="paragraph1">Coffee bean</p>
          </div>
        </div>
        <div class="column">
          <div class="card"><img src="thumb0.jpg" alt="glass">
            <p class="paragraph1">Plastic Coffee Cup</p>
          </div>
        </div>
        <div class="column">
          <div class="card"><img src="thumb1.jpg" alt="rolle">
            <p class="paragraph1">mini-croissants</p>
          </div>
        </div>
        <div class="column">
          <div class="card"><img src="thumb2.jpg" alt="cofeeglass">
            <p class="paragraph1">coffee mug</p>
          </div>
        </div>
      </div>
    </section>
    <!-- new 01-->
    <div class="download">
      <img src="download.png" alt="download">
      <p class="TRENDING_PRODUCTS">TRENDING PRODUCTS</p>
    </div>

    <?php
    // Establish database connection (replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "greentea";
  
    if(isset($_GET['contact'])) {
      echo '<script>alert("Thank You! We will get back to you soon.");</script>';
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
  
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
  
    // Fetch data from the database
    $sql = "SELECT id, item_name, item_price, image_path FROM products";
    $result = $conn->query($sql);
  
    // Display fetched data
    if ($result->num_rows > 0) {
      // output data of each row
      while ($row = $result->fetch_assoc()) {
        echo "<div class='card01'>";
        echo "<img src='" . $row["image_path"] . "' alt='" . $row["item_name"] . "' style='width:100%'>";
        echo "<h2>" . $row["item_name"] . "</h2>";
        echo "<p class='price'>" . $row["item_price"] . "</p>";
        echo "<form method='post' action='add_to_cart.php'>";
        echo "<input type='hidden' name='item_id' value='" . $row["id"] . "'>"; // Add hidden input for item ID
        echo "<input type='hidden' name='item_name' value='" . $row["item_name"] . "'>";
        echo "<input type='hidden' name='item_price' value='" . $row["item_price"] . "'>";
        echo "<button type='submit' class='btnadd' name='add_to_cart'>Add to Cart</button>";
        echo "</form>";
        echo "</div>";
      }
    }
 else {
      echo "0 results";
    }
  
    // Close the database connection
    $conn->close();
    ?>
    <!-- contactus -->
    <center>
      <div class="container" id="Contact">
        <h1>Contact Us</h1>
        <form class="contact-form" action="contactus.php" method="post">
          <div class="input-area">
            <input type="text" placeholder="Your name" name="name" />
          </div>
          <div class="input-area">
            <input type="email" placeholder="Email address" name="email" />
          </div>
          <div class="input-area">
            <input type="text" placeholder="phone number"  name="phone"/>
          </div>
          <div class="input-area h-80">
            <textarea placeholder="message" name="message"></textarea>
          </div>
          <button class="sendbtn" type="submit" value="submit" name="submit">Send</button>
        </form>
      </div>
    </center>
    <!-- footer starts -->
    <footer id="Service">

      <div class="footer-panel1">
        Back to top
      </div>
      <div class="footer-panel2">
        <ul class="footer01">
          <p>
          <h3>About us</h3>
          </p>
          <a>About us</a>
          <a>Our Difference</a>
          <a>Community Matters</a>
          <a>Blog</a>
          <a>Bouqs Vedio</a>
        </ul>
        <ul class="footer01">
          <p>
          <h3>Services</h3>
          </p>
          <a>Orders</a>
          <a>Help Center</a>
          <a>Shipping</a>
          <a>Term of use</a>
          <a>Account Details</a>
          <a>My Account</a>
        </ul>
        <ul class="footer01">
          <p>
          <h3>Local</h3>
          </p>
          <a> Mangalore</a>
          <a>Bangalore</a>
          <a>Chikkamagalore</a>
          <a>Skaleshapura</a>
        </ul>
        <ul class="footer01">
          <p>
          <h3>Let Us Help You</h3>
          </p>
          <a>Your Account</a>
          <a>Your Orders</a>
          <a>Shipping Rates & Policies</a>
          <a>Returns & Replacements</a>
          <a>Manage Your Content and Devices Assistant</a>
          <a>Help</a>
        </ul>
      </div>
      <div class="foot-panel3">
        <div class="logo"></div>
      </div>
      <div class="foot-panel4">
        <div class="pages">

        </div>
      </div>
      <div class="copyrights">
        <a href="#">Conditions of Use</a>
        <a href="#"> Privacy Notice</a>
        <a href="#">Your Ads Privacy Choices</a>
      </div>
      <div class="copyrights"><span> © 1996-2024, GreenTea.com, Inc. or its affiliates</span>
      </div>
    </footer>
    <script src="script.js"></script>
  </body>

  </html>