<?php
//OAU
//require_once 'sesion.validar.vista.php';
require '../util/funciones/definiciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE_GESTION ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php include 'estilos.vista.php'; ?>
    </head>
    <body class="skin-green layout-top-nav">
        <div class="wrapper">
            <?php include 'menu.vista.php'; ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Documentos</h1>
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
                                            <input type="hidden" name="txtusuario" id="txtusuario" class="form-control" value="1">  <!--se usara el codigo 1 hasta que se termine de programar la validacion de sesion <?php echo $codigoUsuario?>-->
                                            <div class="row">
                                                <div class="col-xs-3">
                                                    <p>Código<input type="text" name="txtcodigo" id="txtcodigo" class="form-control input-sm text-center text-bold" placeholder="" readonly=""></p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p>Nro. Documento<input type="text" name="txtnumerodocumento" id="txtnumerodocumento" class="form-control input-sm text-center text-bold" placeholder=""></p>
                                                </div>    
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-xs-9">
                                                <!--
                                                <p><?php echo $codigoUsuario?> </p>
                                                <p><?php echo $fotoUsuario?> </p>
                                                <p><?php echo $cargoUsuario?> </p>
                                                -->
                                                    <p>Descripcion <font color = "red">*</font>
                                                    <input type="text" name="txtdescripcion" id="txtdescripcion" class="form-control input-sm" placeholder="" required=""><p>
                                                </div>
                                                <div class="col-xs-3">
                                                    <p>Monto<input type="text" name="txtmonto" id="txtmonto" class="form-control input-sm text-center text-bold" placeholder=""></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <label>Tipos:&nbsp;</label>
                                                    <select class="form-control input-sm" name="cbotipodocumentomodal" id="cbotipodocumentomodal" required="" ></select>
                                                </div>
                                                <div class="col-xs-6">
                                                    <p>Foto de la boleta: </p>
                                                    <input type="file" name="foto" id="foto">
                                                </div>
                                                
                                            </div>
                                            <p>
                                                <br>
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
                        <div class="col-xs-2">
                            <label>Desde:&nbsp;</label>
                            <div class="input-group">
                                <input type="date" id="txtfecha1" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                            </div><!-- /.input group -->
                        </div>
                        <div class="col-xs-2">
                            <label>Hasta:&nbsp;</label>
                            <div class="input-group">
                                <input type="date" id="txtfecha2" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                            </div><!-- /.input group -->
                        </div>
                        <div class="col-xs-2">
                            <label>Tipos:&nbsp;</label>
                            <select class="form-control input-sm" name="cbotipodocumento" id="cbotipodocumento" required="" ></select>
                        </div>
                        <div class="col-xs-2">
                            <label>Usuarios&nbsp;</label>
                            <select class="form-control input-sm" name="cbousuarios" id="cbousuarios" required="" ></select>
                        </div>
                        <div class="col-xs-1">
                            <label>Estado:&nbsp;</label>
                            <select class="form-control input-sm" name="cboestado" id="cboestado" required="" >
                                <option value="E">Emitido</option>
                                <option value="A">Anulado</option>
                                <option value="0">Todos</option>
                            </select>
                        </div>
                        <div class="col-xs-1">
                            <label style="display: block;">&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" id="btnfiltrar"><i class="fa fa-recycle"></i> Actualizar</button>
                        </div>

                        <div class="col-xs-2">
                            <label style="display: block;">&nbsp;</label>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal" id="btnagregar"><i class="fa fa-copy"></i> Nuevo documento</button>
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
        <?php
        include 'scripts.vista.php';
        ?>
        <script src="js/documento.js" type="text/javascript"></script>
    </body>
</html>