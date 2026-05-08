document.getElementById("kapcsolatForm").addEventListener("submit", function(e) {
    let hibak = [];

    let nev = document.getElementById("nev").value.trim();
    let email = document.getElementById("email").value.trim();
    let targy = document.getElementById("targy").value.trim();
    let uzenet = document.getElementById("uzenet").value.trim();

    if (nev === "") hibak.push("Név kötelező!");
    if (email === "" || !email.includes("@")) hibak.push("Hibás email!");
    if (targy === "") hibak.push("Tárgy kötelező!");
    if (uzenet.length < 10) hibak.push("Üzenet legalább 10 karakter!");

    if (hibak.length > 0) {
        e.preventDefault();
        document.getElementById("hibak").innerHTML = hibak.join("<br>");
    }
});