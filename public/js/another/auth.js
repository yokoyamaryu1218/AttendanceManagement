const pwd = document.getElementById('password');
const pwd2 = document.getElementById('password_confirmation');
const pwd3 = document.getElementById('old_password');

const pwdCheck = document.getElementById('password-check');
const pwdCheck2 = document.getElementById('password-check2');
const pwdCheck3 = document.getElementById('password-check3');

pwdCheck.addEventListener('change', function () {
    if (pwdCheck.checked) {
        pwd.setAttribute('type', 'text');
    } else {
        pwd.setAttribute('type', 'password');
    }
}, false);

pwdCheck2.addEventListener('change', function () {
    if (pwdCheck2.checked) {
        pwd2.setAttribute('type', 'text');
    } else {
        pwd2.setAttribute('type', 'password');
    }
}, false);

pwdCheck3.addEventListener('change', function () {
    if (pwdCheck3.checked) {
        pwd3.setAttribute('type', 'text');
    } else {
        pwd3.setAttribute('type', 'password');
    }
}, false);