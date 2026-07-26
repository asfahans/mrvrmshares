let currentFontSize = 16;

function changeFont(sizeChange) {
    currentFontSize += sizeChange;
    document.getElementById("main-content").style.fontSize = currentFontSize + "px";
}

function resetFont() {
    currentFontSize = 16;
    document.getElementById("main-content").style.fontSize = "16px";
}

function changeTheme(bgColor, textColor) {
    const content = document.getElementById("main-content");
    content.style.backgroundColor = bgColor;
    content.style.color = textColor;

    // Force all child elements to inherit color
    content.querySelectorAll("*").forEach(el => {
    if (!el.closest("#t01") && !el.closest(".inner-banner") && !el.closest(".no-theme")) {
        el.style.color = textColor;
    }
});
}