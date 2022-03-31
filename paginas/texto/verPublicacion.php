<link href="css/style_1.css" rel="stylesheet" type="text/css"/>
<link href="css/img.css" rel="stylesheet" type="text/css"/>

<?php
	$Publicacion = $_GET['Publicacion'];
    $mn = $_GET['mn'];
	$dPublicacion = obtenerPublicacion($mn, $Publicacion, $mysqli);
?>

<?php  
$archivo = 'Publicaciones/Preview/'.$mn.'/'.$Publicacion;
if(file_exists($archivo)){
    echo '<div id="fh5co-title-box" style="background-image: url(Publicaciones/Preview/'.$Publicacion.'.jpeg); background-position: 50% 90.5px;" data-stellar-background-ratio="0.5">'.
    '<div class="overlay"></div>'.
    '<div class="page-title">'.
    '</div>'.
    '</div>';
};
?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>

<div id="fh5co-single-content" class="container-fluid pb-4 pt-4 paddding">
    <div class="container paddding">
        <div class="row mx-0">
            <div class="col-md-10 mx-auto animate-box" data-animate-effect="fadeInLeft">
                <?php include 'Publicaciones/HTML/'.$mn.'/'.$Publicacion.'.html'; ?>
                
            </div>
        </div>
    </div>
</div>

<!-- Parallax -->
<script src="Scripts/jquery.stellar.min.js"></script>

<script src="Scripts/main.js"></script>