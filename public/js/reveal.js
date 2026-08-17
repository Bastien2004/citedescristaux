// Équivalent de src/components/Reveal.tsx
document.addEventListener('DOMContentLoaded', () => {
  document.documentElement.setAttribute('data-js', '1');

  const nodes = Array.from(document.querySelectorAll('.reveal'));
  if (!nodes.length) return;

  const revealAll = () => nodes.forEach((n) => n.setAttribute('data-visible', 'true'));

  if (
    typeof IntersectionObserver === 'undefined' ||
    window.matchMedia('(prefers-reduced-motion: reduce)').matches
  ) {
    revealAll();
    return;
  }

  const io = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const delay = Number(el.dataset.delay || 0);
        window.setTimeout(() => el.setAttribute('data-visible', 'true'), delay);
        io.unobserve(el);
      });
    },
    { threshold: 0.08, rootMargin: '0px 0px -40px 0px' }
  );

  nodes.forEach((n) => {
    if (n.getAttribute('data-visible') !== 'true') io.observe(n);
  });
});
