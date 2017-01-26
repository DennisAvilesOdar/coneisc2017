<?php
require '../util/funciones/definiciones.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE_GESTION ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php include 'estilos.vista.php'; ?>
    </head>
    <body class="skin-green layout-top-nav">
        <div class="wrapper">
            <?php include 'menu.vista.php'; ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="row">
                        <div class="col-xs-6">
                            <h1 class="text-bold text-black text-center" style="font-size: 20px;">Documentos <button type="button" class="btn btn-danger btn-sm" id="btnfiltrardocumentos"><i class="fa fa-search"></i></button></h1>
                            <div class="row">
                                
                                <div class="col-xs-3">
                                    <label class="text-muted small">Desde</label>
                                    <div class="input-group">
                                        <input type="date" id="txtfecha1documentos" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div><!-- /.input group -->
                                </div>
                                <div class="col-xs-3">
                                    <label class="text-muted small">Hasta</label>
                                    <div class="input-group">
                                        <input type="date" id="txtfecha2documentos" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div><!-- /.input group -->
                                </div>
                                <div class="col-xs-4">
                                    <label class="text-muted small">Tipos</label>
                                    <select class="form-control input-sm" name="cbotipodocumento" id="cbotipodocumento" required="" ></select>
                                </div>
                                <div class="col-xs-2"><!--BLANCK SPACE--></div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <h1 class="text-bold text-black text-center" style="font-size: 20px;"><button type="button" class="btn btn-danger btn-sm" id="btnfiltrarpagos"><i class="fa fa-search"></i></button> Pagos</h1>
                            <!--<div class="col-xs-1">-->
                                    <!--<label style="display: block;">&nbsp;</label>-->
                                    
                                <!--</div>-->
                            <div class="row">

                            
                                <div class="col-xs-2"><!--BLANCK SPACE--></div>
                                <div class="col-xs-3">

                                    <label class="text-muted small">&nbsp;</label>
                                    <select class="form-control input-sm" name="cbotipo" id="cbotipo" required="" >
                                        <option value="1">Por pagar entre:</option>
                                        <option value="2">Registrados entre:</option>
                                    </select>

                                </div>

                                <div class="col-xs-3">
                                    <label class="text-muted small">Desde</label>
                                    <div class="input-group">
                                        <input type="date" id="txtfecha1pagos" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div><!-- /.input group -->
                                </div>


                                <div class="col-xs-3">
                                    <label class="text-muted small">Hasta</label>
                                    <div class="input-group">
                                        <input type="date" id="txtfecha2pagos" class="form-control input-sm" value="<?php echo date('Y-m-d'); ?>"/>
                                    </div><!-- /.input group -->
                                </div>



                            </div>
                        </div>
                    </div>
                </section>
                <section class="content">
                    <small>

                    </small>
                    <!-- FIN del formulario modal -->


                    <p>

                    <div class="row">
                        <div class='col-xs-5'>
                            <div class="box box-success">
                                <div class="box-body ">
                                    <div id="listadoDocumentos">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <button type="button" class="btn btn-danger btn-lg center-block " id="btnrelacionar"><i class="fa fa-link"></i> Relacionar</button>
                        </div>
                        <div class='col-xs-5'>
                            <div class="box box-success">
                                <div class="box-body">
                                    <div id="listadoPagos">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='col-xs-3'></div>
                        <div class='col-xs-6'>
                            <h1 class="text-bold text-black text-center" style="font-size: 20px;">Relacionados <button type="button" class="btn btn-danger btn-sm" id="btnfiltrardocumentos"><i class="fa fa-search"></i></button></h1>
                            <div class="box box-success">
                                <div class="box-body ">
                                    <div id="listadoRelaciones">

                                        <!--Aqui se muestran las relaciones de cada pago con sus respectivos documentos-->
                                        
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </p>
                </section>
            </div>

        </div>
        <script  type="text/javascript">
        </script>
        <?php
        include 'scripts.vista.php';
        ?>
        <script src="js/relacionar.js" type="text/javascript"></script>
    </body>
</html>