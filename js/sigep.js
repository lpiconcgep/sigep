/**
 * SIGEP - Sistema Integrado de Gestión de Postgrados
 * Funciones principales
 */

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function() {
    initSIGEP();
    addFadeInAnimation();
    initTooltips();
    initSmoothScroll();
});

/**
 * Inicialización principal del sistema
 */
function initSIGEP() {
    console.log('🚀 SIGEP inicializado correctamente');
    
    // Agregar clases de animación a elementos
    const elements = document.querySelectorAll('.page-header, .content-card, .feature-card');
    elements.forEach((el, index) => {
        el.style.animationDelay = `${index * 0.1}s`;
        el.classList.add('fade-in-up');
    });
}

/**
 * Agrega animación de fade-in a elementos con la clase 'fade-in-up'
 */
function addFadeInAnimation() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in-up:not(.visible)').forEach(el => {
        observer.observe(el);
    });
}

/**
 * Inicializa tooltips personalizados
 */
function initTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

/**
 * Muestra un tooltip personalizado
 */
function showTooltip(e) {
    const tooltip = document.createElement('div');
    tooltip.className = 'sigep-tooltip';
    tooltip.textContent = e.target.getAttribute('data-tooltip');
    tooltip.style.cssText = `
        position: absolute;
        background: var(--gradient-blue);
        color: white;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        z-index: 1000;
        pointer-events: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        animation: fadeIn 0.3s ease;
    `;
    
    document.body.appendChild(tooltip);
    
    const rect = e.target.getBoundingClientRect();
    tooltip.style.top = `${rect.top - tooltip.offsetHeight - 10 + window.scrollY}px`;
    tooltip.style.left = `${rect.left + (rect.width - tooltip.offsetWidth) / 2}px`;
    
    e.target._tooltip = tooltip;
}

/**
 * Oculta el tooltip
 */
function hideTooltip(e) {
    if (e.target._tooltip) {
        e.target._tooltip.remove();
        e.target._tooltip = null;
    }
}

/**
 * Inicializa smooth scroll para enlaces internos
 */
function initSmoothScroll() {
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
}

/**
 * Muestra un mensaje de notificación
 */
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `sigep-notification sigep-notification-${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 25px;
        background: ${type === 'success' ? 'var(--gradient-green)' : 'var(--gradient-blue)'};
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        cursor: pointer;
    `;
    
    notification.addEventListener('click', () => {
        notification.remove();
    });
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Agregar estilos dinámicos para notificaciones
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .sigep-tooltip {
        transition: all 0.3s ease;
    }
    
    .sigep-notification {
        transition: all 0.3s ease;
    }
    
    .sigep-notification:hover {
        transform: scale(1.05);
    }
`;
document.head.appendChild(style);