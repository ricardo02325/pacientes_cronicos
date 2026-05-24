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

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.querySelector(".search-bar input");

    if (searchInput) {
        searchInput.addEventListener("input", (e) => {
            const searchTerm = e.target.value.toLowerCase();

            // TARJETAS DE MÉDICOS
            const cards = document.querySelectorAll(".doctor-card");

            cards.forEach((card) => {
                const nombre =
                    card
                        .querySelector(".doctor-name")
                        ?.textContent.toLowerCase() || "";

                const especialidad =
                    card
                        .querySelector(".doctor-specialty")
                        ?.textContent.toLowerCase() || "";

                const coincide =
                    nombre.includes(searchTerm) ||
                    especialidad.includes(searchTerm);

                card.style.display = coincide ? "" : "none";
            });
        });
    }
});