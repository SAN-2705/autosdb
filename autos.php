<?php
require_once "pdo.php";

session_start();


if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die("Name parameter missing");
}

$failure = false;
$success = false;

if (isset($_POST['logout'])) {
    header("Location: index.php");
    return;
}

if (isset($_POST['add'])) {
    if (strlen($_POST['make']) < 1) {
        $failure = "Make is required";
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES (:mk, :yr, :mi)');
        $stmt->execute(array(
            ':mk' => $_POST['make'],
            ':yr' => $_POST['year'],
            ':mi' => $_POST['mileage']
        ));
        $success = "Record inserted";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>San's Autos</title>
</head>
<body>
<h1>Tracking Autos for <?= htmlentities($_GET['name']) ?></h1>

<?php
if ($failure !== false) {
    echo '<p style="color: red;">' . htmlentities($failure) . "</p>\n";
}
if ($success !== false) {
    echo '<p style="color: green;">' . htmlentities($success) . "</p>\n";
}
?>

<form method="POST">
    <p>Make: <input type="text" name="make" size="40"></p>
    <p>Year: <input type="text" name="year"></p>
    <p>Mileage: <input type="text" name="mileage"></p>
    <input type="submit" name="add" value="Add">
    <input type="submit" name="logout" value="Logout">
</form>

<h2>Automobiles</h2>
<ul>
<?php
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<li>" . htmlentities($row['year']) . " " . htmlentities($row['make']) . " / " . htmlentities($row['mileage']) . "</li>\n";
}
?>
</ul>
</body>
</html>
