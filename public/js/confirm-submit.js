// Équivalent de src/app/admin/ConfirmSubmit.tsx
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('[data-confirm]').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      if (!window.confirm(btn.dataset.confirm)) {
        e.preventDefault();
      }
    });
  });
});
