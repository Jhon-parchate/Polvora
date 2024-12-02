const menuBtn = document.getElementById('menuBtn');
const mobileMenu = document.getElementById('mobileMenu');
const overlay = document.getElementById('overlay');
let cartCount = 0;

menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('active');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', () => {
    mobileMenu.classList.remove('active');
    overlay.classList.remove('active');
});

document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        cartCount++;
        document.querySelector('.cart-count').textContent = cartCount;
        
        button.style.transform = 'scale(0.95)';
        setTimeout(() => {
            button.style.transform = 'scale(1)';
        }, 100);
    });
});

// Animación de entrada para las tarjetas de productos
const observerOptions = {
    threshold: 0.1
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
            setTimeout(() => {
                entry.target.classList.add('visible');
            }, index * 100);
        }
    });
}, observerOptions);

document.querySelectorAll('.product-card').forEach(card => {
    observer.observe(card);
});

