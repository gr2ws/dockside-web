document.addEventListener('DOMContentLoaded', function() {
    // Facility details data - stores information for facility popups
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

    // Initialize all components
    initializeExperienceSlider();
    initializeFacilityPopups();
    initializeGallery();
    initializeAnimations();

    // Experience Slider functionality
    function initializeExperienceSlider() {
        const experiences = document.querySelectorAll('.experience');
        const contents = document.querySelectorAll('.experience-content');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        let currentIndex = 0;
        let autoSlide;

        if (!experiences.length || !contents.length) return;

        function showExperience(index) {
            experiences.forEach(exp => {
                exp.classList.remove('active');
                exp.style.opacity = '0';
                exp.style.visibility = 'hidden';
            });
            contents.forEach(content => {
                content.classList.remove('active');
                content.style.opacity = '0';
                content.style.visibility = 'hidden';
            });

            experiences[index].classList.add('active');
            experiences[index].style.opacity = '1';
            experiences[index].style.visibility = 'visible';
            
            contents[index].classList.add('active');
            contents[index].style.opacity = '1';
            contents[index].style.visibility = 'visible';
        }

        function nextExperience() {
            currentIndex = (currentIndex + 1) % experiences.length;
            showExperience(currentIndex);
        }

        function prevExperience() {
            currentIndex = (currentIndex - 1 + experiences.length) % experiences.length;
            showExperience(currentIndex);
        }

        function startAutoSlide() {
            autoSlide = setInterval(nextExperience, 5000);
        }

        function resetAutoSlide() {
            clearInterval(autoSlide);
            startAutoSlide();
        }

        // Initialize first slide and auto-slide
        showExperience(0);
        startAutoSlide();

        // Event Listeners
        if (prevBtn && nextBtn) {
            prevBtn.addEventListener('click', () => {
                prevExperience();
                resetAutoSlide();
            });

            nextBtn.addEventListener('click', () => {
                nextExperience();
                resetAutoSlide();
            });
        }

        // Pause auto-slide on hover
        const sliderSection = document.querySelector('.experience-slider');
        if (sliderSection) {
            sliderSection.addEventListener('mouseenter', () => clearInterval(autoSlide));
            sliderSection.addEventListener('mouseleave', startAutoSlide);
        }

        // Keyboard navigation
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                prevExperience();
                resetAutoSlide();
            } else if (e.key === 'ArrowRight') {
                nextExperience();
                resetAutoSlide();
            }
        });
    }

    // Facility popup functionality
    function initializeFacilityPopups() {
        const popup = document.getElementById('facilityPopup');
        const facilityCards = document.querySelectorAll('.facility-card');

        if (!popup || !facilityCards.length) return;

        function closePopup() {
            popup.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function openPopup(facilityId) {
            const details = facilityDetails[facilityId];
            if (!details) return;

            const popupImage = document.getElementById('popupImage');
            const popupTitle = document.getElementById('popupTitle');
            const popupDescription = document.getElementById('popupDescription');
            const popupFeatures = document.getElementById('popupFeatures');

            if (popupImage) popupImage.src = details.image;
            if (popupTitle) popupTitle.textContent = details.title;
            if (popupDescription) popupDescription.textContent = details.description;

            if (popupFeatures) {
                popupFeatures.innerHTML = '';
                details.features.forEach(feature => {
                    const featureDiv = document.createElement('div');
                    featureDiv.className = 'facility-feature';
                    featureDiv.textContent = feature;
                    popupFeatures.appendChild(featureDiv);
                });
            }

            popup.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        // Event Listeners
        facilityCards.forEach(card => {
            const overlay = card.querySelector('.facility-overlay');
            if (!overlay) return;

            overlay.addEventListener('click', (e) => {
                e.preventDefault();
                const facilityId = card.getAttribute('data-facility');
                if (facilityId) {
                    openPopup(facilityId);
                }
            });
        });

        const closeBtn = popup.querySelector('.facility-popup-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', closePopup);
        }

        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                closePopup();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && popup.style.display === 'flex') {
                closePopup();
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

        function closeGallery() {
            galleryLightbox.style.opacity = '0';
            setTimeout(() => {
                galleryLightbox.style.display = 'none';
                document.body.style.overflow = 'auto';
            }, 300);
        }

        function openGallery() {
            galleryLightbox.style.display = 'block';
            document.body.style.overflow = 'hidden';
            requestAnimationFrame(() => {
                galleryLightbox.style.opacity = '1';
            });
        }

        // Initialize gallery transitions
        galleryLightbox.style.transition = 'opacity 0.3s ease';
        galleryLightbox.style.opacity = '0';

        // Event Listeners
        openGalleryBtn.addEventListener('click', openGallery);
        closeGalleryBtn.addEventListener('click', closeGallery);

        galleryLightbox.addEventListener('click', (e) => {
            if (e.target === galleryLightbox) {
                closeGallery();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && galleryLightbox.style.display === 'block') {
                closeGallery();
            }
        });

        // Gallery item hover effects
        galleryItems.forEach(item => {
            const caption = item.querySelector('.gallery-caption');
            if (!caption) return;

            item.addEventListener('mouseenter', () => {
                caption.style.transform = 'translateY(0)';
            });

            item.addEventListener('mouseleave', () => {
                caption.style.transform = 'translateY(100%)';
            });
        });
    }

    // Animation functionality
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

        document.querySelectorAll('.facility-card, .amenity-item, .service-column').forEach(el => {
            observer.observe(el);
        });
    }
});