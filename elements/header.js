class HeaderElement extends HTMLElement {
	constructor() {
		super();
		// Create a shadow root
		this.attachShadow({ mode: "open" });

		// Initialize the component
		this.render();
	}

	// Called when the element is connected to the DOM
	connectedCallback() {
		this.setupMobileNav();
		this.initializeBootstrapDropdowns();
	}

	// Create and attach the header content
	render() {
		// Create the style element to load the CSS
		const style = document.createElement("link");
		style.setAttribute("rel", "stylesheet");
		style.setAttribute("href", "./styles/header.css");

		// Bootstrap CSS for the header
		const bootstrapCSS = document.createElement("link");
		bootstrapCSS.setAttribute("rel", "stylesheet");
		bootstrapCSS.setAttribute(
			"href",
			"https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css"
		);
		bootstrapCSS.setAttribute(
			"integrity",
			"sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7"
		);
		bootstrapCSS.setAttribute("crossorigin", "anonymous");

		// Bootstrap Icons
		const bootstrapIcons = document.createElement("link");
		bootstrapIcons.setAttribute("rel", "stylesheet");
		bootstrapIcons.setAttribute(
			"href",
			"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
		);

		// Create the header HTML content
		this.shadowRoot.innerHTML = `
      ${style.outerHTML}
      ${bootstrapCSS.outerHTML}
      ${bootstrapIcons.outerHTML}
      
      <!-- Header Navbar -->
      <nav class="header-nav navbar navbar-expand-md shadow-sm">
        <div class="container">
          <button
            type="button"
            class="mobile-menu-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
            id="mobileMenuToggle"
          >
            <i class="bi-list"></i>
          </button>

          <a class="nav-hotel-name" href="#">
            Dockside Hotel
            <sup class="header-c bi-c-circle"></sup>
          </a>

          <div class="collapse navbar-collapse header-menu">
            <ul class="navbar-nav ms-auto">
              <li class="nav-link active">Home</li>
              <li class="nav-item dropdown">
                <a
                  class="nav-link"
                  href="#"
                  id="accommodationsDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-expanded="false"
                >
                  <span
                    >Accommodations
                    <i
                      class="bi-chevron-down d-md-none d-lg-inline d-xl-inline d-xxl-inline"
                    ></i
                  ></span>
                </a>
                <ul
                  class="dropdown-menu dropdown-menu-end rooms-dpd shadow-sm"
                  aria-labelledby="accommodationsDropdown"
                >
                  <li><a class="dropdown-item" href="#">Room 1</a></li>
                  <li><a class="dropdown-item" href="#">Room 2</a></li>
                  <li><a class="dropdown-item" href="#">Room 3</a></li>
                  <li><a class="dropdown-item" href="#">Room 4</a></li>
                </ul>
              </li>
              <li class="nav-link">Facilities</li>
              <li class="nav-link">Events</li>
            </ul>
          </div>

          <div class="dropdown">
            <button
              class="btn user-dpd-toggle"
              type="button"
              id="userDropdown"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              <i class="bi-person-circle"></i>
              <i class="bi-chevron-down"></i>
            </button>

			<div class="dropdown-menu dropdown-menu-end user-dpd" aria-labelledby="userDropdown">
			  <div class="dropdown-header">
                <span class="welcome mb-3 d-block"
                  >Welcome to Dockside Hotel<sup class="header-c">©</sup></span
                >
                <a href="" class="sign-in text-decoration-none">
                  <div class="shadow-sm">Sign In</div>
                </a>

                <a href="" class="join text-decoration-none">
                  <div class="shadow-sm">Join Us</div>
                </a>
              </div>

              <hr class="dropdown-divider" />

              <a href="" class="dropdown-item disabled">Dashboard</a>
              <a href="" class="dropdown-item disabled">Bookings</a>
              <a href="" class="dropdown-item disabled">Booking History</a>
              <a href="" class="dropdown-item disabled">Settings & Preferences</a>
            </div>
          </div>
        </div>
      </nav>

      <!-- Mobile Navigation -->
      <div class="mobile-nav" id="mobileSideMenu">
        <div class="mobile-nav-head">
          <button
            type="button"
            class="mobile-menu-close-btn d-xs-block d-sm-block d-md-none d-lg-none d-xl-none d-xxl-none"
            id="mobileMenuClose"
          >
            <i class="bi-x-lg"></i>
          </button>

          <p class="nav-hotel-name text-center ms-4" href="#">
            Dockside Hotel
            <sup class="header-c bi-c-circle"></sup>
          </p>
        </div>
        <ul class="navbar-nav ms-auto">
          <a href="#" class="pt-3"> <li class="nav-item-1">Home</li></a>
          <hr />
          <li class="nav-item-1">
            <span
              data-bs-toggle="collapse"
              href="#mobileAccommodationsCollapse"
              aria-controls="mobileAccommodationsCollapse"
              >Accommodations
              <i class="bi-chevron-down"></i>
            </span>

            <div class="collapse mob-rooms" id="mobileAccommodationsCollapse">
              <ul class="list-unstyled ps-3">
                <a href="#"><li>Room 1</li></a>
                <a href="#"><li>Room 2</li></a>
                <a href="#"><li>Room 3</li></a>
                <a href="#"><li>Room 4</li></a>
              </ul>
            </div>
          </li>
          <hr />

          <a href="#"> <li class="nav-item-1">Facilities</li></a>
          <hr />

          <a href="#"><li class="nav-item-1">Events</li></a>
          <hr />
        </ul>
        <div class="h-100 align-bottom mt-5 nav-gradient"></div>
      </div>

      <!-- Darkening overlay on opened mobile menu -->
      <div class="menu-overlay" id="menuOverlay"></div>
      <!-- Mobile Navigation End -->
    `;

		// Add script after the DOM is populated
		const bootstrapJS = document.createElement("script");
		bootstrapJS.setAttribute(
			"src",
			"https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
		);
		bootstrapJS.setAttribute(
			"integrity",
			"sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
		);
		bootstrapJS.setAttribute("crossorigin", "anonymous");
		this.shadowRoot.appendChild(bootstrapJS);
	}

	// Initialize Bootstrap dropdowns manually within Shadow DOM
	initializeBootstrapDropdowns() {
		// Wait for Bootstrap to load
		setTimeout(() => {
			const dropdownElementList = this.shadowRoot.querySelectorAll(
				'[data-bs-toggle="dropdown"]'
			);

			dropdownElementList.forEach((element) => {
				// Create manual dropdown toggle functionality
				element.addEventListener("click", (e) => {
					e.preventDefault();
					e.stopPropagation();

					// Get target dropdown menu
					const dropdownId = element.getAttribute("id");
					const dropdownMenu = this.shadowRoot.querySelector(
						`[aria-labelledby="${dropdownId}"]`
					);

					if (!dropdownMenu) return;

					// Toggle dropdown
					const isExpanded = element.getAttribute("aria-expanded") === "true";

					// Close any other open dropdowns
					const allDropdowns = this.shadowRoot.querySelectorAll(
						".dropdown-menu.show"
					);
					allDropdowns.forEach((menu) => {
						if (menu !== dropdownMenu) {
							menu.classList.remove("show");
							const trigger = this.shadowRoot.querySelector(
								`[aria-expanded="true"]`
							);
							if (trigger) trigger.setAttribute("aria-expanded", "false");
						}
					});

					// Toggle current dropdown
					if (isExpanded) {
						dropdownMenu.classList.remove("show");
						element.setAttribute("aria-expanded", "false");
					} else {
						dropdownMenu.classList.add("show");
						element.setAttribute("aria-expanded", "true");

						// Handle positioning for dropdown-menu-end
						if (dropdownMenu.classList.contains("dropdown-menu-end")) {
							// Ensure it's positioned correctly
							const rect = element.getBoundingClientRect();
							const parentRect = element.parentElement.getBoundingClientRect();

							// Calculate right edge position
							const rightEdge = window.innerWidth - rect.right;

							// Apply position if needed
							if (rightEdge < dropdownMenu.offsetWidth) {
								dropdownMenu.style.right = "0";
								dropdownMenu.style.left = "auto";
							}
						}
					}
				});
			});

			// Close dropdowns when clicking outside
			document.addEventListener("click", () => {
				const openDropdowns = this.shadowRoot.querySelectorAll(
					".dropdown-menu.show"
				);
				openDropdowns.forEach((menu) => {
					menu.classList.remove("show");
					const trigger = this.shadowRoot.querySelector(
						`[aria-expanded="true"]`
					);
					if (trigger) trigger.setAttribute("aria-expanded", "false");
				});
			});

			// Prevent dropdown closing when clicking inside the dropdown
			const dropdownMenus = this.shadowRoot.querySelectorAll(".dropdown-menu");
			dropdownMenus.forEach((menu) => {
				menu.addEventListener("click", (e) => {
					e.stopPropagation();
				});
			});
		}, 500);
	}

	// Set up mobile navigation functionality
	setupMobileNav() {
		// Get elements from the shadow DOM
		const openMenuBtn = this.shadowRoot.querySelector(".mobile-menu-btn");
		const closeMenuBtn = this.shadowRoot.querySelector(
			".mobile-menu-close-btn"
		);
		const mobileNav = this.shadowRoot.querySelector(".mobile-nav");
		const menuOverlay = this.shadowRoot.querySelector(".menu-overlay");

		// Add event listeners
		openMenuBtn.addEventListener("click", () => {
			mobileNav.classList.add("show");
			menuOverlay.classList.add("show");
		});

		closeMenuBtn.addEventListener("click", () => {
			mobileNav.classList.remove("show");
			menuOverlay.classList.remove("show");
		});

		menuOverlay.addEventListener("click", () => {
			mobileNav.classList.remove("show");
			menuOverlay.classList.remove("show");
		});

		// Setup mobile collapse functionality
		const collapseToggle = this.shadowRoot.querySelector(
			'[data-bs-toggle="collapse"]'
		);
		collapseToggle.addEventListener("click", () => {
			const target = this.shadowRoot.querySelector(
				collapseToggle.getAttribute("href")
			);
			if (target) {
				target.classList.toggle("show");
			}
		});
	}
}

// Define the custom element
customElements.define("header-element", HeaderElement);
