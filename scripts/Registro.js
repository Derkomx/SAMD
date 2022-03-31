Notiflix.Report.Init({
    plainText: false,
});

isEmailValid = false;


// Run pswmeter with options
const myPassMeter = passwordStrengthMeter({
    containerElement: '#pswmeter',
    passwordInput: '#Clave',
    showMessage: true,
    messageContainer: '#pswmeter-message',
    messagesList: [
        '',
        'Muy fácil!',
        'Normal',
        'Segura',
        'Muy segura'
    ],

    height: 6,
    borderRadius: 0,
    pswMinLength: 8,
    colorScore1: '#FF0000',
    colorScore2: '#fc7703',
    colorScore3: '#36ba2f',
    colorScore4: '#2f97ba'
});

// Función al pulsar el botón "Registrarse" para crear una cuenta nueva
function Registro() {
    // Se obtienen los datos ingresados
    var CUIL = document.getElementById("CUIL").value;

    var Correo = document.getElementById("Correo").value;
    var CCorreo = document.getElementById("CCorreo").value;

    var Clave = document.getElementById("Clave").value;
    var CClave = document.getElementById("CClave").value;

    var Seguridad = myPassMeter.getScore();

    var Check = document.getElementById("checkterm").checked;

    // Variable para verificar si completó todos los campos
    var Incompleto = false;

    // Si no se escribió un CUIL, se notifica
    if (CUIL.length == 0) {
        Incompleto = true;

        // Remarca en rojo el borde
        document.getElementById("CUIL").style.borderColor = "LightCoral";

        setTimeout(function() { document.getElementById("CUIL").style.borderColor = "LightGray"; }, 3000);
    }

    if (Correo.length == 0) {
        Incompleto = true;

        // Remarca en rojo el borde
        document.getElementById("Correo").style.borderColor = "LightCoral";

        setTimeout(function() { document.getElementById("Correo").style.borderColor = "LightGray"; }, 3000);
    }

    if (CCorreo.length == 0) {
        Incompleto = true;

        // Remarca en rojo el borde
        document.getElementById("CCorreo").style.borderColor = "LightCoral";

        setTimeout(function() { document.getElementById("CCorreo").style.borderColor = "LightGray"; }, 3000);
    }

    // Si no escribió una clave, se notifica
    if (Clave.length == 0) {
        Incompleto = true;

        // Remarca en rojo el borde
        document.getElementById("Clave").style.borderColor = "LightCoral";

        setTimeout(function() { document.getElementById("Clave").style.borderColor = "LightGray"; }, 3000);
    }

    if (CClave.length == 0) {
        Incompleto = true;

        // Remarca en rojo el borde
        document.getElementById("CClave").style.borderColor = "LightCoral";

        setTimeout(function() { document.getElementById("CClave").style.borderColor = "LightGray"; }, 3000);
    }

    if (Incompleto) {
        Notiflix.Notify.Failure("¡Debes completar todos los campos!");
        return;
    }

    // verifica que los correos sean iguales
    if (CCorreo != Correo) {
        Notiflix.Notify.Failure("Los correos ingresadas son diferentes!");
        document.getElementById("Correo").value = "";
        document.getElementById("CCorreo").value = "";
        return;
    }

    // Chequea si el correo ingresado es uno válido
    if (!isEmailValid) {
        Notiflix.Notify.Failure("¡El correo electrónico ingresado es inválido!");
        return;
    }

    // verifica que las claves sean iguales
    if (CClave != Clave) {
        Notiflix.Notify.Failure("Las claves ingresadas son diferentes!");
        document.getElementById("Clave").value = "";
        document.getElementById("CClave").value = "";
        return;
    }

    if (Seguridad <= 1) {
        Notiflix.Notify.Failure("¡La clave es muy insegura!");
        return;
    }

    if (Check != true) {
        Notiflix.Notify.Failure("Debe Aceptar los Terminos y condiciones!");
        return;
    }

    // Activa la pantalla de carga
    Notiflix.Loading.Circle('Cargando...');
    $.ajax({
        type: 'POST',
        url: './Inyector.php',
        data: { Archivo: 'Registro.php', CUIL: CUIL, Clave: hex_sha512(Clave), Correo: Correo },
        dataType: 'html',
        success: function(data) {
            console.log(data);
            var Resultado = JSON.parse(data);
            Notiflix.Loading.Remove();

            if (Resultado.error) {
                Notiflix.Notify.Failure(Resultado.error);
                return;
            }

            if (Resultado.success) {
                document.getElementsByClassName('login-page')[0].style.display = "none";

                Notiflix.Report.Success(
                    '¡Registrado con éxito!',
                    'Tu usuario fue registrado correctamente. Recibirás un correo electrónico en la dirección de correo que ingresaste, donde deberás confirmar tu cuenta para poder acceder a la página.',
                    'Aceptar',
                    function() {
                        document.location = "./";
                    }
                );
            }
        },
        error: function(data) {
            console.log(data);
        }
    });

}


function Terminos() {
    // Obtiene el estado del checkbox y lo vuelve a su estado anterior
    var State = document.getElementById("checkterm").checked;
    document.getElementById("checkterm").checked = !State;
}


document.getElementById('Correo').addEventListener('input', function() {
    campo = event.target;

    emailRegex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;

    // Chequea si el email es válido
    if (emailRegex.test(campo.value)) {
        isEmailValid = true;
    } else {
        isEmailValid = false;
    }
});

// Funcion que se ejecutará al escribir caracteres en el campo 'Clave'
document.getElementById('Clave').addEventListener('input', function() {
    // Obtiene lo escrito en el campo
    Valor = event.target.value;

    // Obtiene los elementos que mostrarán la seguridad de la clave
    var Barra = document.getElementById("pswmeter")
    var Texto = document.getElementById("pswmeter-message")

    // Chequea si hay más de un caracter escrito
    if (Valor.length > 0) {
        // Chequea si la barra está oculta
        if (Barra.style.display == 'none') {
            // Muestra los elementos
            Barra.style.display = 'block';
            Texto.style.display = 'block';
        }
    } else {
        // Chequea si la barra está visible
        if (Barra.style.display == 'block') {
            // Oculta los elementos
            Barra.style.display = 'none';
            Texto.style.display = 'none';
        }
    }
});