<?php

include "includes/header.php";
/* TO-DO: Include header.php
              Hint: header.php is inside the includes folder and already connects to the database
    */

/*
 * Retrieve toy information from the database based on the toy ID.
 *
 * @param PDO $pdo       An instance of the PDO class.
 * @param string $id     The ID of the toy to retrieve.
 * @return array|null    An associative array containing the toy information, or null if no toy is found.
 */
function get_all_toys(PDO $pdo)
{
    // SQL query to retrieve ALL toys
    $sql = "SELECT *
             FROM toy;";

    // Execute the query and fetch all results
    $toys = pdo($pdo, $sql)->fetchAll(); // fetchAll() returns an array of all rows
    return $toys; // Return array of all toys
}

$toys = get_all_toys($pdo);

// Retrieve info about toy with ID '0001' from the database using provided PDO connection
?>


<section class="toy-catalog">
    <?php foreach ($toys as $toy): ?>
        <!-- TOY CARD START -->
        <div class="toy-card">
            <a href="toy.php?toynum=<?= $toy["toyID"] ?>">
                <img src="<?= $toy["img_src"] ?>" alt="<?= $toy["name"] ?>">
            </a>
            <h2><?= $toy["name"] ?></h2>
            <p>$<?= $toy["price"] ?></p>
        </div>
        <!-- TOY CARD END -->
    <?php endforeach; ?>
</section>

<?php include "includes/footer.php"; ?>
