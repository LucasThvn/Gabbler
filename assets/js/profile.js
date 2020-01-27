window.profile = function profile(id) {
    let profile = document.getElementById(id);
    console.log(profile.style.display);
    if (profile.style.display === "flex") {
        profile.style.display = "none";
    } else {
        profile.style.display = "flex";
    }
}