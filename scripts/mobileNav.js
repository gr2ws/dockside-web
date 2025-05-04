document.addEventListener("DOMContentLoaded", () => {
	const openMenuBtn = document.querySelector(".mobile-menu-btn");
	const closeMenuBtn = document.querySelector(".mobile-menu-close-btn");
	const mobileNav = document.querySelector(".mobile-nav");
	const menuOverlay = document.querySelector(".menu-overlay");

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
});
