window.onbeforeunload = function () {
    window.scrollTo(0, 0);
}

function bookRedirect() {
    location.href='./views/book-page'
}

var swiper = new Swiper(".mySwiper", {
    slidesPerView: 5,
    spaceBetween: 20,
    freeMode: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        hide: true,
    },
});

function pieslegties() { 
	document.getElementById("registracija").style.display="none"; 
	document.getElementById("pieslegties").style.display="block"; 
}

function registreties() { 
	document.getElementById("registracija").style.display="block";
    document.getElementById("mainit_paroli").style.display="none"; 
	document.getElementById("pieslegties").style.display="none"; 
}

function atjaunot_paroli() { 
	document.getElementById("pieslegties").style.display="none"; 
	document.getElementById("atjaunot_paroli").style.display="block"; 
}

function mainit_paroli() { 
	document.getElementById("atjaunot_paroli").style.display="none"; 
	document.getElementById("mainit_paroli").style.display="block"; 
}

function books() {
    document.getElementById("books").style.display="block";
    document.getElementById("add-button").style.display="block";
    document.getElementById("users").style.display="none";
}

function users() {
    document.getElementById("users").style.display="block";
    document.getElementById("add-button").style.display="none";
    document.getElementById("books").style.display="none";
}

function addBook() {
    var popup = document.getElementById("addPopup");
    popup.style.display="block";
}

function closePopup() {
    var popup = document.getElementById("addPopup");
    popup.style.display="none";
}

function editBook() {
    var popup = document.getElementById("editPopup");
    popup.style.display="block";
}

function closePopup() {
    var popup = document.getElementById("editPopup");
    popup.style.display="none";
}

function hide() {
    var div = document.getElementById('access-wrapper');
    div.style.display = 'none';
}