document.addEventListener('DOMContentLoaded', () => {

  // Mobile Menu
  const menuToggle = document.getElementById('menuToggle');
  const navLinks = document.getElementById('navLinks');

  if (menuToggle && navLinks) {
    menuToggle.addEventListener('click', () => {
      navLinks.classList.toggle('active');
      menuToggle.innerHTML = navLinks.classList.contains('active') 
        ? '<i class="fa-solid fa-xmark"></i>' 
        : '<i class="fa-solid fa-bars"></i>';
    });

    // Close menu when clicking a link
    navLinks.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navLinks.classList.remove('active');
        menuToggle.innerHTML = '<i class="fa-solid fa-bars"></i>';
      });
    });
  }

  // Dark Mode Toggle
  const themeToggle = document.getElementById('themeToggle');
  if (themeToggle) {
    const htmlEl = document.documentElement;
    const bodyEl = document.body;
    
    // Set initial icon based on applied class
    if (htmlEl.classList.contains('dark-mode')) {
      themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
      bodyEl.classList.add('dark-mode');
    } else {
      themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i>';
      bodyEl.classList.add('light-mode');
    }

    themeToggle.addEventListener('click', () => {
      if (htmlEl.classList.contains('dark-mode')) {
        htmlEl.classList.remove('dark-mode');
        htmlEl.classList.add('light-mode');
        bodyEl.classList.remove('dark-mode');
        bodyEl.classList.add('light-mode');
        localStorage.setItem('theme', 'light');
        themeToggle.innerHTML = '<i class="fa-solid fa-moon"></i>';
      } else {
        htmlEl.classList.remove('light-mode');
        htmlEl.classList.add('dark-mode');
        bodyEl.classList.remove('light-mode');
        bodyEl.classList.add('dark-mode');
        localStorage.setItem('theme', 'dark');
        themeToggle.innerHTML = '<i class="fa-solid fa-sun"></i>';
      }
    });
  }

  // Typewriter Effect
  const typeEl = document.getElementById('typewriter');
  if (typeEl) {
    const fullText = typeEl.getAttribute('data-text') || '';
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = fullText;
    const decodedText = tempDiv.textContent || tempDiv.innerText || '';
    
    let idx = 0;
    typeEl.textContent = '';

    function type() {
      if (idx < decodedText.length) {
        typeEl.textContent += decodedText.charAt(idx);
        idx++;
        setTimeout(type, 50);
      }
    }
    setTimeout(type, 600);
  }

  // Reveal Animations
  const reveals = document.querySelectorAll('.reveal');
  function checkReveal() {
    const windowHeight = window.innerHeight;
    const elementVisible = 100;
    reveals.forEach(reveal => {
      const elementTop = reveal.getBoundingClientRect().top;
      if (elementTop < windowHeight - elementVisible) {
        reveal.classList.add('visible');
      }
    });
  }
  
  // Add CSS for reveal dynamically here just to be sure
  const style = document.createElement('style');
  style.textContent = `
    .reveal { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
    .reveal.visible { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    .delay-4 { transition-delay: 0.4s; }
    .delay-5 { transition-delay: 0.5s; }
  `;
  document.head.appendChild(style);

  window.addEventListener('scroll', checkReveal);
  checkReveal();

});
