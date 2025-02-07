const button = document.getElementById("changeColor");
const resume = document.querySelector(".resume");

const colors = ["lawngreen", "darkgreen", "gold", "goldenrod"];
let currentColorIndex = 0;

button.addEventListener("click", () => {
    currentColorIndex = (currentColorIndex + 1) % colors.length;
    resume.style.backgroundColor = colors[currentColorIndex];
});
