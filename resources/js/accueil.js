document.addEventListener("DOMContentLoaded", function () {
    // Toggle sidebar on mobile
    const mobileToggle = document.getElementById("mobile-toggle");
    const headerToggle = document.getElementById("header-toggle");
    const sidebar = document.querySelector(".sidebar");

    function toggleSidebar() {
        sidebar.classList.toggle("active");
        // Change icon based on state
        const icons = [
            mobileToggle.querySelector("i"),
            headerToggle.querySelector("i"),
        ];
        icons.forEach((icon) => {
            if (sidebar.classList.contains("active")) {
                icon.classList.remove("fa-bars");
                icon.classList.add("fa-times");
            } else {
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
            }
        });
    }

    mobileToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleSidebar();
    });

    headerToggle.addEventListener("click", (e) => {
        e.stopPropagation();
        toggleSidebar();
    });

    // Close sidebar when clicking outside
    document.addEventListener("click", (e) => {
        if (
            !sidebar.contains(e.target) &&
            !mobileToggle.contains(e.target) &&
            !headerToggle.contains(e.target)
        ) {
            sidebar.classList.remove("active");
            const icons = document.querySelectorAll(
                "#mobile-toggle i, #header-toggle i"
            );
            icons.forEach((icon) => {
                icon.classList.remove("fa-times");
                icon.classList.add("fa-bars");
            });
        }
    });

    // Navigation entre les pages
    const navItems = document.querySelectorAll(".nav-item");
    const pages = {
        accueil: "accueil-page",
        calendrier: "calendrier-page",
        notes: "notes-page",
        demandes: "demandes-page",
        absences: "absences-page",
        stage: "stage-page",
        aide: "aide-page",
    };

    navItems.forEach((item) => {
        // item.addEventListener("click", function (e) {
        //     // Retirer la classe active de tous les éléments
        //     navItems.forEach((navItem) => {
        //         navItem.classList.remove("active");
        //     });
        // Ajouter la classe active à l'élément cliqué
        // this.classList.add("active");
        // Masquer toutes les pages
        // Object.values(pages).forEach((pageId) => {
        //     document.getElementById(pageId).classList.add("hidden");
        // });
        // Afficher la page correspondante
        // const page = this.getAttribute("data-page");
        // document.getElementById(pages[page]).classList.remove("hidden");
        // Mettre à jour le titre du header
        // const headerTitle = document.querySelector(".header-title");
        // headerTitle.textContent = this.querySelector("span").textContent;
    });
    // });

    // Gestion du formulaire
    // const form = document.getElementById("document-request-form");
    // form.addEventListener("submit", function (e) {
    //     e.preventDefault();
    //     alert("Votre demande a été soumise avec succès!");
    //     form.reset();
    // });

    // Gestion du formulaire d'absence
    // const absenceForm = document.getElementById("absence-justification-form");
    // absenceForm.addEventListener("submit", function (e) {
    //     e.preventDefault();
    //     alert("Votre justification d'absence a été soumise avec succès!");
    //     absenceForm.reset();
    // });
});
