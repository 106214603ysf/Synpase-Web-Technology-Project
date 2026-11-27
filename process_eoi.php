<?php
/*
filename: process_eoi.php
author: Amani Aly
created: November 2026
last modified: November 2026
description: Checks the application sent from apply.php on the server, creates the eoi table if it does not
             exist, saves the application and shows the new EOInumber. Cannot be opened directly.
sources: Claude was used to help write this code. The team reviewed and tested all work.
*/

// 1. Block direct access: if the form was not submitted, send the user back to apply.php
if (!isset($_POST["job_ref"])) {
    header("Location: apply.php");
    exit();
}

// 2. Sanitise: remove spaces at the ends, remove backslashes, and turn < > & " into safe text
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$job_ref      = clean_input($_POST["job_ref"]);
$first_name   = clean_input($_POST["first_name"] ?? "");
$last_name    = clean_input($_POST["last_name"] ?? "");
$dob          = clean_input($_POST["dob"] ?? "");
$gender       = clean_input($_POST["gender"] ?? "");
$street       = clean_input($_POST["street"] ?? "");
$suburb       = clean_input($_POST["suburb"] ?? "");
$state        = clean_input($_POST["state"] ?? "");
$postcode     = clean_input($_POST["postcode"] ?? "");
$email        = clean_input($_POST["email"] ?? "");
$phone        = clean_input($_POST["phone"] ?? "");
$other_skills = clean_input($_POST["other_skills"] ?? "");

// The skill checkboxes arrive as a list, so clean each one
$skills = [];
if (isset($_POST["skills"])) {
    foreach ($_POST["skills"] as $skill) {
        $skills[] = clean_input($skill);
    }
}

// 3. Validate with the same rules as the Part 1 form. Every problem is added to $errors.
$errors = [];

if (!preg_match("/^[A-Za-z0-9]{5}$/", $job_ref)) {
    $errors[] = "Job reference number must be exactly 5 letters or numbers.";
}
if (!preg_match("/^[A-Za-z]{1,20}$/", $first_name)) {
    $errors[] = "First name is required: letters only, up to 20 characters.";
}
if (!preg_match("/^[A-Za-z ]{1,20}$/", $last_name)) {
    $errors[] = "Last name is required: letters only, up to 20 characters.";
}
if (!preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $dob, $parts) || !checkdate($parts[2], $parts[1], $parts[3])) {
    $errors[] = "Date of birth is required and must be a real date in dd/mm/yyyy format.";
}
if (!in_array($gender, ["Male", "Female", "Other", "Prefer not to say"])) {
    $errors[] = "Please select a gender.";
}
if ($street == "" || strlen($street) > 40) {
    $errors[] = "Street address is required: up to 40 characters.";
}
if ($suburb == "" || strlen($suburb) > 40) {
    $errors[] = "Suburb/town is required: up to 40 characters.";
}
if (!in_array($state, ["VIC", "NSW", "QLD", "NT", "WA", "SA", "TAS", "ACT"])) {
    $errors[] = "Please select a state.";
}
if (!preg_match("/^\d{4}$/", $postcode)) {
    $errors[] = "Postcode is required: exactly 4 digits.";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email address is required and must be in a valid format.";
}
if (!preg_match("/^\d{8,12}$/", $phone)) {
    $errors[] = "Phone number is required: 8 to 12 digits.";
}
if (count($skills) == 0) {
    $errors[] = "Please select at least one skill.";
}

// 4. If there are no errors, save the application
$eoi_number = null;
$db_error = false;

if (count($errors) == 0) {
    mysqli_report(MYSQLI_REPORT_OFF);   // so a database problem shows our message instead of crashing the page
    require_once "settings.php";        // Abdullah's file: connects to the database and gives us $conn

    if (!$conn) {
        $db_error = true;
    } else {
        // Create the eoi table if it does not exist yet
        $create_table = "CREATE TABLE IF NOT EXISTS eoi (
            EOInumber    INT AUTO_INCREMENT PRIMARY KEY,
            job_ref      VARCHAR(5)   NOT NULL,
            first_name   VARCHAR(20)  NOT NULL,
            last_name    VARCHAR(20)  NOT NULL,
            dob          DATE         NOT NULL,
            gender       VARCHAR(20)  NOT NULL,
            street       VARCHAR(40)  NOT NULL,
            suburb       VARCHAR(40)  NOT NULL,
            state        VARCHAR(3)   NOT NULL,
            postcode     CHAR(4)      NOT NULL,
            email        VARCHAR(100) NOT NULL,
            phone        VARCHAR(12)  NOT NULL,
            skills       VARCHAR(255) NOT NULL,
            other_skills TEXT,
            status       ENUM('New', 'Current', 'Final') NOT NULL DEFAULT 'New'
        ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
        mysqli_query($conn, $create_table);

        // MySQL stores dates as yyyy-mm-dd, so 15/03/2005 becomes 2005-03-15
        $dob_for_db = $parts[3] . "-" . $parts[2] . "-" . $parts[1];
        // The ticked skills are saved as one piece of text, e.g. "HTML5, CSS3"
        $skills_text = implode(", ", $skills);

        // Prepared statement: the ? values are sent separately from the SQL, which stops SQL injection
        $stmt = mysqli_prepare($conn, "INSERT INTO eoi
            (job_ref, first_name, last_name, dob, gender, street, suburb, state, postcode, email, phone, skills, other_skills)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        // 13 "s" = 13 text values, in the same order as the ? marks
        mysqli_stmt_bind_param($stmt, "sssssssssssss",
            $job_ref, $first_name, $last_name, $dob_for_db, $gender, $street,
            $suburb, $state, $postcode, $email, $phone, $skills_text, $other_skills);

        if (mysqli_stmt_execute($stmt)) {
            $eoi_number = mysqli_insert_id($conn);   // the EOInumber MySQL just created
        } else {
            $db_error = true;
        }
        mysqli_close($conn);
    }
}

// 5. Show the result: the errors, a database problem, or the confirmation
$page = "apply";
$heading = "Apply at Synapse";
$credits = 'Credits: logo created by Abrar Salahuddin using GIMP. ChatGPT was used as a supporting tool
            for code review and styling. Claude was used to help write this page. The student team reviewed and tested all work.';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Application result for Synapse Digital Health.">
    <meta name="author" content="Synapse group, COS10026">
    <title>Application Result | Synapse Digital Health</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <style>
        * {
  font-family: "Inter", sans-serif;
}
    </style>
</head>

<body class="apply-page">
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <?php include "header.inc"; ?>

    <main id="main-content">
        <section aria-labelledby="result-heading">
            <?php if (count($errors) > 0) { ?>
                <h2 id="result-heading">Please fix the following</h2>
                <div class="inner">
                    <ul>
                        <?php foreach ($errors as $error) { ?>
                            <li><?php echo $error; ?></li>
                        <?php } ?>
                    </ul>
                    <a class="button-link" href="apply.php">Back to the form</a>
                </div>
            <?php } elseif ($db_error) { ?>
                <h2 id="result-heading">Something went wrong</h2>
                <div class="inner">
                    <p>Sorry, we could not save your application. Please try again later.</p>
                </div>
            <?php } else { ?>
                <h2 id="result-heading">Application received</h2>
                <div class="inner">
                    <p>Thank you, <?php echo $first_name; ?>. Your application for job <?php echo $job_ref; ?>
                        has been received.</p>
                    <p>Your Expression of Interest number is <strong><?php echo $eoi_number; ?></strong>.</p>
                </div>
            <?php } ?>
        </section>
    </main>

    <?php include "footer.inc"; ?>
</body>

</html>