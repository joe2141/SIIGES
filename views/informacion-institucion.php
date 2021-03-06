<?php session_start( ); $usuario_id = $_SESSION['id']; ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Datos Institución</title>
	<!-- CSS GOB.MX -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body >


  <!-- HEADER Y BARRA DE NAVEGACION -->
	<?php require_once "menu.php"; ?>


<!-- CUERPO DEL FORMULARIO -->
<div class="container">
	<section class="main row margin-section-formularios">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<!-- BARRA DE USUARIO -->
			<ol class="breadcrumb pull-right">
				<li><i class="icon icon-user"></i></li>
					<li><?php echo $_SESSION["nombre_rol"]; ?></li>
				<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
			</ol>
			<ol class="breadcrumb">
				<li><a href="home.php"><i class="icon icon-home"></i></a></li>
				<li><a href="home.php">SIIGES</a></li>
				<li><a href="institucion-planteles.php">Planteles</a></li>
				<li class="active">Institución</li>
			</ol>

			<h2>Editar información básica de la institución</h2>
			<hr class="red">


			<!-- INICIA FORMULARIO -->
			<form  role="form" class="form" method="post" action="../controllers/control-institucion.php" enctype="multipart/form-data">
					<div class="form-group" >
						<label class="control-label" for="razon_social">Razón Social *</label><br>
						<input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Razón social de la institución" required>
					</div>
					<div class="form-group">
						<label class="control-label" for="nombre">Nombre Institución *</label><br>
						<input class="form-control" id="nombre" name="nombre" value="" placeholder="Nombre de la institución" type="text" required>
					</div>
					<div class="form-group">
						<label class="control-label" for="historia">Historia </label><br>
            <textarea class="form-control" id="historia" name="historia"  rows="8" placeholder="Por favor detalle la historia de la institución"></textarea>
          </div>
          <div class="form-group">
            <label class="control-label" for="vision">Visión </label><br>
            <textarea class="form-control" id="vision" name="vision"  rows="8" placeholder="Escriba la visión de la Institución"></textarea>
          </div>
          <div class="form-group">
            <label class="control-label" for="mision">Misión </label><br>
            <textarea class="form-control" id="mision" name="mision"  rows="8" placeholder="Escriba la misíon de la institución"></textarea>
          </div>
          <div class="form-group">
            <label class="control-label" for="valores_instiucionales">Valores Institucionales </label><br>
            <textarea class="form-control" id="valores_institucionales" name="valores_institucionales"  rows="8" placeholder="Enliste los valores con los que cuenta la institución"></textarea>
          </div>

					<div id="boton_mostar" class="form-group" style="display:none">
						<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalCarta">Ver acta constitutiva</button>
					</div>


					<div class="form-group">
						<label class="control-label" for="">Acta constitutiva de la Institución</label><br>
						<input type="file"  accept="application/pdf" name="acta_constitutiva" class="form-control" value=""  placeholder="">
					</div>


          <div class="form-group">
            <input id="usuario_id" type="hidden" name="usuario_id" value="<?=$usuario_id?>" >
            <input type="hidden" id="id" name="id"/>
						<input type="hidden" id="documento_id" name="documento_id"/>
            <!-- <input type="hidden" id="es_nombre_autorizado" name="es_nombre_autorizado"/> -->
            <input type="hidden" id="webService" name="webService" value="guardar" />
            <input type="hidden" id="url" name="url" value="../views/institucion-planteles.php" />
            <input type="submit" id="" name="" class="btn btn-primary pull-right" value="Guardar cambios" />
  				</div>
			</form>
			<p class="small text-muted">*Campos obligatorios</p>
		</div>
	</section>
</div>

<!-- Modal -->

<div class="modal fade" id="modalCarta" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Acta constitutiva</h5>
      </div>
      <div class="modal-body">
				<iframe  class="embed-responsive-item" id="acta" src="" height="100%" width="100%" style="height: 600px;"></iframe>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!-- JS PROPIOS -->
<script src="../js/funciones.js"></script>
<script src="../js/instituciones.js"></script>

</body>
</html>
