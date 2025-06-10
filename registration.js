
function checkNome(event) {
    const input = event.currentTarget;
    const container = input.parentNode;
    formStatus[input.name] = input.value.length > 0;
    if (formStatus[input.name]) {
        console.log("rimossa")
        container.classList.remove('error');
    } else {
        console.log("aggiunta")
        container.classList.add('error');
    }
}

function checkCognome(event) {
    const input = event.currentTarget;
    const container = input.parentNode;
    formStatus[input.name] = input.value.length > 0;
    if (formStatus[input.name]) {
        container.classList.remove('error');
    } else {
        container.classList.add('error');
    }
}


//GENDER CHECK
function checkGender(event) {
    const genderInputs = document.querySelectorAll('.gender input');
    let checked = false;
    for (let i = 0; i < genderInputs.length; i++) {
        if (genderInputs[i].checked) {
            checked = true;
            break;
        }
    }
    formStatus.gender = checked;
    const gen = document.querySelector('.gender');
    const container = gen.parentNode;
    if (checked) {
        container.classList.remove('error');
    } else {
        container.classList.add('error');
    }
}


function jsonCheckUsername(json) {  
      
    if (!json) {
        document.querySelector('.username span').textContent = "Errore di rete, riprova";
        document.querySelector('.username').classList.add('error');
        formStatus.username = false;
        return;
    }
    
    formStatus.username = !json.exists;
    if (formStatus.username) {
        document.querySelector('.username').classList.remove('error');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.username').classList.add('error');
    }
}

function jsonCheckEmail(json) {

     
    if (!json) {
        document.querySelector('.email span').textContent = "Errore di rete, riprova";
        document.querySelector('.email').classList.add('error');
        formStatus.username = false;
        return;
    }
   
    formStatus.email = !json.exists
    if (formStatus.email) {
        document.querySelector('.email').classList.remove('error');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('error');
    }
}

function fetchResponse(response) {
    if (!response.ok) return null; 
    return response.json();
}


/*
Verifica che il valore inserito rispetti il pattern:

Solo lettere, numeri e underscore
Lunghezza massima 15 caratteri
*/
function checkUsername(event) {
    const input = document.querySelector('.username input');
    const container = input.parentNode;
    if(!/^[a-zA-Z0-9_]{1,15}$/.test(input.value)) {
        container.querySelector('span').textContent = "Sono ammesse lettere, numeri e underscore. Max. 15";
        container.classList.add('error');
        formStatus.username = false;

    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}



function checkEmail(event) {
    const emailInput = document.querySelector('.email input');
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(emailInput.value).toLowerCase())) {
        document.querySelector('.email span').textContent = "Email non valida";
        document.querySelector('.email').classList.add('error');
        formStatus.email = false;

    } else {
        fetch("check_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
    }
}

function checkPassword(event) {

    const passwordInput = document.querySelector('.password input');
    formStatus.password = passwordInput.value.length >=8 ;

    if (formStatus.password) {
        document.querySelector('.password').classList.remove('error');
    } else {
        document.querySelector('.password').classList.add('error');
    }

}

function checkConfirmPassword(event) {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    const passwordInput = document.querySelector('.password input');
    formStatus.confirmPassword = confirmPasswordInput.value === passwordInput.value;
    

    if (formStatus.confirmPassword) {
        document.querySelector('.confirm_password').classList.remove('error');
    } else {
        document.querySelector('.confirm_password').classList.add('error');
    }
}


function checkSignup(event) {
    
    const checkbox = document.querySelector('.allow input');
    console.log("sono dentro cehcksignup")
    formStatus[checkbox.name] = checkbox.checked;
   
    console.log("VALORI FORMSTATUS:", formStatus);
    console.log("N. CAMPI:", Object.keys(formStatus).length); 
    console.log("CAMPi NON VALIDATI:", Object.entries(formStatus).filter(([k, v]) => v === false));
    if (Object.keys(formStatus).length !== 8 || Object.values(formStatus).includes(false)) {
        console.log("Non ho passato l'if")
        event.preventDefault();
    }
}

const formStatus = {};
document.querySelector('.nome input').addEventListener('blur', checkNome);
document.querySelector('.cognome input').addEventListener('blur', checkCognome);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.querySelector('#form-reg').addEventListener('submit', checkSignup);



const genderInputs = document.querySelectorAll('.gender input');
for (let i = 0; i < genderInputs.length; i++) {
    genderInputs[i].addEventListener('change', checkGender);
}
