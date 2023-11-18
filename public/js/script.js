const carousel = document.querySelector('.carousel');
let currentSlide = 0;

function showSlide(slideIndex) {
    carousel.style.transform = `translateX(-${slideIndex * 100}%)`;
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % 4;
    showSlide(currentSlide);
}

setInterval(nextSlide, 5000);
