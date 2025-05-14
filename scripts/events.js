document.addEventListener("DOMContentLoaded", () => {
    // Book Now button interactions
    const bookNowButtons = document.querySelectorAll(".book-now");
    bookNowButtons.forEach(button => {
        button.addEventListener("click", () => {
            const eventName = button.parentElement.querySelector("h2").textContent.trim();
            alert(`You have selected "${eventName}". Please proceed to the booking page.`);
        });
    });

    // Event cards navigation
    const eventList = document.querySelector('.event-list');
    const prevButton = document.querySelector('.prev-arrow');
    const nextButton = document.querySelector('.next-arrow');
    const cards = document.querySelectorAll('.event-card');
    const cardWidth = document.querySelector('.event-card').offsetWidth + 30; // Include gap
    let currentIndex = 0;
    let isScrolling = false;

    // Clone cards for infinite scroll
    function setupInfiniteScroll() {
        // Create enough clones to ensure continuous scrolling
        const originalCards = Array.from(cards);
        
        // Create multiple sets of clones (3 sets should be enough)
        for (let i = 0; i < 3; i++) {
            originalCards.forEach(card => {
                const clone = card.cloneNode(true);
                // Add click event to Book Now button in clone
                const bookButton = clone.querySelector('.book-now');
                if (bookButton) {
                    bookButton.addEventListener('click', () => {
                        const eventName = clone.querySelector("h2").textContent.trim();
                        alert(`You have selected "${eventName}". Please proceed to the booking page.`);
                    });
                }
                eventList.appendChild(clone);
            });
        }
    }

    // Function to scroll to next or previous card
    const scrollCards = (direction) => {
        if (isScrolling) return;
        isScrolling = true;

        const scrollAmount = direction === 'next' ? cardWidth : -cardWidth;
        
        // Calculate new scroll position
        let newScrollPosition = eventList.scrollLeft + scrollAmount;
        
        // Smooth scroll to new position
        eventList.scrollTo({
            left: newScrollPosition,
            behavior: 'smooth'
        });

        // Reset isScrolling after animation
        setTimeout(() => {
            isScrolling = false;
        }, 500);

        // Update current index
        currentIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;
    };

    // Button click handlers
    if (prevButton && nextButton) {
        prevButton.addEventListener('click', () => scrollCards('prev'));
        nextButton.addEventListener('click', () => scrollCards('next'));
    }

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            scrollCards('prev');
        } else if (e.key === 'ArrowRight') {
            scrollCards('next');
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        const newCardWidth = document.querySelector('.event-card').offsetWidth + 30;
        if (newCardWidth !== cardWidth) {
            eventList.scrollLeft = currentIndex * newCardWidth;
        }
    });

    // Initialize infinite scroll
    setupInfiniteScroll();

});