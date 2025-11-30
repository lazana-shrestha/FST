document.addEventListener("DOMContentLoaded", function () {
  // Mobile Menu Toggle
  const menuToggle = document.querySelector(".menu-toggle");
  const navMenu = document.querySelector("nav ul");

  menuToggle.addEventListener("click", function () {
    navMenu.classList.toggle("open");
    // Change button text/icon
    if (navMenu.classList.contains("open")) {
      menuToggle.textContent = "✕";
    } else {
      menuToggle.textContent = "☰";
    }
  });

  // Scroll Indicator
  const scrollProgress = document.querySelector(".scroll-progress");

  window.addEventListener("scroll", function () {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    const scrollPercent = (scrollTop / (documentHeight - windowHeight)) * 100;

    scrollProgress.style.width = scrollPercent + "%";
  });

  // Form Validation
  const form = document.getElementById("form");

  form.addEventListener("submit", function (event) {
    event.preventDefault(); // Stop form from refreshing page

    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const message = document.getElementById("message");

    // Clear previous messages
    clearMessages();

    let hasErrors = false;

    // Check name
    if (name.value.trim() === "") {
      showError(name, "Please enter your name.");
      hasErrors = true;
    }

    // Check email
    if (email.value.trim() === "") {
      showError(email, "Please enter your email address.");
      hasErrors = true;
    } else if (!isValidEmail(email.value)) {
      showError(email, "Please enter a valid email address.");
      hasErrors = true;
    }

    // Check message
    if (message.value.trim() === "") {
      showError(message, "Please enter your message.");
      hasErrors = true;
    }

    // If no errors, show success message
    if (!hasErrors) {
      showSuccess("Thank you! Your message has been sent successfully.");
      form.reset();
    }
  });

  function showError(input, message) {
    // Create error message element
    const errorElement = document.createElement("div");
    errorElement.className = "error-message";
    errorElement.textContent = message;

    // Insert error message after the input
    input.parentNode.appendChild(errorElement);

    // Highlight the input field
    input.style.borderColor = "red";
  }

  function showSuccess(message) {
    // Create success message element
    const successElement = document.createElement("div");
    successElement.className = "success-message";
    successElement.textContent = message;

    // Insert success message after the form
    form.appendChild(successElement);
  }

  function clearMessages() {
    // Remove all error messages
    const errorMessages = document.querySelectorAll(".error-message");
    errorMessages.forEach((error) => error.remove());

    // Remove success message
    const successMessage = document.querySelector(".success-message");
    if (successMessage) {
      successMessage.remove();
    }

    // Reset input borders
    const inputs = document.querySelectorAll("input, textarea");
    inputs.forEach((input) => {
      input.style.borderColor = "#ddd";
    });
  }

  function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
});
