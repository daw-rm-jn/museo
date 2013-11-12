function nombreUser(uname)
{
    var letters = /^[A-Za-z]+$/;
    if (uname.value.match(letters))
    {
        return true;
    }
    else
    {
        alert('El nombre de usuario es incorrecto');
        uname.focus();
        return false;
    }
}
function validarPass(passid, mx, my)
{
    var passid_len = passid.value.length;
    if (passid_len == 0 || passid_len >= my || passid_len < mx)
    {
        alert("La contraseña no puede estar vacia y debe tener entre " + mx + " y " + my + "caracteres");
        passid.focus();
        return false;
    }
    return true;
}
function validarEmail(uemail)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (uemail.value.match(mailformat))
    {
        return true;
    }
    else
    {
        alert("El email es incorrecto");
        uemail.focus();
        return false;
    }
}


