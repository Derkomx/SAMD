 <?php 
 $mn = $_GET['mn'];
 $id_usuario = 1;
 $mnn = nombremenu($mn, $id_usuario, $mysqli);
 ?> 
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
					<label for="titulo">Materia: <?php echo $mnn[0];?></label>
					<input type="text" class="form-control" id="titulo" maxlength="128" placeholder="Indica un Titulo para este Documento" onKeyUp="count_it()" onKeyDown="count_it()">
					<p class="text-right text-muted font-weight-light"><span id="counter">128</span> caracteres restantes.</p>
				</div>				
				<label>Quieres agregar una imagen?</label></br>
				<div id="btnImagenes" class="mt-1 text-center">
					<!-- <button type="submit" class="btn btn-warning mt-1" onclick="AceptarUsuario()"><i class="fas fa-images"></i> Seleccionar desde galería</button> -->
					<button type="submit" class="btn btn-warning mt-1" onclick="CargarImagen()"><i class="fas fa-file-upload"></i> Cargar imagen</button>

					<div class="col-md-7 mx-auto mt-3">
						<img style="display: block; max-width: 100%; height: auto;" id="imgFinal" />
					</div>
				</div>
			</div>			
			<div class="col-md-10 mt-4 mx-auto">
				<div class="text-center">
					<label>Cuerpo de la publicación</label>
				</div>
				<div id="summernote" class="mt-3"></div>
			</div>
			<div class="col-md-6 mt-4 mx-auto text-center">
				<label for="fecha">Fecha de publicación</label>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadio" id="flexRadio1" checked>
					<label class="form-check-label" for="flexRadio1">
						Publicar con fecha actual
					</label>
				</div>
				<!--<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadio" id="flexRadio2">
					<label class="form-check-label" for="flexRadio2">
						Publicar con fecha específica
					</label>
				</div>
				<div class="col-md-8 mx-auto text-center">
				<div class="form-group">
					<input type="datetime" class="form-control" placeholder="Ingrese fecha y hora" id="datetime-picker">
				</div>
				</div>-->
			</div>
		</div>		
		<div class="col-md-5 mt-4 mx-auto text-center">
			<button class="btn btn-success mb-3" onclick="Publicar()">Publicar</button>
		</div>
	</div>
</section>

<script>
	// Inicia el summernote
	$(document).ready(function() {
		$('#summernote').summernote({
			lang: 'es-ES',
			height: 300,
			minHeight: 200,
		});
	});

	// Inicia el flatpickr
	flatpickr('#datetime-picker', {
		enableTime: true,
		dateFormat: "d-m-Y H:i",
	});
</script>
  
<script>
	function Publicar() {
		// Se obtienen los datos ingresados
		var Titulo = document.getElementById("titulo").value;
		var Imagen = document.getElementById("imgFinal").src;
		var Cuerpo = $("#summernote").summernote("code");
		var tFecha = document.getElementById("flexRadio1").checked;
		//var Fecha = document.getElementById("datetime-picker").value;
		<?php echo "var mn = ".$mn.";"; ?>

		if (Titulo.length == 0) {
			document.getElementById("titulo").focus();
			Notiflix.Notify.Failure("¡Debes escribir un título para la publicación!");
			return;
		}
		

		if (tFecha) {
			Fecha = 0;
		} else {
			if (Fecha.length == 0) {
				Notiflix.Notify.Failure("¡Debes ingresar una fecha para crear la publicación!");
				return;
			}
		}

		// Activa la pantalla de carga
		Notiflix.Loading.Pulse('Cargando publicación... 0%');

		var theJSON = {Archivo: 'Publicaciones.php', Tipo: 'Publicar', Titulo: Titulo, Imagen: Imagen, Cuerpo: Cuerpo, Fecha: Fecha, Mn: mn};
		uploadJSON(theJSON);
	}

	function uploadJSON(theJSON) {
		var str = JSON.stringify(theJSON);
		
		var blob;
		var reader = new FileReader();
		var oMyBlob = new Blob([str], {type : 'application/json'});
		reader.readAsArrayBuffer(oMyBlob);
		reader.onloadend  = function(evt) {
			xhr = new XMLHttpRequest();
			xhr.open("POST", "Inyector.php", true);
				
			XMLHttpRequest.prototype.mySendAsBinary = function(text) {
				var ui8a = new Uint8Array(new Int8Array(text));
				if (typeof window.Blob == "function") {
					blob = new Blob([ui8a]);
				} else {
					var bb = new (window.MozBlobBuilder || window.WebKitBlobBuilder || window.BlobBuilder)();
					bb.append(ui8a);
					blob = bb.getBlob();
				}
					
				this.send(blob);
			}

			var eventSource = xhr.upload || xhr;
			eventSource.addEventListener("progress", function(e) {
				var position = e.position || e.loaded;
				var total = e.totalSize || e.total;
				var percentage = Math.round((position/total)*100);

				document.getElementById("NotiflixLoadingMessage").textContent = "Cargando publicación... " + percentage + "%";
					
				if (percentage == 100) {
					document.getElementById("NotiflixLoadingMessage").textContent = "Creando la publicación, espere...";
				}
			});

			xhr.addEventListener('error', function() {
				Notiflix.Loading.Remove();
				Notiflix.Notify.Failure("¡Ocurrió un error al cargar la publicación!");
				return;
			});

			xhr.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					var Resultado = JSON.stringify(this.responseText);
					console.log(Resultado);
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
							'¡Éxito!',
							'La publicación fue creada correctamente.',
							'Aceptar',
							function(){
								document.location = '?Seccion=ListaPublicaciones';
							}
						);

						return;
					}
				}
			};

			xhr.mySendAsBinary(evt.target.result);
		};
	}

</script>

<script>
function count_it() {
    document.getElementById('counter').innerHTML = (document.getElementById('titulo').maxLength - document.getElementById('titulo').value.length);
}
count_it();

// Variables
var Resultado = null;

// Coloca la imagen ya recortada y editada en su respectiva posición
function AceptarImagen() {
	var croppedimage = Cropp.getCroppedCanvas().toDataURL("image/jpeg");

	Swal.close()

	var htmlImg = document.getElementById("imgFinal");
	htmlImg.src = croppedimage;
}

function EditarImagen(URL) {
	// Ejecuta el SweetAlert
	Swal.fire({
		title: 'Recortar y editar imagen',
		html:
			'<div class="dropdown-divider"></div>' +
			'<img id="editorIMG" style="display: block; max-width: 100%; height: auto;" src="' + URL + '"><br>' +
			'<div class="btn-toolbar" role="toolbar" aria-label="Toolbar">' +
				'<div class="wrapper text-center mx-auto">' +
					'<div class="btn-group mr-2 mb-1" role="group" aria-label="Zoom">' +
						'<button type="button" class="btn btn-info" onclick="Cropp.zoom(-0.1)"><i class="fas fa-search-minus"></i></button>' +
						'<button type="button" class="btn btn-info" onclick="Cropp.zoom(0.1)"><i class="fas fa-search-plus"></i></button>' +
					'</div>' +
					'<div class="btn-group mr-2 mb-1" role="group" aria-label="Mover">' +
						'<button type="button" class="btn btn-info" onclick="Cropp.move(-3, 0)"><i class="fas fa-arrow-left"></i></button>' +
						'<button type="button" class="btn btn-info" onclick="Cropp.move(3, 0)"><i class="fas fa-arrow-right"></i></button>' +
						'<button type="button" class="btn btn-info" onclick="Cropp.move(0, 3)"><i class="fas fa-arrow-down"></i></button>' +
						'<button type="button" class="btn btn-info" onclick="Cropp.move(0, -3)"><i class="fas fa-arrow-up"></i></button>' +
					'</div>' +
					'<div class="btn-group mr-2 mb-1" role="group" aria-label="Rotar">' +
						'<button type="button" class="btn btn-info" onclick="Cropp.rotate(-45)"><i class="fas fa-undo"></i></button>' +
						'<button type="button" class="btn btn-info" onclick="Cropp.rotate(45)"><i class="fas fa-redo"></i></button>' +
					'</div>' +
					'<div class="btn-group mr-2 mb-1" role="group" aria-label="Aceptar">' +
						'<button type="button" class="btn btn-success" onclick="AceptarImagen()">Aceptar</button>' +
					'</div>' +
				'</div>' +
			'</div>',
		width: 800,
		showCloseButton: true,
		allowOutsideClick: false,
		showConfirmButton: false
	})

	Cropp = new Cropper(document.getElementById('editorIMG'), {
		aspectRatio: 1.3 / 1,
		guides: false,
		zoomable: true,
		scalable: false,
		zoomOnTouch: false,
		zoomOnWheel: false,
		movable: true,
		crop(event) {
			//console.log(event.detail.x);
			//console.log(event.detail.y);
			//console.log(event.detail.width);
			//console.log(event.detail.height);
			//console.log(event.detail.rotate);
			//console.log(event.detail.scaleX);
			//console.log(event.detail.scaleY);
		},
	});
}

// Carga la imagen desde un archivo
function CargarArchivo() {
	// Se obtiene el archivo
	var Archivo = document.getElementById("InputIMG");

	// Se chequea si el usuario cargó el archivo
	if (Archivo.value.length > 0) {
		const Imagen = Archivo.files[0];
		
		const reader = new FileReader();
		reader.addEventListener('load', event => {
            Resultado = event.target.result;
			
			EditarImagen(Resultado);
		});

		reader.readAsDataURL(Imagen);
	}
}

// Cargar la imagen desde URL
function CargarURL() {
	// Se obtiene el archivo
	var URL = document.getElementById("InputURL").value;

	if (URL.length == 0) {
		Notiflix.Notify.Failure("¡Debes ingresar una URL!");
		return;
	} else {
		// Activa la pantalla de carga
		Notiflix.Loading.Pulse('Obteniendo imagen...');

		// Crea una nueva imagen
		var imgCheck = new Image();

		// Chequea si la imagen se carga correctamente
		imgCheck.onload = function() {
			Notiflix.Loading.Remove();

			EditarImagen(URL);
		};

		// Chequea si la imagen no pudo ser cargada
		imgCheck.onerror = function(){
			Notiflix.Loading.Remove();
			Notiflix.Notify.Failure("¡Ocurrió un error o la URL es inválida!");
		};       

		// Intenta cargar la imagen desde la URL ingresada
		imgCheck.src = URL;
	}
}

// Función del botón "Cargar imagen"
// Crea un formulario para cargar dicha imagen desde URL o archivo
function CargarImagen() {
	// Ejecuta el SweetAlert
	Swal.fire({
		title: 'Cargar imagen',
		html:
			'<div class="dropdown-divider"></div>' +
			'<br><p class="text-center font-weight-bold">Desde archivo</p>' +
			'<input id="InputIMG" type="file" accept="image/x-png,image/gif,image/jpeg" onchange="CargarArchivo()"><br><br>' +
			'<p class="text-center font-weight-bold">Desde URL</p>' +
			'<div class="input-group mb-3">' +
				'<input id="InputURL" type="text" class="form-control" placeholder="Insertar URL" aria-label="Insertar URL" aria-describedby="button-addon2">' +
				'<div class="input-group-append">' +
					'<button class="btn btn-info" type="button" onclick="CargarURL()" id="button-addon2">Cargar</button>' +
				'</div>' +
			'</div>',
		showCloseButton: true,
		allowOutsideClick: false,
		confirmButtonText: 'Cerrar',
	})
}
</script>