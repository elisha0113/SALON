const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

const animate = ScrollReveal({
    origin: "top", 
    distance: "60px",
    duration: "2500",
    delay: "400",
});

animate.reveal(".nav");