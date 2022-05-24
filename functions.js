// Fonction pour prévisualiser l'image uploadée

function previewImage(input) {

    if (input.files && input.files[0]) {
        let fileReader = new FileReader();
        fileReader.onload = function (e) {
            document.getElementById('previewUploadImage').setAttribute('src', e.target.result);
        };

        fileReader.readAsDataURL(input.files[0]);
    }
}

// Fonctions pour prévisualiser le PDF uploadé

function displayLoadedLink() {
    let link = document.getElementById("uploadLink");
    link.addEventListener('change', function () {
        previewLink(this);
    });
}

function previewLink(input) {
    if (input.files && input.files[0]) {
        let fileReader = new FileReader();
        fileReader.onload = function (e) {
            document.getElementById('previewUploadLink').setAttribute('src', e.target.result);
        };

        fileReader.readAsDataURL(input.files[0]);
    }
}

// Fonction pour afficher ou cacher l'image stockée dans la DB

function toggleImageButton() {
    let btn = document.getElementById("toggleImageBtn");
    let image = document.getElementById("display-image");

    if (btn.innerHTML === "Voir l'ancienne image"){
        btn.innerHTML = "Cacher l'ancienne image";
        image.style.display='block';

    } else if (btn.innerHTML === "Cacher l'ancienne image"){
        btn.innerHTML = "Voir l'ancienne image";
        image.style.display='none';
    }
}

// Fonction pour afficher ou cacher le PDF stocké dans la DB

function toggleLinkButton() {
    let btn = document.getElementById("toggleLinkBtn");
    let image = document.getElementById("display-link");

    if (btn.innerHTML === "Voir l'ancien PDF"){
        btn.innerHTML = "Cacher l'ancien PDF";
        image.style.display='block';

    } else if (btn.innerHTML === "Cacher l'ancien PDF"){
        btn.innerHTML = "Voir l'ancien PDF";
        image.style.display='none';
    }
}