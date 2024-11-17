document.addEventListener("DOMContentLoaded", function () {
  // Select all tab links and tab content containers
  const tabLinks = document.querySelectorAll("[data-tab-link]");
  const tabContents = document.querySelectorAll("[data-tab-content]");

  // Utility function to reset all tabs and contents
  function resetTabs() {
    tabLinks.forEach((tab) => tab.classList.remove("w--current")); // [data-tab-link]
    tabContents.forEach((content) => {
      content.classList.remove("w--tab-active", "fade-in");
    });
  }

  // Initialize the first tab as active
  if (tabLinks.length > 0 && tabContents.length > 0) {
    tabLinks[0].classList.add("w--current"); // Activate the first tab link
    tabContents[0].classList.add("w--tab-active", "fade-in"); // Activate the first tab content
  }

  // Add event listeners to tab links
  tabLinks.forEach((tab) => {
    tab.addEventListener("click", function (event) {
      event.preventDefault(); // Prevent default behavior

      // Reset all tabs and contents
      resetTabs();

      // Activate the clicked tab and corresponding content
      const targetTabContent = tab.getAttribute("data-tab-target");
      tab.classList.add("w--current"); // [data-tab-link]

      const contentToShow = document.querySelector(
        `[data-tab-content="${targetTabContent}"]`
      );
      if (contentToShow) {
        contentToShow.classList.add("w--tab-active");

        // Add fade-in animation
        setTimeout(() => {
          contentToShow.classList.add("fade-in");
        }, 50);
      }
    });
  });
});
