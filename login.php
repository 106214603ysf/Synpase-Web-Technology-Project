<?php
session_start();
require_once "settings.php";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";

    if (!$conn) {
        $error = "Cannot connect to the database.";
    } else {
        $stmt = $conn->prepare("SELECT password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($password, $row["password_hash"])) {
            session_regenerate_id(true);
            $_SESSION["username"] = $username;
            header("Location: manage.php");
            exit();
        } else {
            $error = "Incorrect username or password.";
        }
    }
}

$page = "login";
$heading = "Staff Login";
$credits = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Staff login for Synapse HR managers.">
    <title>Staff Login | Synapse Digital Health</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to main content</a>
    <?php include "header.inc"; ?>

    <main id="main-content">
        <section aria-labelledby="login-heading">
            <h2 id="login-heading">HR Manager Login</h2>
            <div class="inner">
                <?php if ($error != "") echo '<p role="alert"><strong>' . $error . '</strong></p>'; ?>
                <form method="post" action="login.php">
                    <p><label for="username">Username</label>
                       <input type="text" id="username" name="username"></p>
                    <p><label for="password">Password</label>
                       <input type="password" id="password" name="password"></p>
                    <p><input type="submit" value="Log in"></p>
                </form>
            </div>
        </section>
    </main>

    <?php include "footer.inc"; ?>
</body>
</html>