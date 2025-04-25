<?php
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // pw: php123
$failure = false;

if (isset($_POST['who']) && isset($_POST['pass'])) {
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $failure = "Email and password are required";
    } elseif (strpos($_POST['who'], '@') === false) {
        $failure = "Email must have an at-sign (@)";
    } else {
        $check = md5($salt . $_POST['pass']);
        if ($check === $stored_hash) {
            error_log("Login success " . $_POST['who']);
            header("Location: autos.php?name=" . urlencode($_POST['who']));
            exit();
        } else {
            error_log("Login fail " . $_POST['who'] . " $check");
            $failure = "Incorrect password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SANTHOLIN SFURTADO - Login Page</title>
</head>
<body>
    <h1>Please Log Into AUTOS</h1>
    <?php
    if ($failure !== false) {
        echo '<p style="color:red;">' . htmlentities($failure) . "</p>\n";
    }
    ?>
    <form method="POST">
        <label for="who">Email</label>
        <input type="text" name="who" id="who"><br/>
        <label for="pass">Password</label>
        <input type="password" name="pass" id="pass"><br/>
        <input type="submit" value="Log In">
    </form>
</body>
</html>
