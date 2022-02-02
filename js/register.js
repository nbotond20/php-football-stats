const togglePassword1 = document.querySelector('#togglePassword1');
const togglePassword2 = document.querySelector('#togglePassword2');
const password1 = document.querySelector('#pass1');
const password2 = document.querySelector('#pass2');
const strength1 = document.querySelector('.strength1');
const strength2 = document.querySelector('.strength2');

togglePassword1.addEventListener('click', function (e) {
    const type1 = password1.getAttribute('type') === 'password' ? 'text' : 'password';
    password1.setAttribute('type', type1);
    e.target.classList.toggle('bi-eye');
});

togglePassword2.addEventListener('click', function (e) {
    const type2 = password2.getAttribute('type') === 'password' ? 'text' : 'password';
    password2.setAttribute('type', type2);
    e.target.classList.toggle('bi-eye');
});


/* STENGTH VALIDATION */
let alphabet = /[a-zA-Z]/, 
    numbers = /[0-9]/, 
    scharacters = /[!,@,#,$,%,^,&,*,?,_,(,),-,+,=,~]/; 


let good1 = false
password1.addEventListener("input", () => {
    let val = password1.value;
    if (val.match(alphabet) || val.match(numbers) || val.match(scharacters)) {
        password1.style.borderColor = "#FF6333";
        togglePassword1.style.color = "#FF6333";
        strength1.innerText = "Weak";
        strength1.style.color = "#FF6333";
        good1 = false;
    }
    if (val.match(alphabet) && val.match(numbers) && val.length >= 6) {
        password1.style.borderColor = "orange";
        togglePassword1.style.color = "orange";
        strength1.innerText = "Medium";
        strength1.style.color = "orange";
        good1 = false;
    }
    if (
        val.match(alphabet) &&
        val.match(numbers) &&
        val.match(scharacters) &&
        val.length >= 8
    ) {
        password1.style.borderColor = "#22C32A";
        togglePassword1.style.color = "#22C32A";
        strength1.innerText = "Strong";
        strength1.style.color = "#22C32A";
        good1 = true;
    }

    if (val == "") {
        password1.style.border = "2px solid rgba(0, 0, 0, 0.18)";
        togglePassword1.style.color = "#A6A6A6";
        strength1.innerText = "";
        strength1.style.color = "#A6A6A6";
        good1 = false;
    }
});

password1.addEventListener("blur", () => {
    password1.style.border = "2px solid rgba(0, 0, 0, 0.02)";
    togglePassword1.style.color = "#A6A6A6";
    strength1.innerText = "";
    strength1.style.color = "#A6A6A6";
});

password1.addEventListener("focus", () => {
    let val = password1.value;
    if (val.match(alphabet) || val.match(numbers) || val.match(scharacters)) {
        password1.style.borderColor = "#FF6333";
        togglePassword1.style.color = "#FF6333";
        strength1.innerText = "Weak";
        strength1.style.color = "#FF6333";
        good1 = false;
    }
    if (val.match(alphabet) && val.match(numbers) && val.length >= 6) {
        password1.style.borderColor = "orange";
        togglePassword1.style.color = "orange";
        strength1.innerText = "Medium";
        strength1.style.color = "orange";
        good1 = false;
    }
    if (
        val.match(alphabet) &&
        val.match(numbers) &&
        val.match(scharacters) &&
        val.length >= 8
    ) {
        password1.style.borderColor = "#22C32A";
        togglePassword1.style.color = "#22C32A";
        strength1.innerText = "Strong";
        strength1.style.color = "#22C32A";
        good1 = true;
    }

    if (val == "") {
        password1.style.border = "2px solid rgba(0, 0, 0, 0.18)";
        togglePassword1.style.color = "#A6A6A6";
        strength1.innerText = "";
        strength1.style.color = "#A6A6A6";
        good1 = false;
    }
});

/* PASSWORD2 */
let good2 = false
password2.addEventListener("input", (e) => {
    let val = password2.value;
    if (val.match(alphabet) || val.match(numbers) || val.match(scharacters)) {
        password2.style.borderColor = "#FF6333";
        togglePassword2.style.color = "#FF6333";
        strength2.innerText = "Weak";
        strength2.style.color = "#FF6333";
        good2 = false;
    }
    if (val.match(alphabet) && val.match(numbers) && val.length >= 6) {
        password2.style.borderColor = "orange";
        togglePassword2.style.color = "orange";
        strength2.innerText = "Medium";
        strength2.style.color = "orange";
        good2 = false;
    }
    if (
        val.match(alphabet) &&
        val.match(numbers) &&
        val.match(scharacters) &&
        val.length >= 8
    ) {
        password2.style.borderColor = "#22C32A";
        togglePassword2.style.color = "#22C32A";
        strength2.innerText = "Strong";
        strength2.style.color = "#22C32A";
        good2 = true;
    }

    if (val == "") {
        password2.style.border = "2px solid rgba(0, 0, 0, 0.18)";
        togglePassword2.style.color = "#A6A6A6";
        strength2.innerText = "";
        strength2.style.color = "#A6A6A6";
        good2 = false;
    }
});

password2.addEventListener("blur", () => {
    password2.style.border = "2px solid rgba(0, 0, 0, 0.02)";
    togglePassword2.style.color = "#A6A6A6";
    strength2.innerText = "";
    strength2.style.color = "#A6A6A6";
});

password2.addEventListener("focus", () => {
    let val = password2.value;
    if (val.match(alphabet) || val.match(numbers) || val.match(scharacters)) {
        password2.style.borderColor = "#FF6333";
        togglePassword2.style.color = "#FF6333";
        strength2.innerText = "Weak";
        strength2.style.color = "#FF6333";
        good2 = false;
    }
    if (val.match(alphabet) && val.match(numbers) && val.length >= 6) {
        password2.style.borderColor = "orange";
        togglePassword2.style.color = "orange";
        strength2.innerText = "Medium";
        strength2.style.color = "orange";
        good2 = false;
    }
    if (
        val.match(alphabet) &&
        val.match(numbers) &&
        val.match(scharacters) &&
        val.length >= 8
    ) {
        password2.style.borderColor = "#22C32A";
        togglePassword2.style.color = "#22C32A";
        strength2.innerText = "Strong";
        strength2.style.color = "#22C32A";
        good2 = true;
    }

    if (val == "") {
        password2.style.border = "2px solid rgba(0, 0, 0, 0.18)";
        togglePassword2.style.color = "#A6A6A6";
        strength2.innerText = "";
        strength2.style.color = "#A6A6A6";
        good2 = false;
    }
});