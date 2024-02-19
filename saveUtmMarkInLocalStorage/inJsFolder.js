document.addEventListener("DOMContentLoaded", () => {
    const utm = localStorage.getItem("utm") === null ? "" : localStorage.getItem("utm");

    const utmInputs = document.querySelectorAll("input[name='utm']");
    utmInputs.forEach(input => {
       input.value = utm;
    });
});