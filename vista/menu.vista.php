<header class="main-header">               
<nav class="navbar navbar-static-top">
  <div class="container-fluid">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
      <i class="fa fa-bars"></i>
    </button>
  </div>
  <div class="collapse navbar-collapse" id="navbar-collapse">
    <ul class="nav navbar-nav">
        <li class="dropdown">
            <a href="principal.vista.php" class="dropdown-toggle"><i class="fa fa-home"></i>&nbsp;Inicio</a>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-edit"></i>&nbsp;Mantenimientos <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
<!--            <li><a href="tipoDocumento.vista.php">Tipo de Documentos</a></li>-->
            <li><a href="documentos.vista.php">Documentos</a></li>
            <li class="divider"></li>
            <li><a href="pago.vista.php">Pagos</a></li>
	    <li class="divider"></li>
            <li><a href="relacionar.vista.php">Relaciones</a></li>
          </ul>
        </li>
    </ul>
      
      <ul class="nav navbar-nav navbar-right">
          <li class="dropdown" onclick="cerrarSesion()">
            <a class="dropdown-toggle">
                <script>
                function cerrarSesion(){
                    swal({
                        title: "Saliendo del Sistema",
                        text: "¿Desea Cerrar Sesión?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: '#ff0000',
                        confirmButtonText: 'Si',
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                            function (isConfirm) {

                                if (isConfirm) { //el usuario hizo clic en el boton SI
                                    document.location.href = "index.php";
                                }
                            });
                }
                </script>
                <i class="fa fa-lock"></i>&nbsp;Cerrar Sesión</a>
        </li>
        
    </ul>
  </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>
</header>