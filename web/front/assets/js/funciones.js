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


$(function(){
  $("#slides").slidesjs({
    play: {
      active: true,
        // [boolean] Generate the play and stop buttons.
        // You cannot use your own buttons. Sorry.
      effect: "slide",
        // [string] Can be either "slide" or "fade".
      interval: 5000,
        // [number] Time spent on each slide in milliseconds.
      auto: true,
        // [boolean] Start playing the slideshow on load.
      swap: true,
        // [boolean] show/hide stop and play buttons
      pauseOnHover: false,
        // [boolean] pause a playing slideshow on hover
      restartDelay: 2500
        // [number] restart delay on inactive slideshow
    }
  });
});