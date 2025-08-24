// Simplified Preparation Page JavaScript
console.log('Preparation JS loading...');

// Wait for DOM to be ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM ready - initializing preparation page');
    
    // Initialize sidebar functionality
    initializeSidebar();
    initializeNavigation();
    setDefaultState();
});

function initializeSidebar() {
    console.log('Initializing sidebar...');
    
    const categoryHeaders = document.querySelectorAll('.category-header');
    console.log('Found category headers:', categoryHeaders.length);
    
    categoryHeaders.forEach((header, index) => {
        console.log(`Setting up header ${index + 1}`);
        
        header.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Category header clicked');
            
            const category = this.closest('.nav-category');
            if (!category) {
                console.error('Could not find parent nav-category');
                return;
            }
            
            toggleCategory(category);
        });
        
        // Add visual feedback
        header.style.cursor = 'pointer';
    });
}

function toggleCategory(category) {
    const isCurrentlyActive = category.classList.contains('active');
    console.log('Toggling category. Currently active:', isCurrentlyActive);
    
    // Close all categories first
    document.querySelectorAll('.nav-category').forEach(cat => {
        cat.classList.remove('active');
    });
    
    // If the clicked category wasn't active, make it active
    if (!isCurrentlyActive) {
        category.classList.add('active');
        console.log('Category activated');
    } else {
        console.log('Category deactivated');
    }
}

function initializeNavigation() {
    console.log('Initializing navigation...');
    
    const navItems = document.querySelectorAll('.nav-item');
    console.log('Found nav items:', navItems.length);
    
    navItems.forEach((item, index) => {
        console.log(`Setting up nav item ${index + 1}:`, item.getAttribute('href'));
        
        item.addEventListener('click', function(e) {
            e.preventDefault();
            
            console.log('Nav item clicked:', this.getAttribute('href'));
            
            // Remove active from all nav items
            navItems.forEach(nav => nav.classList.remove('active'));
            
            // Add active to clicked item
            this.classList.add('active');
            
            // Show corresponding content
            const targetId = this.getAttribute('href').substring(1);
            showContent(targetId);
        });
    });
}

function showContent(sectionId) {
    console.log('Showing content section:', sectionId);
    
    // Hide all content sections
    const contentSections = document.querySelectorAll('.content-section');
    contentSections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show target section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
        console.log('Content section activated:', sectionId);
        
        // Scroll to top of content
        const contentArea = document.querySelector('.preparation-content');
        if (contentArea) {
            contentArea.scrollTop = 0;
        }
    } else {
        console.error('Could not find content section:', sectionId);
    }
}

function setDefaultState() {
    console.log('Setting default state...');
    
    // Ensure first category is open
    const firstCategory = document.querySelector('.nav-category');
    if (firstCategory) {
        firstCategory.classList.add('active');
        console.log('First category set as active');
    }
    
    // Ensure first nav item is active
    const firstNavItem = document.querySelector('.nav-item');
    if (firstNavItem) {
        firstNavItem.classList.add('active');
        const targetId = firstNavItem.getAttribute('href').substring(1);
        showContent(targetId);
        console.log('First nav item set as active');
    }
}

// Add some error handling
window.addEventListener('error', function(e) {
    console.error('JavaScript error:', e.error);
});

console.log('Preparation JS loaded successfully');
