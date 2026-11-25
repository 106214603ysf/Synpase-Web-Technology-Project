<?php
$page = "about";
require_once "settings.php";
$heading = "About Synapse";
$credits = 'Credits: group photo taken by the team; logo created by Abrar Salahuddin using GIMP. ChatGPT was used
            as a supporting tool for code review and styling. The student team reviewed and tested all work.';
?>
<!DOCTYPE html>
<!--
filename: about.php
author: Abdullah Maithalouni
created: October 2026
last modified: 1 Nov 2026
description: About page - group details (nested list), contributions and quotes (definition lists), group photo, fun facts table
sources: Quotes chosen by each member. Group photo taken by the team. Logo created by Abrar Salahuddin using GIMP. ChatGPT was used for code review and styling suggestions; the team reviewed and tested all work.
-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Meet the Synapse team: group details, member contributions, quotes and fun facts.">
    <meta name="keywords" content="Synapse, about us, team, group members, COS10026">
    <meta name="author" content="Synapse group, COS10026">
    <title>About Us | Synapse Digital Health</title>
    <link rel="stylesheet" href="styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Internal CSS: right-align the Arabic and Urdu quotes and colour the student IDs -->
    <style>
        .about-page .quotes dd[dir="rtl"] {
            text-align: right;
        }

        .about-page .student-id {
            color: #075481;
        }
        * {
  font-family: "Inter", sans-serif;
}
        
    </style>
</head>

<body class="about-page">
    <!-- Skip link: lets keyboard and screen-reader users jump past the navigation -->
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <!-- Header: logo, page title, slogan and shared main navigation -->
    <?php include "header.inc"; ?>

    <main id="main-content">

        <!-- Group details: nested list (class times sit inside the "Class times" item) -->
        <section aria-labelledby="group-heading">
            <h2 id="group-heading">About Our Group</h2>
            <div class="inner">
                <ul>
                    <li>Group name: <strong>Synapse</strong></li>
                    <li>Class times:
                        <ul>
                            <li>Sunday: 9:00–10:00 AM</li>
                            <li>Tuesday: 9:00–11:00 AM</li>
                        </ul>
                    </li>
                </ul>
            </div>
        </section>

        <!-- Member contributions: definition list pairs each member (term) with their work (description) -->
        <section aria-labelledby="contributions-heading">
            <h2 id="contributions-heading">Member Contributions</h2>
            <div class="inner">
                <dl>
                        <?php
                        $members = [];

                        if ($conn) {
                            $result = mysqli_query($conn, "SELECT * FROM about ORDER BY id");
                            while ($row = mysqli_fetch_assoc($result)) {
                                $members[] = $row;
                            }

                            foreach ($members as $m) {
                                echo '<dt>' . htmlspecialchars($m["member_name"]) . ' <span class="student-id">' . htmlspecialchars($m["student_id"]) . '</span></dt>';
                                echo '<dd><strong>Project 1:</strong> ' . htmlspecialchars($m["part1_contribution"]) . '</dd>';
                                echo '<dd><strong>Project 2:</strong> ' . htmlspecialchars($m["part2_contribution"]) . '</dd>';
                            }
                        } else {
                            echo '<dt>Error</dt><dd>Member details could not be loaded.</dd>';
                        }
                        ?>
                        </dl>
            </div>
        </section>

        <!-- Quotes: each quote is in the member's first language (lang and dir set for screen readers and
             right-to-left text) followed by an English translation -->
        <section aria-labelledby="quotes-heading">
            <h2 id="quotes-heading">Member Quotes</h2>
            <div class="inner">

            <dl class="quotes">
                <?php
                foreach ($members as $m) {
                    echo '<dt>' . htmlspecialchars($m["member_name"]) . ' (' . htmlspecialchars($m["quote_language"]) . ')</dt>';
                    echo '<dd lang="' . htmlspecialchars($m["lang_code"]) . '" dir="rtl">' . htmlspecialchars($m["quote"]) . '</dd>';
                    echo '<dd><q>' . htmlspecialchars($m["translation"]) . '</q></dd>';
                }
                ?>
                </dl>    

            </div>
        </section>

        <!-- Group photo: figure + figcaption; photo must stay under 300KB. Alt text describes the photo -->
        <section aria-labelledby="team-heading">
            <h2 id="team-heading">Our Team</h2>
            <div class="inner">
                <figure>
                    <img src="images/group-photo.jpeg" alt="The four Synapse team members standing side by side"
                        width="500" height="203" loading="lazy">

                    <!-- Inline CSS: bold caption -->
                    <figcaption style="font-weight:bold;">
                        The Synapse Team
                    </figcaption>
                </figure>
            </div>
        </section>

        <!-- Fun facts: table with caption, header row and row headers (scope) for screen readers -->
        <section class="fun-facts" aria-labelledby="facts-heading">
            <h2 id="facts-heading">Fun Facts</h2>
            <div class="inner">
                <table>
                    <caption>Team member interests</caption>
                    <thead>
                        <tr>
                            <th scope="col">Member</th>
                            <th scope="col">Fun fact</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Amani</th>
                            <td>Enjoys table tennis.</td>
                        </tr>
                        <tr>
                            <th scope="row">Abdullah</th>
                            <td>Enjoys indie games.</td>
                        </tr>
                        <tr>
                            <th scope="row">Youssof</th>
                            <td>Professional swimmer.</td>
                        </tr>
                        <tr>
                            <th scope="row">Abrar</th>
                            <td>Aspiring cybersecurity analyst.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Footer: Acknowledgement of Country, project links (Jira, GitHub, live site, email) and credits -->
    <?php include "footer.inc"; ?>
</body>

</html>