<?php 
ob_start(); 

session_start();
  $date = date('Y-m-d h:i:s', time());
  $fechaactual = strtotime($date);
  $mn = $_GET['core'];
  $id_usuario = $_SESSION['id_usuario'];
  $Blog = obtenerBlog($mn, $id_usuario, $mysqli);
  $mnn = nombremenu($mn, $id_usuario, $mysqli);
  ?>
  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.jpg" alt="AdminLTELogo" height="60" width="60">
  </div>
<!-- Content Wrapper. Contains page content -->
<div class="container-fluid pb-4 padding">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?php echo $mnn[0];?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">home</a></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
  <!-- Main content -->
  <section class="content">
      <div class="container-fluid">

        <!-- Timelime example  -->
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              <div class="time-label">
                <span class="bg-blue">Ahora</span>
              </div>
              <div>
                <i class="fas fa-comments bg-green"></i>
                <div class="timeline-item">
                  <span class="time"><i class="fas fa-clock"></i> Ahora</span>
                  <h3 class="timeline-header"><a href="?Seccion=Publicar&mn=<?php echo $mn?>"></a>:D</h3>

                  <div class="timeline-body">
                   Hola :D
                   Quieres realizar una nueva publicacion?, presiona en el boton Crear Nueva!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-sm" href="?Seccion=Publicar&mn=<?php echo $mn?>" >Crear Nueva!</a>
                  </div>
                </div>
              </div>
              <!-- /.timeline-label -->
              <!-- a adaptar-->
              <?php 

					foreach($Blog as $ID) {
                        
                        $fechapublicacion  = strtotime($ID[2]) ;
                        if ($fechapublicacion !== $fechaactual){
                                $HTML = file_get_contents('publicaciones/HTML/'.$mn.'/'.$ID[0].'.html');
                                echo '<div>'.
                                    '<i class="fas fa-clock bg-blue"></i>'.
                                    '<div class="timeline-item">'.
                                    '<span class="time"><i class="fas fa-clock"></i> '.$ID[2].'</span>'.
                                    '<h3 class="timeline-header"><a href="?Seccion=VerPublicacion&mn=1&Publicacion='.$ID[0].'"> Presiona AQUI para acceder a esta publicacion de '.$ID[1].'</a></h3>'.
                                    '<div class="timeline-body">'.substr(strip_tags($HTML, '<br>'), 0, 256).'...</div>'.
                                    '<div class="timeline-footer">'.
                                    '</div>'.
                                    '</div>'.
                                    '</div>';
                                    //echo '<div class="row pb-4">'.
                                    //'<div class="col-md-5">'.
                                    //    '<div class="fh5co_hover_news_img">'.
                                    //        '<div class="fh5co_news_img"><img src="Publicaciones/Preview/'.$ID[0].'.jpeg" alt=""/></div>'.
                                    //        '<div></div>'.
                                    //    '</div>'.
                                    //'</div>'.
                                    //'<div class="col-md-7 animate-box">'.
                                    //    '<a href="?Seccion=VerPublicacion&Publicacion='.$ID[0].'" class="fh5co_magna py-2">'.$ID[1].'</a> <a href="?Seccion=VerPublicacion&Publicacion='.$ID[0].'" class="fh5co_mini_time py-3">'.$ID[2].'</a>
                                    //    <div class="fh5co_consectetur">
                                    //        '.substr(strip_tags($HTML, '<br>'), 0, 256).'...
                                    //    </div>
                                    //</div>
                                //</div>';
                        };
					}
				?>
              <!--fin a adaptar-->
              <div>
                <i class="fas fa-clock bg-gray"></i>
              </div>
            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.timeline -->
    </section>
</div>