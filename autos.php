<?php
if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die("Name parameter missing");
}

if (isset($_POST['logout'])) {
    header("Location: index.php");
    exit();
}

$autos = array();

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1) {
        $failure = "Make is required";
    } elseif (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $failure = "Mileage and year must be numeric";
    } else {
        $autos[] = array(
            'make' => htmlentities($_POST['make']),
            'year' => htmlentities($_POST['year']),
            'mileage' => htmlentities($_POST['mileage'])
        );
        $success = "Record inserted";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SANTHOLIN SFURTADO - Autos Database</title>
</head>
<body>
    <h1>Tracking Autos for <?= htmlentities($_GET['name']); ?></h1>

    <?php
    if (isset($failure)) {
        echo '<p style="color:red;">' . htmlentities($failure) . "</p>\n";
    } elseif (isset($success)) {
        echo '<p style="color:green;">' . htmlentities($success) . "</p>\n";
    }
    ?>

    <form method="POST">
        <p>Make: <input type="text" name="make" size="40"></p>
        <p>Year: <input type="text" name="year"></p>
        <p>Mileage: <input type="text" name="mileage"></p>
        <input type="submit" value="Add">
        <input type="submit" name="logout" value="Logout">
    </form>

    <h2>Automobiles</h2>
    <ul>
        <?php
        foreach ($autos as $auto) {
            echo "<li>" . $auto['year'] . " " . $auto['make'] . " / " . $auto['mileage'] . "</li>";
        }
        ?>
    </ul>
</body>
</html>
