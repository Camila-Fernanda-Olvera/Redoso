document.addEventListener('DOMContentLoaded', () => {
    console.log('Profile JS loaded');

    // Like Button Interaction
    const likeButtons = document.querySelectorAll('.action-btn');
    
    likeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            if (this.textContent.includes('Me gusta')) {
                this.style.color = this.style.color === 'rgb(24, 119, 242)' ? '#65676b' : '#1877f2';
                // Toggle text weight or icon if needed
            }
        });
    });

    // Create Post Input Focus
    const postInput = document.querySelector('.create-post-input');
    if (postInput) {
        postInput.addEventListener('click', () => {
            alert('Funcionalidad de crear publicación próximamente...');
        });
    }
});
