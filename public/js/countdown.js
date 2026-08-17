// Équivalent de src/components/Countdown.tsx
(function () {
  function diff(target) {
    const ms = target - Date.now();
    if (ms <= 0) return null;
    return {
      d: Math.floor(ms / 86400000),
      h: Math.floor(ms / 3600000) % 24,
      m: Math.floor(ms / 60000) % 60,
      s: Math.floor(ms / 1000) % 60,
    };
  }

  function render(el, parts, label, doneLabel) {
    const labelEl = el.querySelector('.countdown__label');
    const gridEl = el.querySelector('.countdown__grid');

    if (!parts) {
      el.classList.add('countdown--live');
      if (labelEl) labelEl.textContent = doneLabel;
      if (gridEl) gridEl.remove();
      return;
    }

    if (labelEl) labelEl.textContent = label;

    const cells = [
      [parts.d, 'jours'],
      [String(parts.h).padStart(2, '0'), 'heures'],
      [String(parts.m).padStart(2, '0'), 'minutes'],
      [String(parts.s).padStart(2, '0'), 'secondes'],
    ];

    if (gridEl) {
      cells.forEach(([value, unit], i) => {
        const numEl = gridEl.children[i]?.querySelector('.countdown__num');
        if (numEl) numEl.textContent = value;
      });
    }
  }

  function initCountdown(el) {
    const target = new Date(el.dataset.to).getTime();
    const label = el.dataset.label;
    const doneLabel = el.dataset.doneLabel || "C'est parti !";

    render(el, diff(target), label, doneLabel);

    const id = window.setInterval(() => {
      const parts = diff(target);
      render(el, parts, label, doneLabel);
      if (!parts) window.clearInterval(id);
    }, 1000);
  }

  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.countdown[data-to]').forEach(initCountdown);
  });
})();
