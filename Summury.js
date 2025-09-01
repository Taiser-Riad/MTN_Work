const openBtn = document.getElementById("openModal");
const openBtn = document.getElementById("closeModal");
const openBtn = document.getElementById("Modal");

openBtn.addEventListener("click",() =>{
    modal.classList.add("open");
});

openBtn.addEventListener("click",() =>{
    modal.classList.remove("open");
});