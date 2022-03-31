<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>
<!-- Cabezera de contenido -->

<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6"></div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="#">Inicio</a></li>
				</ol>
			</div>
		</div>
	</div>
</section>

<!-- Contenido -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 mx-auto text-center">
				<div class="form-group">
					<label for="titulo">Nombre de la carpeta</label>
					<input type="text" class="form-control" id="titulo" maxlength="50" placeholder="Indica un nombre para la carpeta" onKeyUp="count_it()" onKeyDown="count_it()">
					<p class="text-right text-muted font-weight-light"><span id="counter">50</span> caracteres restantes.</p>
				</div>
            </div>
        </div>  
        <div class="col-md-5 mt-4 mx-auto text-center">
			<button class="btn btn-success mb-3" onclick="Publicar()">Crear!</button>
		</div>
    </div>
</section>
<script>
function count_it() {
    document.getElementById('counter').innerHTML = (document.getElementById('titulo').maxLength - document.getElementById('titulo').value.length);
}
count_it();
</script>      
<script>
function Publicar(){
    var Titulo = document.getElementById("titulo").value;
    if (Titulo.length == 0) {
        Notiflix.Notify.Failure("Debes ingresar un nombre a tu carpeta");
        return;
    }
    $.ajax({
        type: 'POST',
        url: 'Inyector.php',
        data: { Archivo: 'crearmenu.php', Titulo: Titulo},
        dataType: 'html',
        success: function(data) {
            var Resultado = JSON.parse(data);
            Notiflix.Loading.Remove();
            if (Resultado.error) {
                Notiflix.Report.Failure(
                    '¡Error!',
                    Resultado.error,
                    'Aceptar'
                );

                return;
            }

            if (Resultado.success) {
                Notiflix.Report.Success(
                    '¡Correcto!',
                    'Tu carpeta fue creada :D',
                    'Aceptar',
                    ()=>{
                        window.location.replace("index.php");
                    }
                );
            }

            //document.location = Resultado.location;
        },
        error: function(data) {
            Notiflix.Notify.Failure("¡No se pudo recibir una respuesta del servidor!");
            Notiflix.Loading.Remove();
            return;
        }
    });
}
</script>