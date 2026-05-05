const modal = document.getElementById("doctorModal");
const btnOpen = document.getElementById("btnOpenModal");
const btnClose = document.getElementById("btnCloseModal");
const btnCancel = document.getElementById("btnCancelModal");

btnOpen.addEventListener("click", () => {
    modal.classList.add("active");
});

const closeModal = () => {
    modal.classList.remove("active");
};

btnClose.addEventListener("click", closeModal);
btnCancel.addEventListener("click", closeModal);

modal.addEventListener("click", (e) => {
    if (e.target === modal) {
        closeModal();
    }
});