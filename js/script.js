// ========================================
// LOYCE PORTFOLIO - MAIN JAVASCRIPT
// ========================================

document.addEventListener("DOMContentLoaded", () => {

    // ========================================
    // 1. TYPING EFFECT
    // ========================================

    const typingElement = document.querySelector(".hero h2");

    if (typingElement) {

        const words = [
            "Computer Science Student",
            "Programmer",
            "Problem Solver",
            "Mobile App Developer"
        ];

        let wordIndex = 0;
        let letterIndex = 0;
        let deleting = false;

        function typeEffect() {

            const currentWord = words[wordIndex];

            if (!deleting) {

                typingElement.textContent =
                    currentWord.substring(0, letterIndex + 1);

                letterIndex++;

                if (letterIndex === currentWord.length) {
                    deleting = true;

                    setTimeout(typeEffect, 1800);
                    return;
                }

            } else {

                typingElement.textContent =
                    currentWord.substring(0, letterIndex - 1);

                letterIndex--;

                if (letterIndex === 0) {
                    deleting = false;

                    wordIndex++;

                    if (wordIndex === words.length) {
                        wordIndex = 0;
                    }
                }
            }

            const speed = deleting ? 50 : 100;

            setTimeout(typeEffect, speed);
        }

        typingElement.textContent = "";

        typeEffect();
    }


    // ========================================
    // 2. MOBILE MENU
    // ========================================

    const menuButton = document.querySelector(".menu-button");
    const navMenu = document.querySelector("nav ul");

    if (menuButton && navMenu) {

        menuButton.addEventListener("click", () => {

            navMenu.classList.toggle("active");

        });
    }


    // ========================================
    // 3. CLOSE MOBILE MENU
    // ========================================

    const navLinks = document.querySelectorAll("nav ul li a");

    navLinks.forEach(link => {

        link.addEventListener("click", () => {

            if (navMenu) {
                navMenu.classList.remove("active");
            }

        });

    });


    // ========================================
    // 4. SCROLL REVEAL
    // ========================================

    const sections = document.querySelectorAll("section");

    const observer = new IntersectionObserver(
        (entries) => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.add("show");

                }

            });

        },
        {
            threshold: 0.15
        }
    );

    sections.forEach(section => {

        section.classList.add("hidden");

        observer.observe(section);

    });


    // ========================================
    // 5. ACTIVE NAVIGATION
    // ========================================

    const currentPage =
        window.location.pathname.split("/").pop();

    navLinks.forEach(link => {

        const linkPage =
            link.getAttribute("href");

        if (linkPage === currentPage) {

            link.classList.add("active");

        }

    });


    // ========================================
    // 6. CURRENT YEAR
    // ========================================

    const yearElement =
        document.querySelector("#current-year");

    if (yearElement) {

        yearElement.textContent =
            new Date().getFullYear();

    }

});