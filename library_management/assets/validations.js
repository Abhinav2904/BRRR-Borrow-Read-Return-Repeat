// Real-time input validations
function validateInput(input, regex, errorMsg) {
    const errorElement = input.nextElementSibling;
    if (!regex.test(input.value)) {
        errorElement.textContent = errorMsg;
        input.classList.add("is-invalid");
    } else {
        errorElement.textContent = "";
        input.classList.remove("is-invalid");
    }
}

// Validate Name
document.getElementById("name")?.addEventListener("blur", function () {
    validateInput(this, /^[a-zA-Z\s]+$/, "Name must contain only letters and spaces.");
});

// Validate Phone
document.getElementById("phone")?.addEventListener("blur", function () {
    validateInput(this, /^\d{10}$/, "Phone number must be 10 digits.");
});

// Validate Email
document.getElementById("email")?.addEventListener("blur", function () {
    validateInput(this, /^[^\s@]+@[^\s@]+\.[^\s@]+$/, "Enter a valid email address.");
});

// Validate Password
document.getElementById("password")?.addEventListener("blur", function () {
    validateInput(this, /^.{6,}$/, "Password must be at least 6 characters long.");
});

// Validate Date of Birth
document.getElementById("dob")?.addEventListener("blur", function () {
    const date = new Date(this.value);
    const minDate = new Date();
    minDate.setFullYear(minDate.getFullYear() - 15);
    if (date > minDate) {
        this.nextElementSibling.textContent = "You must be at least 15 years old.";
        this.classList.add("is-invalid");
    } else {
        this.nextElementSibling.textContent = "";
        this.classList.remove("is-invalid");
    }
});
