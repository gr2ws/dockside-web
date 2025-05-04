document.addEventListener("DOMContentLoaded", function () {
	const mobileMenuToggle = document.getElementById("mobileMenuToggle");
	const mobileSideMenu = document.getElementById("mobileSideMenu");
	const menuOverlay = document.getElementById("menuOverlay");

	// Toggle mobile menu
	mobileMenuToggle.addEventListener("click", function () {
		mobileSideMenu.classList.toggle("show");
		menuOverlay.classList.toggle("show");

		// Change hamburger icon to X when menu is open
		const menuIcon = mobileMenuToggle.querySelector("i");
		if (mobileSideMenu.classList.contains("show")) {
			menuIcon.classList.remove("bi-list");
			menuIcon.classList.add("bi-x-lg");
		} else {
			menuIcon.classList.remove("bi-x-lg");
			menuIcon.classList.add("bi-list");
		}
	});

	// Close menu when clicking on overlay
	menuOverlay.addEventListener("click", function () {
		mobileSideMenu.classList.remove("show");
		menuOverlay.classList.remove("show");

		// Reset menu icon
		const menuIcon = mobileMenuToggle.querySelector("i");
		menuIcon.classList.remove("bi-x-lg");
		menuIcon.classList.add("bi-list");
	});
});
