// RightPad
const rightPad = document.getElementById('rightpad');

// DARK MODE TOGGLE BUTTON
var themeToggleDarkIcon = document.getElementById("theme-toggle-dark-icon");
var themeToggleLightIcon = document.getElementById("theme-toggle-light-icon");
var themeToggleBtn = document.getElementById("theme-toggle");

if (themeToggleBtn) {

    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        themeToggleLightIcon.classList.remove("hidden");
    } else {
        themeToggleDarkIcon.classList.remove("hidden");
    }

    themeToggleBtn.addEventListener("click", function () {
        themeToggleDarkIcon.classList.toggle("hidden");
        themeToggleLightIcon.classList.toggle("hidden");

        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }
    });

}

function closeRightPad() {
    document.getElementById('rightpad').classList.remove('open');
}

window.closeRightPad = closeRightPad;

/**
 * Mostra o div lateral nos GRIDs
 * @param data
 */
window.showLeft = async function (data) {

    try {

        const response = await fetch(data.route, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error(`Erro ${response.status}`);
        }

        const html = await response.text();

        rightPad.innerHTML = html;

        requestAnimationFrame(() => {
            rightPad.classList.add('open');
        });

    } catch (e) {
        console.error(e);
    }

}


document.addEventListener('click', (event) => {

    // Se o painel estiver fechado, não faz nada
    if (!rightPad.classList.contains('open')) {
        return;
    }

    // Se clicou dentro do painel, não fecha
    if (rightPad.contains(event.target)) {
        return;
    }

    // Fecha o painel
    closeRightPad();

});

document.addEventListener('keydown', (event) => {

    if (event.key === 'Escape') {
        closeRightPad();
    }

});

// Impede que cliques dentro do painel propaguem para o document
rightPad.addEventListener('click', (event) => {
    event.stopPropagation();
});

