const addPatientBtn = document.getElementById("addPatientBtn");
const modalOverlay = document.getElementById("modalOverlay");
const closeModalIcon = document.getElementById("closeModalIcon");
const cancelModalBtn = document.getElementById("cancelModalBtn");
const createPatientBtn = document.getElementById("createPatientBtn");

// Add function to toggle modal
function toggleModal() {
    modalOverlay.classList.toggle("hidden");
}

// Event listeners
addPatientBtn.addEventListener("click", toggleModal);
closeModalIcon.addEventListener("click", toggleModal);
cancelModalBtn.addEventListener("click", toggleModal);
createPatientBtn.addEventListener("click", toggleModal); // Just close for demonstration

// Close modal if clicking outside the card
modalOverlay.addEventListener("click", (event) => {
    if (event.target === modalOverlay) {
        toggleModal();
    }
});