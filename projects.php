<?php
require_once 'includes/config.php';
include 'includes/header.php';
?>

<main>

    <!-- ========================================
         PROJECTS HERO
    ======================================== -->

    <section class="projects-hero">

        <div class="projects-hero-content">

            <p>MY WORK</p>

            <h1>
                Projects I've <span>Built</span>
            </h1>

            <p class="projects-intro">
                A collection of projects I've worked on while
                learning Computer Science, programming, and
                application development.
            </p>

        </div>

    </section>


    <!-- ========================================
         PROJECTS
    ======================================== -->

    <section class="projects-page">

        <div class="section-title">

            <p>MY PROJECTS</p>

            <h2>What I've Been Building</h2>

        </div>


        <div class="projects-full-grid">

            <?php

            $sql = "SELECT * FROM projects ORDER BY created_at DESC";

            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0):

                $number = 1;

                while ($project = $result->fetch_assoc()):

            ?>

                <article class="project-full-card">

                    <div class="project-top">

                        <span class="project-number">

                            <?php
                            echo str_pad(
                                $number,
                                2,
                                "0",
                                STR_PAD_LEFT
                            );
                            ?>

                        </span>


                        <span class="project-status">
                            Personal Project
                        </span>

                    </div>


                    <h3>
                        <?php
                        echo htmlspecialchars(
                            $project['title']
                        );
                        ?>
                    </h3>


                    <p>
                        <?php
                        echo htmlspecialchars(
                            $project['description']
                        );
                        ?>
                    </p>


                    <div class="project-tech">

                        <?php

                        $technologies = explode(
                            ',',
                            $project['technologies']
                        );

                        foreach ($technologies as $technology):

                        ?>

                            <span>
                                <?php
                                echo htmlspecialchars(
                                    trim($technology)
                                );
                                ?>
                            </span>

                        <?php endforeach; ?>

                    </div>


                    <div class="project-actions">

                        <?php if (!empty($project['project_link'])): ?>

                            <a
                                href="<?php echo htmlspecialchars($project['project_link']); ?>"
                                class="project-btn primary-project-btn"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                View Project
                            </a>

                        <?php endif; ?>


                        <?php if (!empty($project['github_link'])): ?>

                            <a
                                href="<?php echo htmlspecialchars($project['github_link']); ?>"
                                class="project-btn secondary-project-btn"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                GitHub
                            </a>

                        <?php endif; ?>

                    </div>

                </article>


            <?php

                    $number++;

                endwhile;

            else:

            ?>

                <p>
                    No projects available yet.
                </p>

            <?php endif; ?>

        </div>

    </section>


    <!-- ========================================
         PROJECT CTA
    ======================================== -->

    <section class="projects-cta">

        <h2>
            More Projects Coming Soon 🚀
        </h2>

        <p>
            I'm continuously learning, building, and improving
            my skills through new projects.
        </p>

        <a
            href="contact.php"
            class="btn projects-cta-btn"
        >
            Let's Connect
        </a>

    </section>

</main>


<?php include 'includes/footer.php'; ?>