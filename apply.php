<?php
$page = "apply";
$heading = "Apply at Synapse";
$credits = 'Credits: logo created by Abrar Salahuddin using GIMP. ChatGPT was used as a supporting tool
            for code review and styling. Claude was used to help convert the form to PHP. The student team reviewed and tested all work.';

// The "Apply for FE001" buttons on jobs.php open apply.php?job=FE001.
// This puts that reference into the Job Reference box. htmlspecialchars makes the value safe to print.
$job_ref = "";
if (isset($_GET["job"])) {
    $job_ref = htmlspecialchars(trim($_GET["job"]));
}
?>
<!DOCTYPE html>
<!--
filename: apply.php
author: Amani Aly
created: October 2026
last modified: November 2026
description: Job application form for Synapse Digital Health. Posts to process_eoi.php. Browser validation is
             turned off (novalidate) because all validation is done on the server in process_eoi.php.
sources: Logo created by Abrar Salahuddin using GIMP. ChatGPT was used for code review and styling suggestions;
         Claude was used to help convert the form to PHP. The team reviewed and tested all work.
-->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Apply for a job at Synapse Digital Health using our online application form.">
    <meta name="keywords" content="Synapse, apply, job application, FE001, UX002, healthcare technology">
    <meta name="author" content="Synapse group, COS10026">
    <title>Apply | Synapse Digital Health</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Internal CSS: page-specific form styles (wide fields and focus border colour) -->
    <style>
        .apply-page .field-wide {
            grid-column: 1 / -1;
        }

        .apply-page .form-help {
            font-size: 0.9rem;
        }

        .apply-page input:focus,
        .apply-page select:focus,
        .apply-page textarea:focus {
            border-color: #159dd1;
        }
        * {
  font-family: "Inter", sans-serif;
}
    </style>
</head>

<body class="apply-page">
    <!-- Skip link: lets keyboard and screen-reader users jump past the navigation -->
    <a class="skip-link" href="#main-content">Skip to main content</a>

    <!-- Header: logo, page title, slogan and shared main navigation -->
    <?php include "header.inc"; ?>

    <main id="main-content">
        <!-- Instructions: tells applicants where to find the reference number and what * means -->
        <section aria-labelledby="apply-heading">
            <h2 id="apply-heading">Apply for a Position</h2>
            <div class="inner">
                <p>Read the <a href="jobs.php">Job Descriptions</a> and enter the five-character reference number
                    (for example FE001 or UX002).</p>
                <!-- The star is decoration; aria-required tells screen readers which fields are required -->
                <p class="form-help">Fields marked <span class="required-star" aria-hidden="true">*</span> are
                    required.</p>
            </div>
        </section>

        <section aria-labelledby="form-heading">
            <!-- Inline CSS: one-off underline for the form heading -->
            <h2 id="form-heading" style="border-bottom: 2px solid #20c9f3; padding-bottom: 8px;">Job Application Form
            </h2>

            <div class="inner">
                <!-- Form posts to process_eoi.php. novalidate turns off all browser validation,
                     so every check is done on the server. aria-required is for screen readers only
                     and does not stop the form being sent. -->
                <form action="process_eoi.php" method="post" novalidate>

                    <fieldset>
                        <legend>Job Information</legend>
                        <label for="job-ref">Job Reference Number <span class="required-star"
                                aria-hidden="true">*</span></label>
                        <input type="text" id="job-ref" name="job_ref" value="<?php echo $job_ref; ?>"
                            aria-required="true">
                    </fieldset>

                    <fieldset>
                        <legend>Personal Information</legend>

                        <!-- Two-column CSS Grid (one column on phones) -->
                        <div class="fields-grid">
                            <div>
                                <label for="first-name">First Name <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="first-name" name="first_name" autocomplete="given-name"
                                    aria-required="true">
                            </div>

                            <div>
                                <label for="last-name">Last Name <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="last-name" name="last_name" autocomplete="family-name"
                                    aria-required="true">
                            </div>

                            <div>
                                <label for="dob">Date of Birth (dd/mm/yyyy) <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="dob" name="dob" placeholder="dd/mm/yyyy" aria-required="true">
                            </div>

                            <!-- Radio buttons grouped with fieldset + legend so screen readers announce the question -->
                            <fieldset class="field-wide">
                                <legend>Gender <span class="required-star" aria-hidden="true">*</span></legend>
                                <div class="choice-grid">
                                    <label><input type="radio" name="gender" value="Male"> Male</label>
                                    <label><input type="radio" name="gender" value="Female"> Female</label>
                                    <label><input type="radio" name="gender" value="Other"> Other</label>
                                    <label><input type="radio" name="gender" value="Prefer not to say"> Prefer not to
                                        say</label>
                                </div>
                            </fieldset>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Address</legend>

                        <div class="fields-grid">
                            <div>
                                <label for="street">Street Address <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="street" name="street" autocomplete="address-line1"
                                    aria-required="true">
                            </div>

                            <div>
                                <label for="suburb">Suburb/Town <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="suburb" name="suburb" autocomplete="address-level2"
                                    aria-required="true">
                            </div>

                            <div>
                                <label for="state">State <span class="required-star" aria-hidden="true">*</span></label>
                                <select id="state" name="state" aria-required="true">
                                    <option value="">Select state</option>
                                    <option value="VIC">VIC</option>
                                    <option value="NSW">NSW</option>
                                    <option value="QLD">QLD</option>
                                    <option value="NT">NT</option>
                                    <option value="WA">WA</option>
                                    <option value="SA">SA</option>
                                    <option value="TAS">TAS</option>
                                    <option value="ACT">ACT</option>
                                </select>
                            </div>

                            <div>
                                <label for="postcode">Postcode <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="text" id="postcode" name="postcode" autocomplete="postal-code"
                                    aria-required="true">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Contact Details</legend>

                        <div class="fields-grid">
                            <div>
                                <label for="email">Email Address <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="email" id="email" name="email" autocomplete="email" aria-required="true">
                            </div>

                            <div>
                                <label for="phone">Phone Number <span class="required-star"
                                        aria-hidden="true">*</span></label>
                                <input type="tel" id="phone" name="phone" autocomplete="tel" aria-required="true">
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Skills</legend>
                        <p>Select the skills you have (at least one):</p>

                        <!-- skills[] sends every ticked box to PHP as a list -->
                        <div class="choice-grid">
                            <label><input type="checkbox" name="skills[]" value="HTML5"> HTML5</label>
                            <label><input type="checkbox" name="skills[]" value="CSS3"> CSS3</label>
                            <label><input type="checkbox" name="skills[]" value="Accessibility">
                                Accessibility</label>
                            <label><input type="checkbox" name="skills[]" value="Healthcare Technology"> Healthcare
                                Technology</label>
                            <label><input type="checkbox" name="skills[]" value="UI/UX Design"> UI/UX Design</label>
                        </div>

                        <p>
                            <label for="other-skills">Other Skills</label>
                        </p>
                        <!-- Only field that is not required, as per the assignment -->
                        <textarea id="other-skills" name="other_skills" rows="4"></textarea>
                    </fieldset>

                    <!-- Flexbox row for the submit and reset buttons -->
                    <div class="form-actions">
                        <input type="submit" value="Submit Application">
                        <input type="reset" value="Reset Form">
                    </div>
                </form>
            </div>
        </section>
    </main>

    <!-- Footer: Acknowledgement of Country, project links (Jira, GitHub, live site, email) and credits -->
    <?php include "footer.inc"; ?>
</body>

</html>