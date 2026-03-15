<?php
include "includes/header.php";

require_login($logged_in);
$username = $_SESSION["username"];
$custID = $_SESSION["custID"];

function get_user_orders(PDO $pdo, int $custID)
{
    $sql = "SELECT orders.*, toy.name, toy.img_src
            FROM orders
            JOIN toy ON orders.toyID = toy.toyID
            WHERE orders.custID = :custID
            ORDER BY orders.dateOrdered DESC;";

    $orders = pdo($pdo, $sql, ["custID" => $custID])->fetchAll();

    return $orders;
}

$orders = get_user_orders($pdo, $custID);
?>
<main class="container profile-page">
    <h1>Welcome, <?= htmlspecialchars($username) ?>!</h1>

    <?php if (empty($orders)): ?>
        <div class="no-orders">
            <p>You have no orders yet.</p>
        </div>
    <?php else: ?>
        <div class="orders-container">
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <img src="<?= $order["img_src"] ?>" alt="<?= $order[
    "name"
] ?>">
                    <div class="order-info">
                        <p><strong>Order Number:</strong> <?= $order[
                            "orderID"
                        ] ?></p>
                        <p><strong>Toy:</strong> <?= $order["name"] ?></p>
                        <p><strong>Quantity:</strong> <?= $order[
                            "quantity"
                        ] ?></p>
                        <p><strong>Date Ordered:</strong> <?= $order[
                            "dateOrdered"
                        ] ?></p>
                        <p><strong>Delivery Address:</strong> <?= $order[
                            "deliveryAddress"
                        ] ?></p>
                        <p><strong>Delivery Date:</strong> <?= $order[
                            "deliveryDate"
                        ] ?? "Pending" ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>
<?php include "includes/footer.php"; ?>
