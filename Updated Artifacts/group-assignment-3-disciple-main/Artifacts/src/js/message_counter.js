const area  = document.querySelector('#message');
const counter  = document.querySelector('#counter');

area.addEventListener('input', updateCounter);

function updateCounter() {
  counter.textContent = area.value.length;
}
