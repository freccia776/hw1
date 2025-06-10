//FOOTER


function showInfo(event){

    console.log("sto cliccando");
    const btn = event.currentTarget;
    const idtarget = "#" + btn.dataset.target;
    console.log(idtarget);
    const info = document.querySelector(idtarget);
    
    if(info.classList.contains("smarthidden")){
        
        btn.textContent = "-";
        info.classList.remove("smarthidden");

    }
    else {
    
        btn.textContent = "+";
        info.classList.add("smarthidden");
    }

 
}


//PER OGNI BOTTONE DEL FOOTER
const footerbtns = document.querySelectorAll(".title-info button");
for (const btn of footerbtns) {
    btn.addEventListener("click", showInfo); 
}

