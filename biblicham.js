document.addEventListener("DOMContentLoaded", function() {
    const books = document.querySelectorAll(".book");

    books.forEach(book => {
        let isClicked = false;

        book.addEventListener("mouseenter", () => {
            if (!isClicked) {
                book.querySelector(".summary").style.opacity = "0";
            }
        });

        book.addEventListener("mouseleave", () => {
            if (!isClicked) {
                book.querySelector(".summary").style.opacity = "0";
            }
        });

        book.addEventListener("click", () => {
            isClicked = !isClicked;

            // Masquer tous les résumés
            books.forEach(b => {
                b.querySelector(".summary").style.opacity = "0";
            });

            // Afficher ou masquer le résumé du livre cliqué
            const summary = book.querySelector(".summary");
            if (summary) {
                summary.style.opacity = isClicked ? "1" : "0";
            }
        });
    });
});

function toggleDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Fermer le menu déroulant si l'utilisateur clique en dehors
window.onclick = function(event) {
    if (!event.target.matches('.dropdown button')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}

// Fonction pour valider le formulaire et mettre à jour le tri des livres
function validerFormulaire() {
    var tri = document.getElementById("choix").value; // Récupérer la valeur de l'option de tri sélectionnée
    var saisie = document.getElementById("saisie").value; // Récupérer le texte saisi dans le champ de recherche

    // Construire l'URL avec les paramètres de tri et de recherche
    var url = "biblicham.php?tri=" + tri + "&saisie=" + encodeURIComponent(saisie);

    // Rediriger vers la nouvelle URL avec les paramètres de tri et de recherche
    window.location.href = url;
}

// Ajouter un écouteur d'événement pour détecter le changement d'option dans le menu déroulant de tri
document.getElementById("choix").addEventListener("change", validerFormulaire);

// Ajouter un écouteur d'événement pour soumettre le formulaire lorsque l'utilisateur appuie sur Entrée dans le champ de recherche
document.getElementById("saisie").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        validerFormulaire(); // Appeler validerFormulaire() lorsque l'utilisateur appuie sur Entrée
    }
});

// // Vérifier si l'utilisateur est connecté en tant qu'administrateur
// const isAdmin = "Admin"/* logique pour vérifier si l'utilisateur est administrateur */;

// // Lien vers la page d'administration si l'utilisateur est administrateur
// const compteLink = document.getElementById('compteLink');
// if (isAdmin) {
//     compteLink.href = 'admin_dashboard.php';
// }


// function openAdminWindow() {
//     // URL de la page de connexion administrateur
//     var adminUrl = "admin_login.php";

//     // Ouvrir une nouvelle fenêtre avec la page de connexion administrateur
//     var adminWindow = window.open(adminUrl, "_blank", "width=600,height=400");

//     // Focus sur la nouvelle fenêtre (au cas où elle serait bloquée par le navigateur)
//     if (adminWindow) {
//         adminWindow.focus();
//     } else {
//         alert("La fenêtre pop-up a été bloquée par votre navigateur. Veuillez autoriser les pop-ups pour accéder à la page d'administration.");
//     }
// }
