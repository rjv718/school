<!-- Assignment-10 – COSC 2328 – Professor McCurry -->
<!-- Implemented by - Robert Vera -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Truck Fanatic Order</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
$message = '';
try {
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=final24', 'root', 'Bertaroni718');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if form data has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Insert customer information into the 'customers' table
        $stmt = $pdo->prepare("INSERT INTO customers (phone, name, address, zipCode) VALUES (:phone, :name, :address, :zipCode)");
        $stmt->bindParam(':phone', $_POST['phone']);
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':address', $_POST['address']);
        $stmt->bindParam(':zipCode', $_POST['zipCode']);
        $stmt->execute();

        // Get the last inserted customer ID
        $lastCustomerId = $pdo->lastInsertId();

        // Calculate total price based on the selected taco and quantity
        $tacoPrice = 0;
        switch ($_POST['product']) {
            case "baconEgg":
                $tacoPrice = 3;
                break;
            case "beanCheese":
                $tacoPrice = 2;
                break;
            case "chickenFajita":
                $tacoPrice = 5;
                break;
            case "beefFajita":
                $tacoPrice = 6;
                break;
            default:
                $tacoPrice = 0;
                break;
        }
        $totalPrice = $tacoPrice * $_POST['quantity'];

        // Insert order information into the 'orders' table
        $stmt = $pdo->prepare("INSERT INTO orders (customer_id, taco_name, quantity, drink, total_price) VALUES (:customerid, :tacoName, :quantity, :drink, :totalPrice)");
        $stmt->bindParam(':customerid', $lastCustomerId);
        $stmt->bindParam(':tacoName', $_POST['product']);
        $stmt->bindParam(':quantity', $_POST['quantity']);
        $stmt->bindParam(':drink', $_POST['drink']);
        $stmt->bindParam(':totalPrice', $totalPrice);
        $stmt->execute();

        $message = "<div class='success-message'>Order created successfully. Customer ID: $lastCustomerId</div>";
    }
} catch(PDOException $e) {
    $message = "<div class='error-message'>Error: " . $e->getMessage() . "</div>";
}

$pdo = null;
?>

<body>

    <div class="container">
        <h1>Food Truck Fanatic Order</h1>
        <form action="" method="post">
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" placeholder="###-###-####" required>
            <button type="button" onclick="validatePhoneNumber()">Submit</button>
        </form>
    
        <form id="otherInfo" style="display: none;" action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Enter your address" required><br>
            <label for="zipCode">ZIP Code:</label>
            <input type="text" id="zipCode" name="zipCode" placeholder="Enter your ZIP code" required><br>
            <button type="button" onclick="otherInfo()">Submit</button>
        </form> 



        <!-- Menu Ordering-->
        <h2>Our Menu</h2>
        <h3> Tacos </h3>
        <!-- Taco 1-->
        <form action="" method="post">
        <div class="taco-item">
            <p>Bacon and egg: $3</p>
            <label for="eggAmount">Quantity:</label>
            <select id="eggAmount" name="eggAmount">
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
        <img src="images/B&E.JPG" alt="Bacon and Egg Taco">

    <!-- Taco 2-->
    <div class="taco-item2">
        <p>Bean and chees: $2</p>
        <label for="BeanAmount">Quantity:</label>
        <select id="BeanAmount" name="BeanAmount">
            <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select>
        </div>
        <img src="images/bean.JPG" alt="Description of the image">

        <!-- Taco 3-->
        <div class="taco-item3">
        <P>Chicken Fajita taco $5</P>
        <label for="ChickAmount">Quantity:</label>
        <select id="ChickAmount" name="ChickAmount">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
        </div>
        <img src="images/chick.JPG" alt="Description of the image">

        <!-- Taco 4-->
        <div class="taco-item4">
        <p>Beef Fajita Taco $6</p>
        <label for="BeefAmount">Quantity:</label>
        <select id="BeefAmount" name="BeefAmount">
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>
        <img src="images/beef.JPG" alt="Description of the image"> 
    
    <div class="drink">
    <label for="drinkSelect">Select a drink:</label>
    <select id="drinkSelect" name="drink">
    <option value="none">None</option>
    <option value="tea">Tea</option>
    <option value="water">Water</option>
    <option value="coke">Coke</option>
    <option value="drpepper">Dr. Pepper</option>
    <option value="orange">Orange Fanta</option>
    </select>
    </div>
    <div id="totalPriceContainer">
        <h3>Total Price: $0</h3>
    </div>


    <button type="button" id="complete">Complete Order</button>
    <button type="button" id="clear">Clear Order</button>
        </form>
    </div>
    <div>
    <?php echo $message; ?>
    </div>

    <script src="js/script.js"></script>
</body>

</html>