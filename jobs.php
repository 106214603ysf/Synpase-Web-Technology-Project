<?php
/*
filename: jobs.php
author: Youssof Hussein
created: October 2026
last modified: 25 Nov 2026
description: Job listings (loaded from the jobs table) for Synapse Digital Health, with an inclusion statement aside
sources: Logo created by Abrar Salahuddin using GIMP. Job content written by the team. ChatGPT was used for code review and styling suggestions; the team reviewed and tested all work.
*/

require_once "settings.php";   // Abdullah's DB connection ($conn)

// Splits a multiline database field into a clean array of list items
function lines_to_array($text) {
    $items = preg_split('/\R/', $text);
    return array_filter(array_map('trim', $items), 'strlen');
}

// Get all jobs
$jobs = [];
$result = mysqli_query($conn, "SELECT * FROM jobs ORDER BY job_ref");
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jobs[] = $row;
    }
    mysqli_free_result($result);
}

// Earliest closing date shown in the overview (if there are jobs)
$closing = !empty($jobs) ? date("j F Y", strtotime($jobs[0]['closing_date'])) : "";

include "header.inc";
?>

<main id="main-content">

    <!-- Overview section -->
    <section aria-labelledby="vacancies-heading">
        <h2 id="vacancies-heading">Job Vacancies</h2>
        <div class="inner">

            <aside aria-labelledby="inclusion-heading">
                <h3 id="inclusion-heading">Our Commitment to Inclusion</h3>

                <p>Synapse acknowledges the Wurundjeri Woi Wurrung and Bunurong peoples of the Kulin Nation,
                    the Traditional Custodians of the lands where our Melbourne team works, and pays respect
                    to Elders past and present.</p>

                <p>Digital health only works when everyone can use it. We encourage applications from
                    Aboriginal and Torres Strait Islander peoples and are committed to culturally safe,
                    inclusive workplaces and to services that are accessible to First Nations communities.</p>
            </aside>

            <h3>Why Work With Us?</h3>
            <p>Synapse builds patient platforms, appointment systems
                and health information websites. Our Melbourne team
                supports hybrid work, mentoring and training.</p>

            <?php if ($closing != "") { ?>
                <p style="border-left:4px solid #20c9f3; padding:10px;">
                    <strong>Applications close on <?php echo htmlspecialchars($closing); ?>.</strong>
                </p>
            <?php } ?>

            <?php if (!empty($jobs)) { ?>
                <ul>
                    <?php foreach ($jobs as $job) { ?>
                        <li>
                            <a href="#<?php echo strtolower(htmlspecialchars($job['job_ref'])); ?>">
                                <?php echo htmlspecialchars($job['title']); ?>
                                (<?php echo htmlspecialchars($job['job_ref']); ?>)
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </section>

    <?php if (empty($jobs)) { ?>
        <section aria-labelledby="none-heading">
            <h2 id="none-heading">No vacancies right now</h2>
            <div class="inner">
                <p>There are no open positions at the moment. Please check back soon.</p>
            </div>
        </section>
    <?php } ?>

    <!-- One section per job, built from the database -->
    <?php foreach ($jobs as $job) {
        $ref = htmlspecialchars($job['job_ref']);
        $id  = strtolower($ref);
    ?>
        <section id="<?php echo $id; ?>" aria-labelledby="<?php echo $id; ?>-heading">
            <h2 id="<?php echo $id; ?>-heading"><?php echo htmlspecialchars($job['title']); ?></h2>
            <div class="inner">
                <p><?php echo htmlspecialchars($job['description']); ?></p>

                <dl>
                    <dt>Reference number</dt>
                    <dd class="job-ref"><?php echo $ref; ?></dd>
                    <dt>Salary</dt>
                    <dd>$<?php echo number_format($job['salary_min']); ?>–$<?php echo number_format($job['salary_max']); ?> plus superannuation</dd>
                    <dt>Reports to</dt>
                    <dd><?php echo htmlspecialchars($job['reports_to']); ?></dd>
                    <dt>Location</dt>
                    <dd><?php echo htmlspecialchars($job['location']); ?></dd>
                    <dt>Employment</dt>
                    <dd><?php echo htmlspecialchars($job['employment']); ?></dd>
                </dl>

                <h3>Key Responsibilities</h3>
                <ol>
                    <?php foreach (lines_to_array($job['responsibilities']) as $item) { ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php } ?>
                </ol>

                <h3>Essential Requirements</h3>
                <ul>
                    <?php foreach (lines_to_array($job['essential']) as $item) { ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php } ?>
                </ul>

                <h3>Preferable Requirements</h3>
                <ul>
                    <?php foreach (lines_to_array($job['preferable']) as $item) { ?>
                        <li><?php echo htmlspecialchars($item); ?></li>
                    <?php } ?>
                </ul>

                <a class="button-link" href="apply.php?job=<?php echo urlencode($job['job_ref']); ?>#form-heading">Apply for <?php echo $ref; ?></a>
            </div>
        </section>
    <?php } ?>
</main>

<?php include "footer.inc"; ?>