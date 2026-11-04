// Hitlovers Wishlist - JavaScript

// Modal functionality
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('instagramModal');
    const closeBtn = document.querySelector('.close-btn');
    
    // Check if we should show the modal (from URL parameter)
    const urlParams = new URLSearchParams(window.location.search);
    const showModal = urlParams.get('showModal') === '1';
    const success = urlParams.get('success') === '1';
    
    // Show modal if triggered
    if (showModal && success) {
        setTimeout(() => {
            modal.classList.add('show');
        }, 500);
    }
    
    // Close modal when X is clicked
    closeBtn.addEventListener('click', function() {
        modal.classList.remove('show');
        // Remove parameters from URL
        const url = new URL(window.location.href);
        url.searchParams.delete('success');
        url.searchParams.delete('showModal');
        window.history.replaceState({}, document.title, url.pathname);
    });
    
    // Close modal when clicking outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.classList.remove('show');
            const url = new URL(window.location.href);
            url.searchParams.delete('success');
            url.searchParams.delete('showModal');
            window.history.replaceState({}, document.title, url.pathname);
        }
    });
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.classList.contains('show')) {
            modal.classList.remove('show');
            const url = new URL(window.location.href);
            url.searchParams.delete('success');
            url.searchParams.delete('showModal');
            window.history.replaceState({}, document.title, url.pathname);
        }
    });
    
    // Add animation to form inputs
    const formInputs = document.querySelectorAll('.form-group input, .form-group textarea');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.boxShadow = '0 8px 25px rgba(233, 69, 96, 0.2)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = '';
            this.parentElement.style.boxShadow = '';
        });
    });
    
    // Add click animation to buttons
    const buttons = document.querySelectorAll('.btn, .social-link');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s ease-out;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
    
    // Add CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
    
    // Smooth scroll for any anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Add loading animation to form submission
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    form.addEventListener('submit', function() {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<span>Sender...</span> <i class="fas fa-spinner fa-spin"></i>';
            submitBtn.disabled = true;
        }
    });
});
