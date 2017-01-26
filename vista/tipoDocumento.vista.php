<?php 
    require '../util/funciones/definiciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE_GESTION?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php include 'estilos.vista.php'; ?>
    </head>
    <body class="skin-green layout-top-nav">
        <div class="wrapper">
            <?php include 'menu.vista.php';?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Tipos de Documentos</h1>
                </section>
                <section class="content">
                    <small>
                        <form id="frmgrabar">
                            <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"> 
                                           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="titulomodal">Título de la ventana</h4>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="txttipooperacion" id="txttipooperacion" class="form-control">
                                            <div class="row">
                                                <div class="col-xs-4">
                                                    <p>Código Tipo de Documento<input type="text" name="txtcodigo" id="txtcodigo" class="form-control input-sm text-center text-bold" placeholder="" readonly=""></p>
                                                </div>
                                            </div>
                                            <p>Descripcion <font color = "red">*</font>
                                            <input type="text" name="txtdescripcion" id="txtdescripcion" class="form-control input-sm" placeholder="" required=""><p>
                                            <p>
                                                <font color = "red">* Campos obligatorios</font>
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" aria-hidden="true"><i class="fa fa-save"></i> Grabar</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btncerrar"><i class="fa fa-close"></i> Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </small>
                    <!-- FIN del formulario modal -->

                    <div class="row">
                        <div class="col-xs-3">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Nuevo tipo de documento</button>
                        </div>
                    </div>
                    <p>
                    <div class="box box-success">
                        <div class="box-body">
                            <div id="listado">
                                
                            </div>
                        </div>
                    </div>
                    </p>
                </section>
            </div>
            
        </div>
                <script  type="text/javascript">
            var service = "<?php echo C_WEBSERVICE?>"
        </script>
        <?php include 'scripts.vista.php';?>
        <script src="js/tipoDocumento.js" type="text/javascript"></script>
    </body>
</html>