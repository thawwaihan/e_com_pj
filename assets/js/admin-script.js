document.addEventListener("DOMContentLoaded", () => {

    /* =========================
       SIDEBAR
    ========================= */

    const toggle = document.querySelector(".sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");

    if (toggle && sidebar) {

        toggle.addEventListener("click", () => {

            sidebar.classList.toggle("open");

            const icon = toggle.querySelector("i");

            if (sidebar.classList.contains("open")) {

                icon.classList.remove("fa-bars");
                icon.classList.add("fa-xmark");

            } else {

                icon.classList.remove("fa-xmark");
                icon.classList.add("fa-bars");

            }

        });

    }


    /* =========================
       NUMBER COUNTER
    ========================= */

    const counters = document.querySelectorAll(".counter");

    counters.forEach(counter => {

        const target = Number(
            counter.getAttribute("data-count")
        ) || 0;

        let current = 0;

        const duration = 1400;

        const start = performance.now();

        function animate(time) {

            const progress = Math.min(
                (time - start) / duration,
                1
            );

            // Smooth easing
            const ease =
                1 - Math.pow(1 - progress, 4);

            current = Math.floor(
                ease * target
            );

            counter.textContent =
                current.toLocaleString();

            if (progress < 1) {

                requestAnimationFrame(animate);

            } else {

                counter.textContent =
                    target.toLocaleString();

            }

        }

        requestAnimationFrame(animate);

    });


    /* =========================
       CARD MOUSE EFFECT
    ========================= */

    const cards =
        document.querySelectorAll(
            ".stat-card, .action-card"
        );


    cards.forEach(card => {

        card.addEventListener("mousemove", e => {

            const rect =
                card.getBoundingClientRect();

            const x =
                e.clientX - rect.left;

            const y =
                e.clientY - rect.top;

            const centerX =
                rect.width / 2;

            const centerY =
                rect.height / 2;

            const rotateX =
                ((y - centerY) / centerY) * -2;

            const rotateY =
                ((x - centerX) / centerX) * 2;


            card.style.transform =
                `perspective(800px)
                 rotateX(${rotateX}deg)
                 rotateY(${rotateY}deg)
                 translateY(-6px)`;

        });


        card.addEventListener("mouseleave", () => {

            card.style.transform = "";

        });

    });


    /* =========================
       RIPPLE EFFECT
    ========================= */

    const buttons =
        document.querySelectorAll(
            ".action-card, .menu a"
        );


    buttons.forEach(button => {

        button.addEventListener("click", e => {

            const ripple =
                document.createElement("span");

            ripple.classList.add("ripple");

            const rect =
                button.getBoundingClientRect();

            ripple.style.left =
                `${e.clientX - rect.left}px`;

            ripple.style.top =
                `${e.clientY - rect.top}px`;

            button.appendChild(ripple);

            setTimeout(() => {

                ripple.remove();

            }, 600);

        });

    });


    /* =========================
       NOTIFICATION
    ========================= */

    const notification =
        document.querySelector(".notification");

    if (notification) {

        notification.addEventListener("click", () => {

            notification.classList.add("shake");

            setTimeout(() => {

                notification.classList.remove("shake");

            }, 500);

        });

    }

});