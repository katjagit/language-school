'use strict';

function createHTML(e) {

    e.preventDefault();
    
    var div = document.getElementById('newsletter');

    while (div.lastChild) {
        div.lastChild.remove();
    }

    var p = document.createElement('p');
    p.textContent = 'Vielen Dank fürs Abbonieren. In Kürze erhalten Sie eine Bestätigunsemail.'
    div.appendChild(p);

}

function checkForm(e) {
    e.preventDefault();
    var email = document.getElementById('email');
    var errorLabel = document.getElementsByClassName('error');
    while (errorLabel.length) {
        errorLabel[0].parentNode.removeChild(errorLabel[0]);
    }
    var error = createEl('label');
    error.classList.add('error');
    email.parentNode.insertBefore(error, email);
    error.textContent = '';
    if (email.value === '') {
        error.textContent = 'Das feld darf nicht leer bleiben';
        return false;
        
    } else {
        if (/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email.value)){
            createHTML(e);
        } else {
            error.textContent ='Die Email muss valide sein';
            return false;
        }
    } 
}

function bindHandler() {
    var form = document.getElementById('newsletter-form');
    
    form.addEventListener('submit', checkForm);
}

bindHandler();