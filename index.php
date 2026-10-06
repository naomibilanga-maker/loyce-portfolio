<?php include 'includes/header.php'; ?>

<main>

    <!-- ==============================
         HERO SECTION
    =============================== -->

    <section class="hero">

        <div class="hero-text">

            <p class="welcome">WELCOME TO MY PORTFOLIO</p>

            <h1>
                Hi, I'm <span>Loyce</span>
            </h1>

            <h2>Computer Science Student</h2>

            <p class="description">
                I'm passionate about programming, problem-solving,
                and building digital experiences that make a difference.
            </p>

            <div class="hero-buttons">

                <a href="projects.php" class="btn primary-btn">
                    View My Projects
                </a>

                <a href="contact.php" class="btn secondary-btn">
                    Contact Me
                </a>

            </div>

        </div>

        <div class="hero-image">

            <div class="image-circle">

                <img
                    src="images/profile.JPG (1).jpeg"
                >

            </div>

        </div>

    </section>


    <!-- ==============================
         ABOUT PREVIEW
    =============================== -->

    <section class="about-preview">

        <div class="section-title">

            <p>GET TO KNOW ME</p>

            <h2>About Me</h2>

        </div>

        <div class="about-preview-content">

            <div>

                <h3>My Journey in Computer Science</h3>

                <p>
                    I'm a Computer Science student who enjoys
                    learning how technology works and turning
                    ideas into real projects.
                </p>

                <p>
                    My journey has allowed me to explore
                    programming, web development, databases,
                    and mobile application development.
                </p>

                <a href="about.php" class="text-link">
                    Learn More About Me →
                </a>

            </div>

        </div>

    </section>


    <!-- ==============================
         SKILLS
    =============================== -->

    <section class="skills-preview">

        <div class="section-title">

            <p>WHAT I WORK WITH</p>

            <h2>My Skills</h2>

        </div>


        <div class="skills-grid">

            <div class="skill-card">

                <div class="skill-icon">🌐</div>

                <h3>HTML</h3>

                <p>
                    Building the structure of modern websites.
                </p>

            </div>


            <div class="skill-card">

                <div class="skill-icon">🎨</div>

                <h3>CSS</h3>

                <p>
                    Creating responsive and attractive designs.
                </p>

            </div>


            <div class="skill-card">

                <div class="skill-icon">⚡</div>

                <h3>JavaScript</h3>

                <p>
                    Adding interaction and dynamic behavior.
                </p>

            </div>


            <div class="skill-card">

                <div class="skill-icon">🐘</div>

                <h3>PHP</h3>

                <p>
                    Building server-side web applications.
                </p>

            </div>


            <div class="skill-card">

                <div class="skill-icon">🗄️</div>

                <h3>MySQL</h3>

                <p>
                    Managing and working with databases.
                </p>

            </div>


            <div class="skill-card">

                <div class="skill-icon">📱</div>

                <h3>Mobile Development</h3>

                <p>
                    Exploring mobile application development.
                </p>

            </div>

        </div>


        <div class="center-button">

            <a href="skills.php" class="btn primary-btn">
                View All Skills
            </a>

        </div>

    </section>


    <!-- ==============================
         FEATURED PROJECTS
    =============================== -->

    <section class="projects-preview">

        <div class="section-title">

            <p>WHAT I'VE BUILT</p>

            <h2>Featured Projects</h2>

        </div>


        <div class="projects-grid">

            <!-- PROJECT 1 -->

            <article class="project-card">

                <div class="project-content">

                    <span class="project-number">01</span>

                    <h3>Car Marketplace</h3>

                    <p>
                        A web platform designed to help users
                        discover and explore cars online.
                    </p>

                    <div class="project-tech">
                        <span>HTML</span>
                        <span>CSS</span>
                        <span>JavaScript</span>
                        <span>PHP</span>
                    </div>

                </div>

            </article>


            <!-- PROJECT 2 -->

            <article class="project-card">

                <div class="project-content">

                    <span class="project-number">02</span>

                    <h3>Hospital Management System</h3>

                    <p>
                        A system designed to organize patient
                        and hospital information.
                    </p>

                    <div class="project-tech">
                        <span>PHP</span>
                        <span>MySQL</span>
                        <span>HTML</span>
                        <span>CSS</span>
                    </div>

                </div>

            </article>


            <!-- PROJECT 3 -->

            <article class="project-card">

                <div class="project-content">

                    <span class="project-number">03</span>

                    <h3>Supermarket System</h3>

                    <p>
                        A system for managing products,
                        categories, and prices.
                    </p>

                    <div class="project-tech">
                        <span>PHP</span>
                        <span>MySQL</span>
                        <span>JavaScript</span>
                    </div>

                </div>

            </article>

        </div>


        <div class="center-button">

            <a href="projects.php" class="btn primary-btn">
                View All Projects
            </a>

        </div>

    </section> <!-- Added missing closing tag for projects-preview -->


    <!-- ==============================
         CALL TO ACTION
    =============================== -->

    <section class="cta">

        <h2>Let's Build Something Together</h2>

        <p>
            Have an idea, project, or opportunity?
            I'd love to hear from you.
        </p>

        <a href="contact.php" class="btn cta-btn">
            Get In Touch
        </a>

    </section>

</main>

<?php include 'includes/footer.php'; ?>