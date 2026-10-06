<?php
require_once "includes/config.php";

$success = "";
$error = "";
$isSubmitted = false;
$whatsappUrl = "";
$emailUrl = "";
$instagramUrl = "https://www.instagram.com/loyceelende"; 
$tiktokUrl = "https://www.tiktok.com/@loy.el13";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    /*
    ==========================================
    VALIDATION
    ==========================================
    */
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        /*
        ==========================================
        SAVE MESSAGE TO DATABASE
        ==========================================
        */
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $error = "Database error: " . $conn->error;
        } else {
            $stmt->bind_param("ssss", $name, $email, $subject, $message);

            if ($stmt->execute()) {
                $isSubmitted = true;
                $success = "Your message has been successfully saved to my dashboard!";

                /*
                ==========================================
                GENERATE PLATFORM LINKS
                ==========================================
                */
                $formattedMessage = 
                    "Hello Loyce! New message from portfolio:\n\n" .
                    "Name: " . $name . "\n" .
                    "Email: " . $email . "\n" .
                    "Subject: " . $subject . "\n\n" .
                    "Message:\n" . $message;

                // WhatsApp Link
                $whatsappUrl = "https://wa.me/256756649148?text=" . urlencode($formattedMessage);

                // Email Link (mailto)
                $emailUrl = "mailto:loyceelende@gmail.com?subject=" . urlencode($subject) . "&body=" . urlencode("Name: $name\nEmail: $email\n\n$message");

            } else {
                $error = "Something went wrong. Please try again.";
            }

            $stmt->close();
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<main>

    <!-- ==========================================
         CONTACT HERO
    ========================================== -->
    <section class="contact-hero">
        <div class="contact-hero-content">
            <p class="hero-label">GET IN TOUCH</p>
            <h1>
                Let's Start a
                <span>Conversation.</span>
            </h1>
            <p class="contact-intro">
                Have a project idea, collaboration opportunity,
                or simply want to connect?
                I'd love to hear from you.
            </p>
        </div>
    </section>

    <!-- ==========================================
         CONTACT SECTION
    ========================================== -->
    <section class="contact-page">
        <div class="contact-wrapper">

            <!-- LEFT: INFO -->
            <div class="contact-info">
                <p class="contact-label">CONTACT ME</p>
                <h2>
                    Let's build something
                    <span>meaningful.</span>
                </h2>
                <p class="contact-description">
                    You can choose any way you prefer to
                    contact me. I'm always happy to connect,
                    discuss ideas, and explore opportunities.
                </p>

                <div class="contact-details">
                    <a href="mailto:loyceelende@gmail.com" class="contact-detail">
                        <div class="contact-icon">@</div>
                        <div class="contact-detail-content">
                            <span>Email</span>
                            <h3>loyceelende@gmail.com</h3>
                            <small>Tap to send an email</small>
                        </div>
                    </a>

                    <a href="https://wa.me/256756649148" target="_blank" rel="noopener noreferrer" class="contact-detail">
                        <div class="contact-icon">↗</div>
                        <div class="contact-detail-content">
                            <span>WhatsApp</span>
                            <h3>Chat with me</h3>
                            <small>Quick response guaranteed</small>
                        </div>
                    </a>

                    <a href="https://www.instagram.com/loyceelende" target="_blank" rel="noopener noreferrer" class="contact-detail">
                        <div class="contact-icon">📷</div>
                        <div class="contact-detail-content">
                            <span>Instagram</span>
                            <h3>View Profile</h3>
                            <small>Connect on Instagram</small>
                        </div>
                    </a>

                    <a href="https://www.tiktok.com/@loy.el13" target="_blank" rel="noopener noreferrer" class="contact-detail">
                        <div class="contact-icon">♪</div>
                        <div class="contact-detail-content">
                            <span>TikTok</span>
                            <h3>@loy.el13</h3>
                            <small>Follow for updates</small>
                        </div>
                    </a>
                </div>
            </div>

            <!-- RIGHT: FORM OR SUCCESS CHOICE SCREEN -->
            <div class="contact-form-container">

                <?php if ($isSubmitted): ?>
                    <!-- SUCCESS CHOICE SCREEN -->
                    <div class="success-box" style="text-align: center; padding: 40px 20px;">
                        <div style="font-size: 50px; color: #d4af37; margin-bottom: 20px;">✓</div>
                        <h2 style="color: #fff; margin-bottom: 10px;">Message Saved Successfully!</h2>
                        <p style="color: #aaa; margin-bottom: 30px;">
                            Your message has been stored in my dashboard. Now, choose where you would like to send or share it:
                        </p>

                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <!-- WhatsApp Button -->
                            <a href="<?= $whatsappUrl ?>" target="_blank" rel="noopener noreferrer" style="background: #25D366; color: #fff; padding: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                Send via WhatsApp ↗
                            </a>

                            <!-- Email Button -->
                            <a href="<?= $emailUrl ?>" style="background: #d4af37; color: #000; padding: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                Send via Email ✉
                            </a>

                            <!-- Instagram Button -->
                            <a href="<?= $instagramUrl ?>" target="_blank" rel="noopener noreferrer" style="background: #E1306C; color: #fff; padding: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                Connect on Instagram 📷
                            </a>

                            <!-- TikTok Button -->
                            <a href="<?= $tiktokUrl ?>" target="_blank" rel="noopener noreferrer" style="background: #111; border: 1px solid #d4af37; color: #d4af37; padding: 15px; border-radius: 6px; text-decoration: none; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 10px;">
                                Connect on TikTok ♪
                            </a>
                        </div>

                        <div style="margin-top: 30px;">
                            <a href="contact.php" style="color: #888; font-size: 14px; text-decoration: underline;">Send another message</a>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- STANDARD FORM -->
                    <div class="form-header">
                        <span>01</span>
                        <h2>Send Me a Message</h2>
                        <p>
                            Fill in the form and your message
                            will be saved to my dashboard.
                        </p>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="error-message" style="background: rgba(255,0,0,0.1); border: 1px solid red; color: #ff6b6b; padding: 12px; border-radius: 6px; margin-bottom: 20px;">
                            <?= htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="contact.php" method="POST" class="contact-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="name">Your Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                                    placeholder="Enter your name"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label for="email">Your Email</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                    placeholder="Enter your email"
                                    required
                                >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input
                                type="text"
                                id="subject"
                                name="subject"
                                value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>"
                                placeholder="What is this about?"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea
                                id="message"
                                name="message"
                                rows="6"
                                placeholder="Write your message..."
                                required
                            ><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="send-button">
                            Save & Choose Platform
                            <span>→</span>
                        </button>
                    </form>
                <?php endif; ?>

            </div>

        </div>
    </section>

    <!-- ==========================================
         AVAILABILITY
    ========================================== -->
    <section class="availability-section">
        <div class="availability-content">
            <div>
                <p class="availability-label">CURRENTLY OPEN TO</p>
                <h2>
                    New opportunities &
                    <span>connections.</span>
                </h2>
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

    <!-- ==========================================
         FINAL CTA
    ========================================== -->
    <section class="contact-cta">
        <p>THANK YOU FOR VISITING</p>
        <h2>
            Let's connect and
            <br>
            <span>create something great.</span>
        </h2>
        <a href="projects.php" class="btn cta-btn">
            Explore My Projects
        </a>
    </section>

</main>

<?php include 'includes/footer.php'; ?>