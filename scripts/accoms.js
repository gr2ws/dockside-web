document.addEventListener("DOMContentLoaded", function () {
	// Initialize AOS animations for main content only
	const mainContent = document.querySelector("main");
	if (mainContent) {
		AOS.init({
			duration: 1000,
			once: true,
			offset: 100
		});
	}

	// Initialize Bootstrap carousel for accommodations page
	const accomCarousel = document.getElementById("accom-carousel");
	if (accomCarousel) {
		const carousel = new bootstrap.Carousel(accomCarousel, {
			interval: 5000,
			touch: true,
			pause: "hover"
		});

		// Reset animation when slide changes
		accomCarousel.addEventListener("slide.bs.carousel", function () {
			const activeCaption = this.querySelector(
				".carousel-item.active .carousel-caption h5"
			);
			if (activeCaption) {
				activeCaption.style.animation = "none";
				activeCaption.offsetHeight; // Trigger reflow
				activeCaption.style.animation = null;
			}
		});
	}

	// Smooth scroll for room links
	document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
		// Exclude header dropdown links and mobile menu links
		if (!anchor.closest(".header-nav") && !anchor.closest(".mobile-nav")) {
			anchor.addEventListener("click", function (e) {
				e.preventDefault();
				const targetId = this.getAttribute("href");
				if (targetId !== "#" && targetId !== "#mobileAccommodationsCollapse") {
					const targetSection = document.querySelector(targetId);
					if (targetSection) {
						const headerHeight =
							document.querySelector(".header-nav")?.offsetHeight || 80;
						window.scrollTo({
							top: targetSection.offsetTop - headerHeight,
							behavior: "smooth"
						});
					}
				}
			});
		}
	});

	// Lazy loading for images within main content
	const images = mainContent?.querySelectorAll('img[loading="lazy"]');
	if (images && "loading" in HTMLImageElement.prototype) {
		images.forEach((img) => {
			if (img.dataset.src) {
				img.src = img.dataset.src;
			}
		});
	} else if (images && images.length > 0) {
		// Fallback for browsers that don't support lazy loading
		const script = document.createElement("script");
		script.src =
			"https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js";
		document.body.appendChild(script);
	}

	// Intersection Observer for scroll animations
	const observerOptions = {
		threshold: 0.2,
		rootMargin: "0px"
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				entry.target.classList.add("visible");
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	mainContent?.querySelectorAll(".room-section").forEach((section) => {
		observer.observe(section);
	});
});
