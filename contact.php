<?php
require_once "includes/config.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if (empty($name) || empty($email) || empty($subject) || empty($message)) { 
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        
        if ($stmt->execute()) {
            $success = "Your message has been sent successfully!";
        } else {
            $error = "Something went wrong. Please try again.";
        }
        
        $stmt->close();
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>

    <!-- CONTACT HERO -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <p>GET IN TOUCH</p>
            <h1>
                Let's Start a
                <span>Conversation.</span>
            </h1>
            <p class="contact-intro">
                Have a project idea, collaboration opportunity, or simply
                want to connect? I'd love to hear from you.
            </p>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="contact-page">
        <div class="contact-wrapper">

            <!-- LEFT SIDE -->
            <div class="contact-info">
                <p class="contact-label">
                    CONTACT ME
                </p>
                <h2>
                    Let's build something
                    <span>meaningful.</span>
                </h2>
                <p class="contact-description">
                    I am always open to connecting with people,
                    discussing technology, sharing ideas, and exploring
                    opportunities to learn and build together.
                </p>

                <!-- CONTACT DETAILS -->
                <div class="contact-details">
                    <!-- EMAIL -->
                    <div class="contact-detail">
                        <div class="contact-icon">@</div>
                        <div>
                            <span>Email</span>
                            <h3>
                                <a href="mailto:loyceelende@gmail.com">
                                    loyceelende@gmail.com
                                </a>
                            </h3>
                        </div>
                    </div>

                    <!-- WHATSAPP -->
                    <div class="contact-detail">
                        <div class="contact-icon">↗</div>
                        <div>
                            <span>WhatsApp</span>
                            <h3>
                                <a href="https://wa.me/" target="_blank" rel="noopener noreferrer">
                                    Chat with me
                                </a>
                            </h3>
                        </div>
                    </div>

                    <!-- TIKTOK -->
                    <div class="contact-detail">
                        <div class="contact-icon">♪</div>
                        <div>
                            <span>TikTok</span>
                            <h3>
                                <a href="https://www.tiktok.com/@loy.el13" target="_blank" rel="noopener noreferrer">
                                    @loy.el13
                                </a>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE FORM -->
            <div class="contact-form-container">
                <div class="form-header">
                    <span>01</span>
                    <h2>Send Me a Message</h2>
                    <p>Fill in the form below and I'll get back to you.</p>
                </div>

                <?php if (!empty($success)): ?>
                    <div class="success">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="error">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="contact-form">s
                    <!-- NAME + EMAIL -->
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter your name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Your Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <!-- SUBJECT -->
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What is this about?" required>
                    </div>

                    <!-- MESSAGE -->
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Write your message..." required></textarea>
                    </div>

                    <!-- SUBMIT BUTTON -->
                    <button type="submit" class="send-button">
                        Send Message
                        <span>→</span>
                    </button>
                </form>
            </div>

        </div>
    </section>

    <!-- AVAILABILITY -->
    <section class="availability-section">
        <div class="availability-content">
            <div>
                <p class="availability-label">CURRENTLY OPEN TO</p>
                <h2>New opportunities & <span>connections.</span></h2>
            </div>
            <div class="availability-items">
                <div>
                    <span>01</span>
                    <p>Projects</p>
                </div>
                <div>
                    <span>02</span>
                    <p>Collaborations</p>
                </div>
                <div>
                    <span>03</span>
                    <p>Learning Opportunities</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FINAL CTA -->
    <section class="contact-cta">
        <p>THANK YOU FOR VISITING</p>
        <h2>Let's connect and<br><span>create something great.</span></h2>
        <a href="projects.php" class="btn cta-btn">Explore My Projects</a>
    </section>

</main>

<?php include 'includes/footer.php'; ?>