// ===============================
// MODAL DE RECETAS (GLOBAL)
// ===============================

document.addEventListener('DOMContentLoaded', () => {
  const modal = document.getElementById('recipe-modal');
  const modalBody = document.getElementById('recipe-modal-body');
  const modalClose = document.getElementById('recipe-modal-close');

  if (!modal || !modalBody || !modalClose) return;

  function openRecipeModal(recipeId) {
    const article = document.getElementById(recipeId);
    if (!article) return;

    modalBody.innerHTML = article.innerHTML;
    modal.hidden = false;
  }

  function closeRecipeModal() {
    modal.hidden = true;
    modalBody.innerHTML = '';
  }

  modalClose.addEventListener('click', closeRecipeModal);

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeRecipeModal();
    }
  });

  const reveals = document.querySelectorAll('.reveal');

  window.addEventListener('scroll', () => {
    reveals.forEach(el => {
      const windowHeight = window.innerHeight;
      const elementTop = el.getBoundingClientRect().top;

      if (elementTop < windowHeight - 100) {
        el.classList.add('active');
      }
    });
  });

  document.querySelectorAll('[data-open-modal]').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-open-modal');
      openRecipeModal(id);
    });
  });
});