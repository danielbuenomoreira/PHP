const container = document.querySelector('.container');
const totalCircles = 22; // Quantos círculos você quer

for (let i = 0; i <= totalCircles; i++) {
    const circle = document.createElement('div');
    circle.className = 'circle';
    circle.style.setProperty('--i', i);
    container.appendChild(circle);
}
