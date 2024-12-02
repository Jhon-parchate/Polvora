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





document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('overlay');
    
    // Menú móvil
    menuBtn.addEventListener('click', function() {
        mobileMenu.classList.toggle('active');
        overlay.classList.toggle('active');
    });
    
    overlay.addEventListener('click', function() {
        mobileMenu.classList.remove('active');
        overlay.classList.remove('active');
    });
    
    // Efecto de partículas para los botones
    document.querySelectorAll('button').forEach(button => {
        button.addEventListener('click', function(e) {
            const x = e.clientX - e.target.offsetLeft;
            const y = e.clientY - e.target.offsetTop;
            
            const ripple = document.createElement('span');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });
    
    // Animación de números en el contador del carrito
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.addEventListener('change', function() {
            cartCount.classList.add('bump');
            setTimeout(() => cartCount.classList.remove('bump'), 300);
        });
    }
});