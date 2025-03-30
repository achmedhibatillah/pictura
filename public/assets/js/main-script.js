document.addEventListener("DOMContentLoaded", function () {
    const noSpaceFields = document.querySelectorAll(".no-space");
    const noCapitalFields = document.querySelectorAll(".no-capital");
    const noSymbolFields = document.querySelectorAll(".no-symbol");
    
    noSpaceFields.forEach(input => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/\s/g, "");
        });
    });
    
    noCapitalFields.forEach(input => {
        input.addEventListener("input", function () {
            this.value = this.value.toLowerCase();
        });
    });
    
    noSymbolFields.forEach(input => {
        input.addEventListener("input", function () {
            this.value = this.value.replace(/[^a-zA-Z0-9._]/g, "");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const showPasswordToggles = document.querySelectorAll(".show-password");
    const passwordFields = document.querySelectorAll(".password-container .password");

    showPasswordToggles.forEach(toggle => {
        toggle.addEventListener("change", function () {
            const type = this.checked ? "text" : "password";
            passwordFields.forEach(field => {
                field.type = type;
            });
        });
    });
});
