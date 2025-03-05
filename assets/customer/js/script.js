// Menu Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('menuSearch');
    const menuItems = document.querySelectorAll('.menu-item');

    function filterMenu() {
        const searchTerm = searchInput.value.toLowerCase();
        
        menuItems.forEach(item => {
            const itemName = item.querySelector('.card-title').textContent.toLowerCase();
            const itemDescription = item.querySelector('.card-text').textContent.toLowerCase();
            
            if (itemName.includes(searchTerm) || itemDescription.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterMenu);
    document.getElementById('searchButton').addEventListener('click', filterMenu);
});
