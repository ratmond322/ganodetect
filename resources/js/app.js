// resources/js/app.js
console.log('[App.js] Loading...');

import './bootstrap';
import AOS from 'aos';
import 'aos/dist/aos.css';
import 'leaflet/dist/leaflet.css';
import * as L from 'leaflet';
window.L = L;

import Chart from 'chart.js/auto';
window.Chart = Chart;

// ===== GSAP & ScrollTrigger =====
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
gsap.registerPlugin(ScrollTrigger);
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;

console.log('[App.js] GSAP loaded:', !!window.gsap);

// ===== Lenis Smooth Scroll =====
import Lenis from 'lenis';
import 'lenis/dist/lenis.css';

// ===== Initialize everything after DOM ready =====
document.addEventListener('DOMContentLoaded', () => {
  try {
    console.log('[App.js] DOM Ready - Initializing...');
    
    // Init Lenis
    const lenis = new Lenis({
      duration: 1.2,
      easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
      smooth: true,
    });
    window.lenis = lenis;

    function raf(time) {
      lenis.raf(time);
      requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Bridge Lenis dengan ScrollTrigger
    lenis.on('scroll', ScrollTrigger.update);
    gsap.ticker.add((time) => {
      lenis.raf(time * 1000);
    });
    gsap.ticker.lagSmoothing(0);

    console.log('[App.js] Lenis initialized');

    // Init AOS
    AOS.init({
      once: true,
      duration: 700,
    });
    console.log('[App.js] AOS initialized');

    // Init Parallax Effect
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (parallaxElements.length > 0) {
      parallaxElements.forEach(el => {
        const speed = parseFloat(el.getAttribute('data-parallax')) || 10;
        gsap.to(el, {
          y: () => window.scrollY * speed * 0.01,
          ease: 'none',
          scrollTrigger: {
            trigger: el,
            start: 'top bottom',
            end: 'bottom top',
            scrub: true,
            invalidateOnRefresh: true
          }
        });
      });
      console.log('[App.js] Parallax initialized for', parallaxElements.length, 'elements');
    }

    console.log('[App.js] All systems ready!');
  } catch (error) {
    console.error('[App.js] Initialization error:', error);
  }
});
