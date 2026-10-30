const appView = document.getElementById("app-view");
const viewCache = new Map();
const viewNames = new Set([
    "home",
    "shop",
    "kit-details",
    "cart",
    "checkout",
    "matchday",
    "login",
    "register",
    "account",
    "admin"
]);
const kits = {
    "man-city": { name: "Manchester City", price: "€84", image: "assets/images/man-city-home.png" },
    arsenal: { name: "Arsenal", price: "€84", image: "assets/images/arsenal-home.png" },
    chelsea: { name: "Chelsea", price: "€84", image: "assets/images/chelsea-home.jpg" },
    brighton: { name: "Brighton", price: "€84", image: "assets/images/brighton-home.jpg" },
    liverpool: { name: "Liverpool", price: "€84", image: "assets/images/liverpool-home.png" },
    leeds: { name: "Leeds United", price: "€84", image: "assets/images/leeds-home.jpg" },
    newcastle: { name: "Newcastle United", price: "€84", image: "assets/images/newcastle-home.png" },
    "manchester-united": { name: "Manchester United", price: "€84", image: "assets/images/manchester-united-home.png" },
    "aston-villa": { name: "Aston Villa", price: "€84", image: "assets/images/aston-villa-home.jpg" },
    bournemouth: { name: "AFC Bournemouth", price: "€84", image: "assets/images/bournemouth-home.png" },
    brentford: { name: "Brentford", price: "€84", image: "assets/images/brentford-home.jpg" },
    coventry: { name: "Coventry City", price: "€84", image: "assets/images/coventry-home.jpg" },
    "crystal-palace": { name: "Crystal Palace", price: "€84", image: "assets/images/crystal-palace-home.jpg" },
    everton: { name: "Everton", price: "€84", image: "assets/images/everton-home.jpg" },
    fulham: { name: "Fulham", price: "€84", image: "assets/images/fulham-home.jpg" },
    "hull-city": { name: "Hull City", price: "€84", image: "assets/images/hull-city-home.jpg" },
    ipswich: { name: "Ipswich Town", price: "€84", image: "assets/images/ipswich-home.jpg" },
    "nottingham-forest": { name: "Nottingham Forest", price: "€84", image: "assets/images/nottingham-forest-home-white-bg.jpg" },
    sunderland: { name: "Sunderland", price: "€84", image: "assets/images/sunderland-home-front.jpg" },
    tottenham: { name: "Tottenham Hotspur", price: "€84", image: "assets/images/tottenham-home.png" },
    burnley: { name: "Burnley", price: "€84", image: "assets/images/burnley-home.jpg" },
    "west-ham": { name: "West Ham United", price: "€84", image: "assets/images/west-ham-home.webp" },
    wolves: { name: "Wolverhampton Wanderers", price: "€84", image: "assets/images/wolves-home.jpg" }
};

function renderShopCatalogue() {
    const catalogue = appView.querySelector("#kit-catalogue");
    const count = appView.querySelector("[data-kit-count]");

    if (!catalogue) {
        return;
    }

    catalogue.innerHTML = Object.entries(kits).map(([slug, kit], index) => {
        const number = String(index + 1).padStart(2, "0");
        const clubName = kit.name.toUpperCase();

        return `<article class="product-card"><a href="#kit-details/${slug}" data-view="kit-details" data-kit="${slug}" class="product-art has-product-image" aria-label="View ${kit.name} home kit"><span class="product-tag">HOME SHIRT</span><img class="product-kit-image" src="${kit.image}" alt="${kit.name} home shirt"><span class="art-index">${number}</span></a><div class="product-info"><div><p class="product-club">${clubName}</p><h2>Home Shirt</h2></div><span class="product-price">${kit.price}</span></div><div class="product-card-bottom"><span>Sizes XS–XXL</span><a href="#kit-details/${slug}" data-view="kit-details" data-kit="${slug}" aria-label="View ${kit.name} home shirt">View kit ↗</a></div></article>`;
    }).join("");

    if (count) {
        count.textContent = `${String(Object.keys(kits).length).padStart(2, "0")} HOME KITS`;
    }
}

function getCurrentView() {
    const requestedView = window.location.hash.slice(1).toLowerCase().split("/")[0];
    return viewNames.has(requestedView) ? requestedView : "home";
}

function getCurrentKit() {
    return window.location.hash.slice(1).toLowerCase().split("/")[1];
}

function updateKitDetails() {
    const kit = kits[getCurrentKit()] || kits["man-city"];
    const image = appView.querySelector("[data-kit-image]");

    appView.querySelectorAll("[data-kit-name]").forEach((item) => {
        item.textContent = kit.name;
    });
    appView.querySelectorAll("[data-kit-club]").forEach((item) => {
        item.textContent = kit.name.toUpperCase();
    });
    appView.querySelectorAll("[data-kit-price]").forEach((item) => {
        item.textContent = kit.price;
    });
    appView.querySelectorAll("[data-kit-button-price]").forEach((item) => {
        item.textContent = kit.price;
    });

    if (image) {
        image.src = kit.image;
        image.alt = `${kit.name} home shirt`;
        image.classList.toggle("is-wide-kit", getCurrentKit() === "aston-villa");
    }
}

function updateNavigation(activeView) {
    document.querySelectorAll("[data-view]").forEach((link) => {
        if (link.matches(".nav-link")) {
            link.classList.toggle("active", link.dataset.view === activeView);
            if (link.dataset.view === activeView) {
                link.setAttribute("aria-current", "page");
            } else {
                link.removeAttribute("aria-current");
            }
        }
    });

    const menu = document.getElementById("primaryNavigation");
    if (menu?.classList.contains("show") && window.bootstrap) {
        window.bootstrap.Collapse.getOrCreateInstance(menu).hide();
    }
}

async function loadView(viewName) {
    appView.setAttribute("aria-busy", "true");
    updateNavigation(viewName);

    try {
        let viewContent = viewCache.get(viewName);

        if (!viewContent) {
            const response = await fetch(`views/${viewName}.html`);
            if (!response.ok) {
                throw new Error(`The ${viewName} view could not be loaded.`);
            }
            viewContent = await response.text();
            viewCache.set(viewName, viewContent);
        }

        appView.innerHTML = viewContent;
        if (viewName === "shop") {
            renderShopCatalogue();
        }
        if (viewName === "kit-details") {
            updateKitDetails();
        }
        appView.setAttribute("aria-busy", "false");
        appView.focus({ preventScroll: true });
        const kit = kits[getCurrentKit()];
        const pageName = viewName === "kit-details" && kit ? `${kit.name} Home Shirt` : viewName.replaceAll("-", " ").replace(/\b\w/g, (letter) => letter.toUpperCase());
        document.title = `${pageName} | GrbZem`;
        window.scrollTo({ top: 0, behavior: "smooth" });
    } catch {
        appView.innerHTML = '<section class="container-xl page-content load-error"><p class="eyebrow eyebrow-dark"><span class="eyebrow-line"></span> VIEW UNAVAILABLE</p><h1>We lost the<br><em>way through.</em></h1><p>Refresh the page and try again.</p><a class="button button-dark" href="#home" data-view="home">Return home <span>↗</span></a></section>';
        appView.setAttribute("aria-busy", "false");
    }
}

document.addEventListener("click", (event) => {
    const viewLink = event.target.closest("[data-view]");
    if (!viewLink) {
        return;
    }

    const requestedView = viewLink.dataset.view;
    if (!viewNames.has(requestedView)) {
        return;
    }

    event.preventDefault();
    const destination = viewLink.dataset.kit ? `${requestedView}/${viewLink.dataset.kit}` : requestedView;
    if (window.location.hash === `#${destination}`) {
        loadView(requestedView);
    } else {
        window.location.hash = destination;
    }
});

window.addEventListener("hashchange", () => {
    loadView(getCurrentView());
});

document.addEventListener("submit", (event) => {
    if (!event.target.matches(".prototype-form")) {
        return;
    }

    event.preventDefault();
    const message = document.createElement("p");
    message.className = "form-submit-message";
    message.setAttribute("role", "status");
    message.textContent = "This form is a static preview and is not connected yet.";
    event.target.querySelector(".form-submit-message")?.remove();
    event.target.append(message);
});

loadView(getCurrentView());
