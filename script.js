const buttons = document.querySelectorAll('.day-btn');
const box = document.getElementById('animated-box');

const colors = {
  Monday: 'red',
  Tuesday: 'orange',
  Wednesday: 'yellow',
  Thursday: 'green',
  Friday: 'blue',
  Saturday: 'indigo',
  Sunday: 'violet',
};

buttons.forEach((button) => {
  button.addEventListener('click', () => {
    const day = button.getAttribute('data-day');
    const color = colors[day];

    box.style.transition = 'none';
    box.style.transform = 'translateY(-300px)';
    void box.offsetWidth; 

    box.style.transition = 'transform 1s ease, background-color 0.5s ease';
    box.style.transform = 'translateY(100px)';
    box.style.backgroundColor = color;

    box.classList.add('visible');
  });
});
