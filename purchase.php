<?php
$servername = "sql3.freemysqlhosting.net";
$username = "sql3667919";
$database = "sql3667919";
$password = "kXuSD3XVEy";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//gets the items stored within the database
function getItemsFromDatabase() {
    global $conn;
    $sql = "SELECT id, name, price, image_path FROM video_games";
    $result = $conn->query($sql);

    $items = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    }

    return $items;
}

//adds the data from items into the database
function insertItemIntoDatabase($name, $price, $imagePath) {
    global $conn;

    //escape values to prevent misidentification when added to database
    $name = $conn->real_escape_string($name);
    $price = floatval($price); //makes sure that price has a decimal value
    $imagePath = $conn->real_escape_string($imagePath);

    $sql = "INSERT INTO video_games (name, price, image_path) VALUES ('$name', $price, '$imagePath')";
    $result = $conn->query($sql);

	//sends error message if there's an error connecting
    if (!$result) {
        die("Error: " . $conn->error);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieves items from sql database
    $databaseItems = getItemsFromDatabase();

	//sets the value of total price
    $total = 0;
    foreach ($databaseItems as $item) {
        $itemId = $item['id'];
        $checkboxName = "items[$itemId]";
		
		//if an item is selected, adds the price to the total cost value
        if (isset($_POST['items'][$itemId]) && $_POST['items'][$itemId] == $item['price']) {
            $total += $item['price'];
        }
    }
}
	else{
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="style.css" type="text/css" rel="stylesheet" >
    <title>Total Price</title>
</head>

<body>
    <h1>Current ammount due:</h1>
    <?php
    // Displays the total price and gives message if no item selected
    if (isset($_GET['total'])) {
        echo "<p>$total</p>";
    } else {
        echo "<p>No Items Selected</p>";
    }
    ?>
</body>

</html>

<?php
	}
	
$conn->close();
?>