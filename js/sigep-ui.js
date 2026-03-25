/**
 * SIGEP - UI Enhancements
 * Mejoras de interfaz de usuario
 */

(function() {
    'use strict';
    
    // Inicializar mejoras UI
    document.addEventListener('DOMContentLoaded', function() {
        enhanceButtons();
        addCardEffects();
        initParallaxEffect();
        addTypewriterEffect();
    });
    
    /**
     * Mejora los botones con efectos adicionales
     */
    function enhanceButtons() {
        document.querySelectorAll('.btn, button:not(.btn-custom)').forEach(button => {
            button.classList.add('btn-custom', 'btn-primary-custom');
            
            button.addEventListener('mousedown', function(e) {
                const ripple = document.createElement('span');
                ripple.className = 'ripple-effect';
                ripple.style.cssText = `
                    position: absolute;
                    background: rgba(255,255,255,0.3);
                    border-radius: 50%;
                    width: 100px;
                    height: 100px;
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                
                const rect = this.getBoundingClientRect();
                ripple.style.left = `${e.clientX - rect.left - 50}px`;
                ripple.style.top = `${e.clientY - rect.top - 50}px`;
                
                this.style.position = 'relative';
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });
    }
    
    /**
     * Agrega efectos a las tarjetas
     */
    function addCardEffects() {
        document.querySelectorAll('.content-card, .feature-card').forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 20;
                const rotateY = (centerX - x) / 20;
                
                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateY(0)';
            });
        });
    }
    
    /**
     * Efecto parallax en el fondo
     */
    function initParallaxEffect() {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('body::before');
            if (parallax) {
                document.body.style.backgroundPositionY = `${scrolled * 0.5}px`;
            }
        });
    }
    
    /**
     * Efecto de máquina de escribir para títulos
     */
    function addTypewriterEffect() {
        const titles = document.querySelectorAll('h2, h3');
        titles.forEach(title => {
            if (title.classList.contains('typewriter-effect')) return;
            
            const originalText = title.textContent;
            title.textContent = '';
            title.classList.add('typewriter-effect');
            
            let i = 0;
            const typeInterval = setInterval(() => {
                if (i < originalText.length) {
                    title.textContent += originalText.charAt(i);
                    i++;
                } else {
                    clearInterval(typeInterval);
                }
            }, 50);
        });
    }
    
    // Agregar estilos para efectos adicionales
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }
        
        .typewriter-effect {
            overflow: hidden;
            white-space: nowrap;
            animation: blink-caret 0.75s step-end infinite;
        }
        
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: var(--primary-blue); }
        }
        
        .btn-custom {
            position: relative;
            overflow: hidden;
        }
        
        .ripple-effect {
            position: absolute;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            pointer-events: none;
            z-index: 1;
        }
    `;
    document.head.appendChild(style);
})();