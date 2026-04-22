// Toggle between Grid and List views in the vacancies listing page

(function () {
    const gridBtn = document.getElementById('grid-view-btn');
    const listBtn = document.getElementById('list-view-btn');
    const gridContainer = document.getElementById('grid-view-container');
    const listContainer = document.getElementById('list-view-container');

    const activeClasses = ['bg-[#1f74bf]', 'text-white'];
    const inactiveClasses = ['bg-surface-container-lowest', 'text-on-surface-variant', 'hover:text-primary'];

    gridBtn.addEventListener('click', () => {
        // Button Styles
        gridBtn.classList.add(...activeClasses);
        gridBtn.classList.remove(...inactiveClasses);
        listBtn.classList.add(...inactiveClasses);
        listBtn.classList.remove(...activeClasses);

        // Visibility
        gridContainer.classList.remove('hidden');
        listContainer.classList.add('hidden');
    });

    listBtn.addEventListener('click', () => {
        // Button Styles
        listBtn.classList.add(...activeClasses);
        listBtn.classList.remove(...inactiveClasses);
        gridBtn.classList.add(...inactiveClasses);
        gridBtn.classList.remove(...activeClasses);

        // Visibility
        listContainer.classList.remove('hidden');
        gridContainer.classList.add('hidden');
    });
})();