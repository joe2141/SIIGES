<?php
	// Válida los permisos del usuario de la sesión
	require_once "../utilities/utileria-general.php";
	Utileria::validarSesion( basename( __FILE__ ) );

	//====================================================================================================

	require_once "../models/modelo-programa.php";
	require_once "../models/modelo-grupo.php";
	require_once "../models/modelo-turno.php";
	require_once "../models/modelo-ciclo-escolar.php";
	require_once "../models/modelo-asignatura.php";
	require_once "../models/modelo-alumno-grupo.php";
	require_once "../models/modelo-alumno.php";
	require_once "../models/modelo-persona.php";

	$programa = new Programa( );
	$programa->setAttributes( array( "id"=>$_GET["programa_id"] ) );
	$resultadoPrograma = $programa->consultarId( );

	$grupo = new Grupo( );
	$grupo->setAttributes( array( "id"=>$_GET["grupo_id"] ) );
	$resultadoGrupo = $grupo->consultarId( );

	$parametros["id"] = $resultadoGrupo["data"]["turno_id"];

	$turno = new Turno( );
	$turno->setAttributes( $parametros );
	$resultadoTurno = $turno->consultarId( );

	$parametros2["id"] = $resultadoGrupo["data"]["ciclo_escolar_id"];

	$cicloEscolar = new CicloEscolar( );
	$cicloEscolar->setAttributes( $parametros2 );
	$resultadoCicloEscolar = $cicloEscolar->consultarId( );
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SIIGES</title>
	<!-- CSS GOB.MX -->
	<link href="../favicon.ico" rel="shortcut icon">
	<link href="https://framework-gb.cdn.gob.mx/assets/styles/main.css" rel="stylesheet">
	<!-- CSS DATATABLE -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
	<!-- CSS LIVESELECT -->
	<link rel="stylesheet" type="text/css" href="../css/bootstrap-select.min.css">
	<!-- CSS CALENDAR -->
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<!-- CSS PROPIO -->
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>

<body>
	<!-- HEADER Y MENÚ -->
	<?php require_once "menu.php"; ?>

	<!-- CUERPO DE PANTALLA -->
	<div class="container">
		<section class="main row margin-section-formularios">

			<!-- BARRA DE INFORMACION -->
			<div class="row" style="padding-left: 15px; padding-right: 15px;">
				<div class="col-sm-12 col-md-12 col-lg-12">
					<!-- BARRA DE USUARIO -->
					<ol class="breadcrumb pull-right">
						<li><i class="icon icon-user"></i></li>
						<li><?php echo $_SESSION["nombre_rol"]; ?></li>
						<li class="active"><?php echo $_SESSION["nombre"]." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"]; ?></li>
					</ol>
					<!-- BARRA DE NAVEGACION -->
					<ol class="breadcrumb pull-left">
						<li><i class="icon icon-home"></i></li>
						<li><a href="ce-ciclos-escolares.php?programa_id=<?php echo $_GET["programa_id"]; ?>">Ciclos Escolares</a></li>
						<li><a href="ce-grados.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>">Grados</a></li>
						<li><a href="ce-grupos.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>">Grupos</a></li>
						<li class="active">Inscripci&oacute;n de Alumnos</li>
					</ol>
				</div>
			</div>

			<!-- CUERPO PRINCIPAL -->
			<form name="form1" method="post" action="../controllers/control-alumno-grupo.php">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<!-- TÍTULO -->
				<h2 id="txtNombre">Inscripci&oacute;n de Alumnos</h2>
				<hr class="red">
				<div class="row">
          <div class="col-sm-12">
						<legend><?php echo $resultadoPrograma["data"]["nombre"]; ?></legend>
					</div>
				</div>
				<!-- NOTIFICACIÓN -->
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==200 ){ ?>
        <div class="alert alert-success">
					<p>Registro procesado.</p>
        </div>
        <?php } ?>
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==404 ){ ?>
        <div class="alert alert-danger">
					<p>La matr&iacute;cula ingresada no existe.</p>
        </div>
				<?php } ?>
				<?php if( isset( $_GET["codigo"] ) && $_GET["codigo"]==403 ){ ?>
        <div class="alert alert-danger">
					<p>Alumno no autorizado para ser inscrito.</p>
        </div>
        <?php } ?>
				<!-- CONTENIDO -->
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="15%">Grado</th>
									<th width="15%">Grupo</th>
									<?php
									if (Rol::ROL_REVALIDACION_EQUIVALENCIA != $_SESSION["rol_id"]):
									 ?>
	                <th width="15%">Turno</th>
									<?php
									endif; ?>
									<th width="55%">Ciclo</th>
								</tr>
							</thead>
	            <tbody>
								<tr>
									<td><?php echo $resultadoGrupo["data"]["grado"]; ?></td>
									<td><?php echo $resultadoGrupo["data"]["grupo"]; ?></td>
									<?php
									if (Rol::ROL_REVALIDACION_EQUIVALENCIA != $_SESSION["rol_id"]):
									 ?>
									<td><?php echo $resultadoTurno["data"]["nombre"]; ?></td>
									<?php
									endif; ?>
									<td><?php echo $resultadoCicloEscolar["data"]["nombre"]; ?></td>
								</tr>
	            </tbody>
						</table>
          </div>
        </div>

				<div class="row" style="padding-top: 50px;">
          <div class="col-sm-12">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<legend>INSCRIPCI&Oacute;N DE ALUMNOS</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="matricula">Matr&iacute;cula</label>
							<input type="text" id="matricula" name="matricula" maxlength="255" class="form-control" required />
						</div>
          </div>
					<div class="col-sm-8">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="20%">Inscribir</th>
									<th width="10%">Clave</th>
									<th width="10%">Seriaci&oacute;n</th>
									<th width="60%">Asignatura</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$parametros["programa_id"] = $_GET["programa_id"];
								$parametros["grado"] = $_GET["grado"];

								$asignatura = new Asignatura( );
								$asignatura->setAttributes( $parametros );
								$resultadoAsignatura = $asignatura->consultarAsignaturasGrado( );

								$max = count( $resultadoAsignatura["data"] );

								for( $i=0; $i<$max; $i++ )
								{
							?>
							<tr>
								<td align="center"><input type="checkbox" id="asignaturas_grado[]" name="asignaturas_grado[]" value="<?php echo $resultadoAsignatura["data"][$i]["id"]; ?>" /></td>
								<td><?php echo $resultadoAsignatura["data"][$i]["clave"]; ?></td>
								<td><?php echo $resultadoAsignatura["data"][$i]["seriacion"]; ?></td>
								<td><?php echo $resultadoAsignatura["data"][$i]["nombre"]; ?></td>
							</tr>
							<?php
								}
							?>
	            </tbody>
						</table>
          </div>
        </div>
				<?php
					$parametros["programa_id"] = $_GET["programa_id"];
					$parametros["grado"] = "Optativa";

					$asignaturaOptativa = new Asignatura( );
					$asignaturaOptativa->setAttributes( $parametros );
					$resultadoAsignaturaOptativa = $asignaturaOptativa->consultarAsignaturasGrado( );

					if ($resultadoAsignaturaOptativa["data"]) {
				?>
				<div class="row">
          <div class="col-sm-4">
            <div class="form-group">
							<label class="control-label" for="matricula">Optativas</label>
						</div>
          </div>
					<div class="col-sm-8">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte1" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="20%">Inscribir</th>
									<th width="80%">Asignatura Optativa</th>
								</tr>
							</thead>
	            <tbody>
								<?php

									$max = count( $resultadoAsignaturaOptativa["data"] );

									for( $j=0; $j<$max; $j++ )
									{
								?>
							<tr>
								<td align="center"><input type="checkbox" id="asignaturas_grado[]" name="asignaturas_grado[]" value="<?php echo $resultadoAsignaturaOptativa["data"][$j]["id"]; ?>" /></td>
								<td><?php echo $resultadoAsignaturaOptativa["data"][$j]["nombre"]; ?></td>
							</tr>
							<?php
								}
							?>
	            </tbody>
						</table>
          </div>
        </div>
				<?php
					}
				?>
				<div class="row">
          <div class="col-sm-12">
            <div class="form-group">
							<input type="submit" id="submit" name="submit" value="Enviar" class="btn btn-primary" />
							<input type="hidden"  name="webService" value="guardarAlumnoGrupo" />
							<input type="hidden"  name="programa_id" value="<?php echo $_GET['programa_id']; ?>" />
							<input type="hidden"  name="ciclo_id" value="<?php echo $_GET['ciclo_id']; ?>" />
							<input type="hidden"  name="grado" value="<?php echo $_GET['grado']; ?>" />
							<input type="hidden"  name="grupo_id" value="<?php echo $_GET['grupo_id']; ?>" />
						</div>
          </div>
        </div>

				<div class="row" style="padding-top: 50px;">
          <div class="col-sm-12">
          </div>
        </div>
				<div class="row">
          <div class="col-sm-12">
						<legend>ALUMNOS INSCRITOS</legend>
					</div>
				</div>
				<div class="row">
          <div class="col-sm-12">
            <table id="tabla-reporte2" class="table table-striped table-bordered" cellspacing="0" width="100%">
	            <thead>
								<tr>
	                <th width="20%">Matr&iacute;cula</th>
									<th width="60%">Nombre</th>
									<th width="20%">Acciones</th>
								</tr>
							</thead>
	            <tbody>
							<?php
								$parametros["grupo_id"] = $_GET["grupo_id"];

								$alumnoGrupo = new AlumnoGrupo( );
								$alumnoGrupo->setAttributes( $parametros );
								$resultadoAlumnoGrupo = $alumnoGrupo->consultarAlumnosGrupo( );

								$max = count( $resultadoAlumnoGrupo["data"] );

								for( $i=0; $i<$max; $i++ )
								{
									$parametros2["id"] = $resultadoAlumnoGrupo["data"][$i]["alumno_id"];

									$alumno = new Alumno( );
									$alumno->setAttributes( $parametros2 );
									$resultadoAlumno = $alumno->consultarId( );

									$parametros3["id"] = $resultadoAlumno["data"]["persona_id"];

									$persona = new Persona( );
									$persona->setAttributes( $parametros3 );
									$resultadoPersona = $persona->consultarId( );
							?>
							<tr>
								<td><?php echo $resultadoAlumno["data"]["matricula"]; ?></td>
								<td><?php echo $resultadoPersona["data"]["apellido_paterno"]." ".$resultadoPersona["data"]["apellido_materno"]." ".$resultadoPersona["data"]["nombre"]; ?></td>
								<td><a href="../controllers/control-alumno-grupo.php?programa_id=<?php echo $_GET["programa_id"]; ?>&ciclo_id=<?php echo $_GET["ciclo_id"]; ?>&grado=<?php echo $_GET["grado"]; ?>&grupo_id=<?php echo $_GET["grupo_id"]; ?>&alumno_id=<?php echo $resultadoAlumnoGrupo["data"][$i]["alumno_id"]; ?>&id=<?php echo $resultadoAlumnoGrupo["data"][$i]["id"]; ?>&webService=eliminarAlumnoGrupo" onclick="return confirmarBaja( )"><span id="" title="Eliminar" class="glyphicon glyphicon-trash col-sm-1 size_icon"></span></a></td>
							</tr>
							<?php
								}
							?>
	            </tbody>
						</table>
          </div>
        </div>
			</div>
			</form>

		</section>
	</div>

<!-- JS GOB.MX -->
<script src="https://framework-gb.cdn.gob.mx/gobmx.js"></script>
<!-- JS JQUERY -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- JS DATATABLE -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<!-- JS LIVESELECT -->
<script src="../js/bootstrap-select.min.js"></script>
<!-- JS CALENDAR -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	$(document).ready(function(){
		$("#generacion_fecha_inicio").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		});

		$("#generacion_fecha_fin").datepicker({
			firstDay: 1,
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
			dateFormat: 'yy-mm-dd'
		});
	});

	function confirmarBaja( )
	{
		if( confirm( "¿Desea eliminar el registro seleccionado?\nSe eliminarán asignaturas y calificaciones del alumno." ) )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
</script>
</body>
</html>
