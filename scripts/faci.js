document.addEventListener('DOMContentLoaded', function() {
    // Facility details data
    const facilityDetails = {
        'infinity-pool': {
            title: 'Infinity Pool',
            image: '../assets/popup-pool.jpg',
            description: `Our signature infinity pool is a masterpiece of architectural design, seamlessly blending with the horizon of the ocean. This award-winning facility spans 150 feet of pure luxury, maintained at the perfect temperature year-round.

            The pool area features private cabanas, underwater music, and fiber-optic lighting that creates a magical atmosphere at night. Our pool attendants provide premium service, including chilled towels, refreshing beverages, and luxury suncare products.`,
            features: [
                'Temperature-controlled waters',
                'Underwater LED lighting',
                'Private luxury cabanas',
                'Pool-side food & beverage service',
                'Dedicated pool attendants',
                'Premium sunbeds and umbrellas',
                'Complimentary towel service',
                'Underwater music system'
            ]
        },
        'luxury-spa': {
            title: 'Luxury Spa',
            image: '../assets/spa-pop.jpg',
            description: `Welcome to our world-class spa sanctuary, where ancient healing traditions meet modern luxury. Our spa spans over 20,000 square feet of pure serenity, featuring 12 treatment rooms, including couples' suites and private spa pavilions.

            Each treatment is customized using premium products and techniques developed by leading wellness experts. Our spa menu includes exclusive treatments inspired by global healing traditions, delivered by internationally trained therapists.`,
            features: [
                'Private treatment rooms',
                'Couples spa suites',
                'Hydrotherapy pools',
                'Turkish hammam',
                'Aromatherapy steam rooms',
                'Meditation gardens',
                'Premium spa products',
                'Expert therapeutic treatments'
            ]
        },
        'elite-fitness': {
            title: 'Elite Fitness Center',
            image: '../assets/gym.jpg',
            description: `Our state-of-the-art fitness center offers an unparalleled exercise experience with panoramic ocean views. Equipped with the latest Technogym and Life Fitness equipment, our center caters to all fitness levels and goals.

            Personal trainers certified by leading international organizations are available for one-on-one sessions, group classes, and customized workout programs. The center also features a dedicated yoga studio, spin room, and outdoor training area.`,
            features: [
                'Latest cardio equipment',
                'Premium weight training area',
                'Personal training services',
                'Group fitness classes',
                'Dedicated yoga studio',
                'Nutrition consultation',
                'Performance tracking',
                'Recovery zone'
            ]
        }
    };

    // Slider functionality
    function initializeSlider() {
        const container = document.querySelector('.slider-container');
        if (!container) return;

        const slides = container.querySelectorAll('.slider-card');
        const prevBtn = container.querySelector('.prev-btn');
        const nextBtn = container.querySelector('.next-btn');
        let currentIndex = 0;

        function showSlide(index, direction = 'right') {
            const currentSlide = container.querySelector('.slider-card.active');
            const nextSlide = slides[index];
            
            // Reset any ongoing animations
            slides.forEach(slide => {
                slide.style.animation = '';
            });
            
            if (currentSlide) {
                // Display next slide behind current
                nextSlide.style.display = 'block';
                
                // Determine animation direction
                const animationIn = direction === 'right' ? 'slideLeft' : 'slideRight';
                nextSlide.style.animation = `${animationIn} 0.5s forwards`;
                
                // Remove active class from current slide after animation
                currentSlide.classList.remove('active');
                nextSlide.classList.add('active');
            } else {
                // First time showing slides
                nextSlide.classList.add('active');
                nextSlide.style.display = 'block';
            }
        }
        
        // Update the nextSlide and prevSlide functions
        function nextSlide() {
            currentIndex = (currentIndex + 1) % slides.length;
            showSlide(currentIndex, 'right');
        }
        
        function prevSlide() {
            currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            showSlide(currentIndex, 'left');
        }

        // Initialize first slide
        showSlide(currentIndex);

        // Event listeners for buttons
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        // Auto-advance slides every 5 seconds
        let slideInterval = setInterval(nextSlide, 5000);

        // Pause auto-advance on hover
        container.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        container.addEventListener('mouseleave', () => {
            slideInterval = setInterval(nextSlide, 5000);
        });

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevSlide();
            } else if (e.key === 'ArrowRight') {
                nextSlide();
            }
        });
    }

    // Gallery functionality
    function initializeGallery() {
        const openGalleryBtn = document.getElementById('openGallery');
        const closeGalleryBtn = document.getElementById('closeGallery');
        const galleryLightbox = document.getElementById('galleryLightbox');
        const galleryItems = document.querySelectorAll('.gallery-item');

        if (!galleryLightbox || !openGalleryBtn || !closeGalleryBtn) return;

        // Ensure gallery is hidden by default
        galleryLightbox.style.display = 'none';
        document.body.style.overflow = 'auto';

        openGalleryBtn.addEventListener('click', () => {
            galleryLightbox.style.display = 'block';
            document.body.style.overflow = 'hidden';
        });

        closeGalleryBtn.addEventListener('click', () => {
            galleryLightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        });

        galleryLightbox.addEventListener('click', (e) => {
            if (e.target === galleryLightbox) {
                galleryLightbox.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && galleryLightbox.style.display === 'block') {
                galleryLightbox.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        // Optional: Add click handlers to gallery items for full-screen view
        galleryItems.forEach(item => {
            item.addEventListener('click', () => {
                const img = item.querySelector('img');
                const caption = item.querySelector('.gallery-caption');
                // Add your full-screen image view logic here
            });
        });
    }

    // Facility popup functionality
    function initializeFacilityPopups() {
        const popup = document.getElementById('facilityPopup');
        if (!popup) return;

        // Ensure popup is hidden by default
        popup.style.display = 'none';
        document.body.style.overflow = 'auto';

        document.querySelectorAll('.facility-card').forEach(card => {
            const overlay = card.querySelector('.facility-overlay');
            if (!overlay) return;

            overlay.addEventListener('click', () => {
                const facilityId = card.getAttribute('data-facility');
                const details = facilityDetails[facilityId];
                if (!details) return;

                // Populate popup content
                const popupImage = document.getElementById('popupImage');
                const popupTitle = document.getElementById('popupTitle');
                const popupDescription = document.getElementById('popupDescription');
                const featuresGrid = document.getElementById('popupFeatures');

                if (popupImage) popupImage.src = details.image;
                if (popupTitle) popupTitle.textContent = details.title;
                if (popupDescription) popupDescription.textContent = details.description;
                
                if (featuresGrid) {
                    featuresGrid.innerHTML = ''; // Clear existing features
                    details.features.forEach(feature => {
                        const featureElement = document.createElement('div');
                        featureElement.className = 'facility-feature';
                        featureElement.textContent = feature;
                        featuresGrid.appendChild(featureElement);
                    });
                }

                // Show popup
                popup.style.display = 'block';
                document.body.style.overflow = 'hidden';
            });
        });

        // Close popup handlers
        const closeBtn = popup.querySelector('.facility-popup-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                popup.style.display = 'none';
                document.body.style.overflow = 'auto';
            });
        }

        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                popup.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && popup.style.display === 'block') {
                popup.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }

    // Intersection Observer for animations
    function initializeAnimations() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.facility-card, .amenity-item, .slider-container, .service-column').forEach(el => {
            observer.observe(el);
        });
    }

    // Initialize all functionalities
    initializeSlider();
    initializeGallery();
    initializeFacilityPopups();
    initializeAnimations();

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});