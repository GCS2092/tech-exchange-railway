// resources/js/responsive.js
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du menu mobile
    const mobileMenuButton = document.querySelector('[x-data="{ open: false }"] button');
    const mobileMenu = document.querySelector('[x-data="{ open: false }"] + div');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isOpen = mobileMenu.classList.contains('block');
            
            if (isOpen) {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            } else {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('block');
            }
        });
    }
    
    // Gestion des dropdowns
    document.querySelectorAll('[x-data="{ dropdownOpen: false }"]').forEach(dropdown => {
        const button = dropdown.querySelector('button');
        const menu = dropdown.querySelector('div[x-show="dropdownOpen"]');
        
        if (button && menu) {
            button.addEventListener('click', function() {
                const isOpen = menu.classList.contains('block');
                
                if (isOpen) {
                    menu.classList.remove('block');
                    menu.classList.add('hidden');
                } else {
                    menu.classList.remove('hidden');
                    menu.classList.add('block');
                }
            });
            
            // Fermeture au clic ailleurs
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && menu.classList.contains('block')) {
                    menu.classList.remove('block');
                    menu.classList.add('hidden');
                }
            });
        }
    });
    
    // Ajustement pour les écrans en rotation
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 640) { // Taille sm
            document.querySelectorAll('.hidden.sm\\:block').forEach(el => {
                el.classList.remove('hidden');
            });
            
            if (mobileMenu && mobileMenu.classList.contains('block')) {
                mobileMenu.classList.remove('block');
                mobileMenu.classList.add('hidden');
            }
        }
    });
});