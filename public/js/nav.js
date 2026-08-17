// Équivalent du state "open" de src/components/Nav.tsx (menu mobile).
document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.nav__toggle');
  const drawerNav = document.querySelector('.nav__mobile');
  if (!toggle || !drawerNav) return;

  const iconOpen = toggle.querySelector('[data-icon="open"]');
  const iconClose = toggle.querySelector('[data-icon="close"]');

  function setOpen(open) {
    drawerNav.setAttribute('data-open', open ? 'true' : 'false');
    toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (iconOpen && iconClose) {
      iconOpen.style.display = open ? 'none' : '';
      iconClose.style.display = open ? '' : 'none';
    }
  }

  toggle.addEventListener('click', () => {
    const isOpen = drawerNav.getAttribute('data-open') === 'true';
    setOpen(!isOpen);
  });

  drawerNav.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', () => setOpen(false));
  });
});
