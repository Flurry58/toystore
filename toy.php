<?php
include "includes/header.php";

// Retrieve the value of the 'toynum' parameter from the URL query string
// Example URL: .../toy.php?toynum=0001
$toy_id = $_GET["toynum"];

function get_toy(PDO $pdo, string $id)
{
    // SQL query to retrieve toy information based on the toy ID
    $sql = "SELECT *
			FROM toy
			WHERE toyID= :id;"; // :id is a placeholder for value provided later
    // It's a parameterized query that helps prevent SQL injection attacks and ensures safer interaction with the database

    // Execute the SQL query using the pdo function and fetch the result
    $toy = pdo($pdo, $sql, ["id" => $id])->fetch(); // Associative array where 'id' is the key and $id is the value. Used to bind the value of $id to the placeholder :id in SQL query.

    return $toy; // Return the toy information (associative array)
}

function get_toy_details(PDO $pdo, string $toynum)
{
    // SQL query to retrieve toy and manufacturer information
    // JOIN the toy and manufacturer tables to get all information
    $sql = "SELECT toy.*, manuf.*
                FROM toy
                JOIN manuf ON toy.manID = manuf.manID
                WHERE toy.toyID = :toynum;";

    // Execute the SQL query using the pdo function and fetch the result
    $toy_details = pdo($pdo, $sql, ["toynum" => $toynum])->fetch();

    return $toy_details; // Return the toy and manufacturer information
}

// Call function to retrieve toy information
$toy = get_toy_details($pdo, $toy_id);
?>

<section class="toy-details-page container">
    <div class="toy-details-container">
        <div class="toy-image">
            <!-- Display the toy image and update the alt text to the toy name -->
            <img src="<?= $toy["img_src"] ?>" alt="<?= $toy["name"] ?>">
        </div>
        <div class="toy-details">
            <!-- Display the toy name -->
            <h1><?= $toy["name"] ?></h1>
            <h3>Toy Information</h3>
            <!-- Display the toy description -->
            <p><strong>Description:</strong> <?= $toy["description"] ?></p>
            <!-- Display the toy price -->
            <p><strong>Price:</strong> $<?= $toy["price"] ?></p>
            <!-- Display the toy age range -->
            <p><strong>Age Range:</strong> <?= $toy["age_range"] ?></p>
            <!-- Display stock of toy -->
            <p><strong>Number In Stock:</strong> <?= $toy["in_stock"] ?></p>
            <br />
            <h3>Manufacturer Information</h3>
            <!-- Display the manufacturer name -->
            <p><strong>Name:</strong> <?= $toy["name"] ?></p>
            <!-- Display the manufacturer address -->
            <p><strong>Address:</strong> <?= $toy["street"] ?>, <?= $toy[
    "city"
] ?>, <?= $toy["state"] ?> <?= $toy["zip"] ?></p>
            <!-- Display the manufacturer phone -->
            <p><strong>Phone:</strong> <?= $toy["phone"] ?></p>
            <!-- Display the manufacturer contact -->
            <p><strong>Contact:</strong> <?= $toy["contact"] ?></p>
        </div>
    </div>
</section>

<?php include "includes/footer.php"; ?>
