import "./bootstrap";
import "flowbite";

document.addEventListener("DOMContentLoaded", function () {
    const loginContainer = document.getElementById("loginContainer");
    setTimeout(() => {
        loginContainer.style.transition = "all 0.5s ease-out";
        loginContainer.style.opacity = "1";
        loginContainer.style.transform = "translateY(0)";
    }, 100);

    const inputs = document.querySelectorAll(".form-input");
    inputs.forEach((input) => {
        input.addEventListener("focus", function () {
            this.style.transform = "scale(1.02)";
        });
        input.addEventListener("blur", function () {
            this.style.transform = "scale(1)";
        });
    });

    const loginForm = document.getElementById("loginForm");
    const loginButton = loginForm.querySelector('button[type="submit"]');
    loginForm.addEventListener("submit", function (e) {
        e.preventDefault();
        loginButton.innerHTML =
            '<svg class="animate-spin h-5 w-5 mr-3 inline-block" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...';
        loginButton.disabled = true;

        setTimeout(() => {
            this.submit();
        }, 2000);
    });

    document.addEventListener("mousemove", function (e) {
        const moveX = (e.clientX - window.innerWidth / 2) * 0.01;
        const moveY = (e.clientY - window.innerHeight / 2) * 0.01;
        document.body.style.backgroundPosition = `${moveX}px ${moveY}px`;
    });
});
