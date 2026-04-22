document.querySelectorAll('[data-accordion-toggle]').forEach(btn => {
    const panelId = btn.getAttribute('data-accordion-toggle');
    const panel = document.getElementById(panelId);
    const chevron = btn.querySelector('.accordion-chevron');

    btn.addEventListener('click', () => {
        const isOpen = panel.classList.toggle('open');
        chevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        btn.setAttribute('aria-expanded', isOpen);
    });
});