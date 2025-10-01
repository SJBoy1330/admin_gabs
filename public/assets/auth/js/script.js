const container = document.querySelector('.custom-auth-container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');


registerBtn.addEventListener('click',() => {
    container.classList.add('active');
});

loginBtn.addEventListener('click',() => {
    container.classList.remove('active');
});