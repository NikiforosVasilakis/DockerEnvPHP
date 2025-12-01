"use strict";

(function () {
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("deleteModal");
        const deleteMessage = document.getElementById("deleteMessage");
        const confirmDelete = document.getElementById("confirmDelete");
        const cancelDelete = document.getElementById("cancelDelete");
        const loadingOverlay = document.getElementById("loadingOverlay");

        let deleteId = null;
        let csrfToken = null;

        /**
         * Show the modal with the appropriate message.
         * @param {string} name - The user's first name or username.
         * @param {string} surname - The user's last name, if available.
         */
        function showModal(name, surname) {
            deleteMessage.textContent = `Are you sure you want to delete ${name} ${surname ? surname : ""}?`;
            modal.style.display = "block";
        }

        /**
         * Hide the modal.
         */
        function hideModal() {
            modal.style.display = "none";
        }

        /**
         * Show the loading overlay.
         */
        function showLoading() {
            if (loadingOverlay) {
                loadingOverlay.style.display = "flex"; // Show overlay when needed
            }
        }

        /**
         * Hide the loading overlay.
         */
        function hideLoading() {
            if (loadingOverlay) {
                loadingOverlay.style.display = "none"; // Ensure it's hidden initially
            }
        }

        // Ensure the overlay is hidden when the page loads
        hideLoading();

        // Add event listeners to all delete buttons
        document.querySelectorAll(".delete-btn").forEach((button) => {
            button.addEventListener("click", () => {
                deleteId = button.getAttribute("data-id");
                csrfToken = button.getAttribute("data-csrf");
                const name = button.getAttribute("data-name");
                const surname = button.getAttribute("data-surname");

                if (deleteId && csrfToken) {
                    showModal(name, surname);
                } else {
                    console.error("Delete button missing data-id or data-csrf");
                }
            });
        });

        // Handle confirmation of deletion
        confirmDelete.addEventListener("click", () => {
            if (deleteId && csrfToken) {
                hideModal();
                showLoading();
                window.location.href = `delete_user.php?id=${deleteId}&csrf_token=${csrfToken}`;
            }
        });

        // Handle cancellation of deletion
        cancelDelete.addEventListener("click", hideModal);

        // Close modal when clicking outside of it
        window.addEventListener("click", (event) => {
            if (event.target === modal) {
                hideModal();
            }
        });
    });
})();
