
const inputemail = document.querySelector(".email input");
const inputpassword = document.querySelector(".password input");
const form = document.querySelector("#form-login");

function validazione(event){

    if(inputemail.value.length == 0){
        const container = inputemail.parentNode;
        container.classList.add("error");
        event.preventDefault();
    }
     else {
    const container = inputemail.parentNode;
    container.classList.remove("error");
    }
    
    if(inputpassword.value.length == 0){
        const container = inputpassword.parentNode;
        container.classList.add("error");
        event.preventDefault();
    }
     else {
    const container = inputpassword.parentNode;
    container.classList.remove("error");
    }
    

}

form.addEventListener("submit", validazione);

