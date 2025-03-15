const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});



// responsive
// document.addEventListener("DOMContentLoaded", function () {
//     // Mobile menu toggle
//     const menuButton = document.createElement("button");
//     menuButton.textContent = "☰ Menu";
//     menuButton.style.background = "white";
//     menuButton.style.border = "none";
//     menuButton.style.padding = "10px";
//     menuButton.style.cursor = "pointer";
//     menuButton.style.fontSize = "16px";
    
//     const navbar = document.querySelector(".navbar");
//     const navList = document.querySelector(".navdiv ul");

//     navbar.insertBefore(menuButton, navList);

//     menuButton.addEventListener("click", function () {
//         navList.style.display = navList.style.display === "block" ? "none" : "block";
//     });

//     // Form animation
//     const signInBtn = document.getElementById("signIn");
//     const signUpBtn = document.getElementById("signUp");
//     const container = document.getElementById("container");

//     signUpBtn.addEventListener("click", () => {
//         container.classList.add("right-panel-active");
//     });

//     signInBtn.addEventListener("click", () => {
//         container.classList.remove("right-panel-active");
//     });

//     // Update footer year dynamically
//     document.getElementById("current-year").textContent = new Date().getFullYear();
// });

