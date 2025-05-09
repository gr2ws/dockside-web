document.addEventListener('DOMContentLoaded', () => {
    const collapsibles = document.querySelectorAll('.collapsible');
    collapsibles.forEach((collapsible) => {
        collapsible.addEventListener('click', () => {
            collapsible.classList.toggle('active');
            const content = collapsible.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
            }
        });
    });

    const searchInput = document.getElementById('facilitySearch');
    const facilityCards = document.querySelectorAll('.facility-card');

    searchInput.addEventListener('input', () => {
        const filter = searchInput.value.toLowerCase();
        facilityCards.forEach(card => {
            const name = card.getAttribute('data-name').toLowerCase();
            if (name.includes(filter)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
});