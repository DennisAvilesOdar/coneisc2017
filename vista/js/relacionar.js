var service = "../controladores/";
var pagoSeleccionado = "none";
var documentoSeleccionado = new Array();
$(document).ready(function () {
    cargarComboTD("#cbotipodocumento", "todos");
    listarDocumentos();
    listarPagos();
});

$("#btnfiltrardocumentos").click(function () {
    listarDocumentos();
});

$("#btnfiltrarpagos").click(function () {
    listarPagos();
});

function listarPagos() {

    var fecha1 = $("#txtfecha1pagos").val();
    if (fecha1 === null) {
        fecha1 = date('Y-m-d');
    }

    var fecha2 = $("#txtfecha2pagos").val();
    if (fecha2 === null) {
        fecha2 = date('Y-m-d');
    }
    var codigoEstado = "0";
    var codigoUsuario = 0;
    var tipo = $("#cbotipo").val();

    $.post(
            service+"pago.listar.php",
            {
                p_fecha1: fecha1,
                p_fecha2: fecha2,
                p_estado: codigoEstado,
                p_usuario: codigoUsuario,
                p_tipo: tipo
            }).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado-pago" class="table table-hover">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
//            html += '<th>Codigo</th>';
//            html += '<th>F. REGISTRO</th>';
            html += '<th>DESCRIPCION</th>';
//            html += '<th>MONTO</th>';
            html += '<th>FECHA A PAGAR</th>';
            html += '<th style="text-align: center">X</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td>' + item.pago + '</td>';
                html += '<td>' + item.fechapagar + '</td>';
                html += '<td align="center">';

                html += '&nbsp;&nbsp;';
                html += '<input type="radio" name="rpagos" class="radio-inline item' + item.cod + '" onclick="seleccionPago(' + item.cod + ')">';

                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listadoPagos").html(html);

            $('#tabla-listado-pago').dataTable({
                "aaSorting": [[0, "asc"]]
            });

        } else {
            swal("Mensaje del sistema", "Este es el error :" + resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}



function listarDocumentos() {
    var fecha1 = $("#txtfecha1documentos").val();
    if (fecha1 === null) {
        fecha1 = date('Y-m-d');
    }
    var fecha2 = $("#txtfecha2documentos").val();
    if (fecha2 === null) {
        fecha2 = date('Y-m-d');
    }
    
    var codigoTipoDocumento = $("#cbotipodocumento").val();
    if (codigoTipoDocumento === null) {
        codigoTipoDocumento = 0;
    }

    $.post(
            service+"documento.listar.relacionado.php",
           {
                p_fecha1: fecha1,
                p_fecha2: fecha2,
                p_td: codigoTipoDocumento
            }
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>Nro.</th>';
            html += '<th>DESCRIPCION</th>';
//            html += '<th>MONTO</th>';
            html += '<th>TIPO DOC.</th>';
            html += '<th style="text-align: center">X</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {

                html += '<tr>';
                html += '<td>' + item.numdocu + '</td>';
                html += '<td>' + item.docu + '</td>';
                html += '<td>' + item.tipodocu + '</td>';
                html += '<td align="center">';

                html += '&nbsp;&nbsp;';
                html += '<input type="checkbox" id="cbDocNum' + i + '" class="checkbox-inline" onclick="arregloDocumentos(' + i + ',' + item.coddocu + ')">';

                html += '</td>';

                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listadoDocumentos").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[2, "asc"]]
            });

        } else {
            swal("Mensaje del sistema", "Este es el error :" + resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}


function cargarComboTD(p_nombreCombo, p_tipo) {
    $.post(
            service+"tipodocumento.cargar.php"
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";
            if (p_tipo === "seleccione") {
                html += '<option value="">Seleccione un Tipo de Documento</option>';
            } else {
                html += '<option value="0">Todos los Tipos de Documentos</option>';
            }
            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_tipo_documento + '">' + item.descripcion + '</option>';
            });

            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

$("#btnrelacionar").click(function () {
    if (pagoSeleccionado != "none") {
        if (documentoSeleccionado.length > 0) {

            var arrayDetalle = new Array();
            for (var i = 0; i < documentoSeleccionado.length; i++) {
                var objDocDet = new Object();
                objDocDet.coddoc = documentoSeleccionado[i];
                arrayDetalle.push(objDocDet);
            }
            var jsonDocumentos = JSON.stringify(arrayDetalle);
            alert(jsonDocumentos);
            $.post(
                    service+"detalledocumentopago.agregar.php",
                    {
                        p_codigo_pago: pagoSeleccionado,
                        p_codigo_documento: jsonDocumentos
                    }).done(function (resultado) {
                var datosJSON = resultado;
                if (datosJSON.estado === 200) {
                    swal("EXITO!", "Se ha registrado la relacion con exito!", "success");
                    listarDocumentos();
//                    listarRelacionados();
                } else {
                    swal("Mensaje del sistema", resultado, "warning");
                }
            }).fail(function (error) {
                var datosJSON = $.parseJSON(error.responseText);
                swal("Error", datosJSON.mensaje, "error");
            });
        }else{
            swal("Hey!", "Debes seleccionar algun documento!", "warning");
            
        }
    } else {
        swal("Hey!", "Debes seleccionar algun pago!", "warning");
    }

});

function seleccionPago(idPago) {
    pagoSeleccionado = idPago;
}

function arregloDocumentos(indx, idDoc) {
    if (document.getElementById('cbDocNum' + indx).checked) {
        documentoSeleccionado.push(idDoc);
//        alert(documentoSeleccionado);
    } else {
        var indice = documentoSeleccionado.indexOf(idDoc);
        if (indice > -1) {
            documentoSeleccionado.splice(indice, 1);
        }
//        alert(documentoSeleccionado);
    }
}


function listarRelacionados(){
    $.post(
            service+"relaciones.listar.php"
//    ,{
//                p_fecha1: fecha1,
//                p_fecha2: fecha2,
//                p_td: codigoTipoDocumento
//            }
            ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>Nro.</th>';
            html += '<th>DESCRIPCION</th>';
//            html += '<th>MONTO</th>';
            html += '<th>TIPO DOC.</th>';
            html += '<th style="text-align: center">X</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {

                html += '<tr>';
                html += '<td>' + item.numdocu + '</td>';
                html += '<td>' + item.docu + '</td>';
                html += '<td>' + item.tipodocu + '</td>';
                html += '<td align="center">';

                html += '&nbsp;&nbsp;';
                html += '<input type="checkbox" id="cbDocNum' + i + '" class="checkbox-inline" onclick="arregloDocumentos(' + i + ',' + item.coddocu + ')">';

                html += '</td>';

                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listadoDocumentos").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[2, "asc"]]
            });

        } else {
            swal("Mensaje del sistema", "Este es el error :" + resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}