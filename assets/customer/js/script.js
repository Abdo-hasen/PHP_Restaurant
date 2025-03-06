// Menu Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const searchButton = document.getElementById('searchButton');
    const menuItems = document.querySelectorAll('.card-title');
    const categoryButtons = document.querySelectorAll('.category-btn');

    function searchMenuItems() {
        const searchTerm = searchInput.value.toLowerCase();
        
        document.querySelectorAll('.items-container').forEach(container => {
            container.style.display = 'block';
        });

        menuItems.forEach(item => {
            const card = item.closest('.col-md-4');
            if (item.textContent.toLowerCase().includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

      
        if (searchTerm === '') {
            document.querySelectorAll('.items-container').forEach((container, index) => {
                container.style.display = index === 0 ? 'block' : 'none';
            });
            categoryButtons.forEach((button, index) => {
                button.classList.toggle('active', index === 0);
            });
        }
    }

    searchInput.addEventListener('input', searchMenuItems);
    searchButton.addEventListener('click', searchMenuItems);
});
