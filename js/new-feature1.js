let currentFontSize = 16;

function changeFont(sizeChange) {
    currentFontSize += sizeChange;

    const content = document.getElementById("main-content");

    content.style.fontSize = currentFontSize + "px";

    // Force font size on all children
    content.querySelectorAll("*").forEach(el => {
        if (
            !el.closest("#t01") &&
            !el.closest(".inner-banner") &&
            !el.closest(".no-theme")
        ) {
            el.style.fontSize = currentFontSize + "px";
        }
    });
}

function resetFont() {
    currentFontSize = 16;

    const content = document.getElementById("main-content");

    content.style.fontSize = "16px";

    content.querySelectorAll("*").forEach(el => {
        el.style.fontSize = "";
    });
}

function changeTheme(bgColor, textColor) {

    const content = document.getElementById("main-content");

    content.style.backgroundColor = bgColor;

    content.querySelectorAll("*").forEach(el => {

        if (
            !el.closest("#t01") &&
            !el.closest(".inner-banner") &&
            !el.closest(".banner-section") &&
            !el.closest(".header-top") &&
            !el.closest(".no-theme")
        ) {

            el.style.color = textColor;
            el.style.backgroundColor = bgColor;
        }
    });

    // Keep toolbar text always black
    document.querySelectorAll('.toolbar, .toolbar a').forEach(el => {
        el.style.color = '#000';
    });
}