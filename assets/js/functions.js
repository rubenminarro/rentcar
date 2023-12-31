$('.nav li').click(function() {
    
    $('li').removeClass('active'); 
    $(this).addClass('active'); 

    var id = $(this).attr('id');

    switch (id) {
        case '1':
            $('#content').html('')
            $('#content').load('partials/conductores.php');
            break;
        case '2':
            $('#content').html('')
            $('#content').load('partials/registrar-conductor-form.php');
            break;
        case '3':
            $('#content').html('')
            $('#content').load('partials/usuarios.php');
            break;
        case '4':
            $('#content').html('')
            $('#content').load('partials/registrar-usuario-form.php');
            break;  
        default:
            break;
    }

});

function cargarListaConductores(){

    $.ajax({
        url: "api/conductores/conductores-lista.php",
        method: "POST",
        dataType: "json",
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#table-lista-conductores > tbody").html('');
            //$.blockUI();
        },
        success: function (data) {
            if(data.ConductoresCount > 0){
                
                html = '';
                
                for (var i = 0; i < data.Conductores.length; i++) {

                    html += '<tr class="">';
                        html += '<td class="text-center">';
                            html += '<a href="#" onclick="editarConductor('+data.Conductores[i].id+');" title="Editar Conductor" style="margin-right:5px;"><i class="nc-icon nc-circle-10"></i></a>';
                            switch (data.Conductores[i].id_estado) {
                                case '2':
                                    html += '<a href="#" onclick="cambiarEstadoConductor('+data.Conductores[i].id+',1);" title="Activar Conductor"><i class="nc-icon nc-simple-add"></i></a>';
                                    break;
                                default:
                                    html += '<a href="#" onclick="cambiarEstadoConductor('+data.Conductores[i].id+',2);" title="Inactivar Conductor"><i class="nc-icon nc-simple-remove"></i></a>';
                                    break;
                                }
                        html += '</td>';
                        html += '<td>' + data.Conductores[i].nombre + ' ' + data.Conductores[i].apellido + '</td>';
                        html += '<td>' + data.Conductores[i].ci + '</td>';
                        switch (data.Conductores[i].id_estado) {
                            case '1':
                                html += '<td class="text-center"><div class="alert alert-success"><span>Activo</span></div></td>';
                                break;
                            case '2':
                                html += '<td class="text-center"><div class="alert alert-warning"><span>Inactivo</span></div></td>';
                                break;
                            case '3':
                                html += '<td class="text-center"><div class="alert alert-danger" style="background-color: #000000;"><span>Lista Negra</span></div></td>';
                                break;
                            case '4':
                                html += '<td class="text-center"><div class="alert alert-danger" style="background-color:#CCC;color:#000;"><span>Borrado</span></div></td>';
                                break;
                            default:
                                break;
                        }
                        html += '<td class="text-center">';
                            html += '<a href="#" onclick="verHistorialConductor('+data.Conductores[i].id+'); return false;" title="Ver Historial Conductor" style="margin-right:5px;"><i class="nc-icon nc-paper"></i></a>';
                            html += '<a href="#" onclick="agregarHistorialConductor('+data.Conductores[i].id+',\'rminarro\'); return false;" title="Agregar Historial Conductor"><i class="nc-icon nc-book-bookmark"></i></a>';
                        html += '</td>';
                    html += '</tr>';
                }
                
                $("#table-lista-conductores > tbody").append(html);
            }

            var table = $('#table-lista-conductores').DataTable({
                language: {
                    url: 'assets/js/plugins/es-ES.json',
                },
            });
            
        }
    });

}

function verHistorialConductor(id) {

    var datos = {};
    datos["id"] = id;

    $.ajax({
        url: "api/conductores/historial-conductores.php",
        method: "POST",
        dataType: "json",
        data: datos,
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#historialConductorModal > .modal-dialog > .modal-content > .modal-body").html('');
            $("#historialConductorModalLabel").html('');
            //$.blockUI();
        },
        success: function (data) {
            
                
            html = '';
            html += '<div class="table-responsive">';
                html += '<table id="table-lista-historial" class="table">';
                    html += '<thead class=" text-primary">';
                        html += '<tr>';
                            html += '<th>Motivo</th>';
                            html += '<th>Observación</th>';
                            html += '<th>Creado por</th>';
                            html += '<th>Fecha creación</th>';
                        html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';
                        if(data.ConductorHistorialCount > 0){
                            for (var i = 0; i < data.ConductorHistorialCount; i++) {
                                html += '<tr>';
                                    html += '<td>'+data.ConductorHistorial[i].motivo+'</td>';
                                    html += '<td>'+data.ConductorHistorial[i].observacion+'</td>';
                                    html += '<td>'+data.ConductorHistorial[i].creado_por+'</td>';
                                    html += '<td>'+data.ConductorHistorial[i].fecha_creacion+'</td>';
                                html += '</tr>';
                            }
                        }else{
                            html += '<tr class="align-middle"><td class="text-center" colspan="4" height="60">No existe historial del conductor</td></tr>';
                        }
                    html += '<tbody>';
                html += '</table>';
            html += '</div>';
            
            if(data.ConductorHistorialCount > 0){
                $("#historialConductorModalLabel").append('Historial del conductor: '+data.ConductorHistorial[0].nombre_completo);
            }else{
                $("#historialConductorModalLabel").append('Historial del conductor vacio.');
            }           

            $("#historialConductorModal > .modal-dialog > .modal-content > .modal-body").append(html);
            
            
            $('#historialConductorModal').modal();
        }
    });
}

async function agregarHistorialConductor(id_condutor,usuario) {

    $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html('');

    const motivo = await cargarMotivos();

    select = '';
    select += '<select class="form-control" id="id_motivo" name="id_motivo">';
        if(motivo.ConductorMotivosCount > 0){
            for (var i = 0; i < motivo.ConductorMotivosCount; i++) {
                select += '<option value="'+motivo.ConductorMotivos[i].id+'">'+motivo.ConductorMotivos[i].descripcion;
            }
        }else{
            select += '<option>No existen motivos cargados</option>';
        }
    select += '</select>';

    html = '';

    html += '<input type="hidden" id="id_conductor" name="id_conductor" value='+id_condutor+'>';
    html += '<input type="hidden" id="id_estado" name="id_estado" value="1">';
    html += '<input type="hidden" id="creado_por" name="creado_por" value='+usuario+'>';
    html += '<div class="form-group">';
        html += '<label for="id_motivo" class="col-form-label">Motivo:</label>';
        html += select;
    html += '</div>';
    html += '<div class="form-group">';
        html += '<label for="observacion" class="col-form-label">Observación:</label>';
        html += '<textarea id="observacion" class="form-control" name="observacion" rows="4" cols="50"></textarea>';
    html += '</div>';
    
    $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").append(html);
    $('#agregarHistorialConductorModal').modal();

}

function guardarHistorialConductor(){

    $.ajax({
        url: "api/conductores/agregar-historial-conductor.php",
        method: "POST",
        dataType: "json",
        data: $('#form-agregar-historial-conductor').serialize(),
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#agregarHistorialConductorModal > .modal-dialog > .modal-content > form > .modal-body").html('');
        },
        success: function (data) {
            $('#agregarHistorialConductorModal').modal('hide');
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }
        }
    });
}

async function cargarMotivos(){

    const res = await $.ajax({
        url: "api/conductores/motivos.php",
        method: "POST",
        dataType: "json",
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            return data;
        }
    });

    return res;
}

function cambiarEstadoConductor(id_conductor,id_estado){

    var datos = {};
    datos["id_conductor"] = id_conductor;
    datos["id_estado"] = id_estado;
    datos["modificado_por"] = 'rminarro';

    $.ajax({
        url: "api/conductores/cambiar-estado-conductor.php",
        method: "POST",
        dataType: "json",
        data: datos,
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }
        }
    });
}

async function cargarEstados(){

    var select = '';

    const res = await $.ajax({
        url: "api/conductores/cargar-estados.php",
        method: "POST",
        dataType: "json",
        complete: function (e) {
            //$.unblockUI();
        },
        beforeSend: function (e) {
            $("#id_estado").html('');
            //$.blockUI();
        },
        success: function (data) {

            if(data.EstadosCount > 0){
                for (var i = 0; i <data.EstadosCount; i++) {
                    select += '<option value="'+data.Estados[i].id+'">'+data.Estados[i].descripcion;
                }
            }else{
                select += '<option>No existen motivos cargados</option>';
            }

            $("#id_estado").html(select);

        }
    });

    return res;
}

function registrarConductor(formData){
    
    $.ajax({
        url: "api/conductores/registrar-conductor.php",
        method: "POST",
        dataType: "json",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#registro-conductor").trigger("click");
                });
            }
        }
    });
}

function editarConductor(id){
    $('#content').html('');
    $('#content').load('partials/editar-conductor-form.php?id='+id);
}

async function cargarDatosConductor(id){

    await cargarEstados();

    var datos = {};
    datos["id"] = id;

    const res = await $.ajax({
        url: "api/conductores/cargar-datos-conductor.php",
        method: "POST",
        dataType: "json",
        data: datos,
        beforeSend: function (e) {
            $('#form-editar-conductor').trigger("reset");
        },
        success: function (data) {

            if(data.ConductorCount > 0){
                for (var i = 0; i <data.ConductorCount; i++) {
                    $('#id').val(data.Conductor[i].id);
                    $('#nombre').val(data.Conductor[i].nombre);
                    $('#apellido').val(data.Conductor[i].apellido);
                    $('#ci').val(data.Conductor[i].ci);
                    $('#id_estado').val(data.Conductor[i].id_estado);
                    $('#documento-anterior').val(data.Conductor[i].documento);
                    $('#fec_nac').val(data.Conductor[i].fec_nac);
                    $('#documento-img').html('');
                    $('#documento-img').html('<img src="/lista/assets/img/documentos/'+data.Conductor[i].documento+'" alt="Documento anterior" style="width: 240px;"/>');
                }
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }
        }

    });

    return res;
}

function actualizarConductor(formData){
    
  $.ajax({
      url: "api/conductores/actualizar-conductor.php",
      method: "POST",
      dataType: "json",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      complete: function (e) {
          //$.unblockUI();
      },
      success: function (data) {
          if(data.status == 1){
              Swal.fire({
                title: 'Atención!',
                text: data.mensaje,
                icon: 'success',
                confirmButtonText: 'Continuar'
              }).then((result) => {
                 $('#content').load('partials/editar-conductor-form.php?id='+data.id);
              });
          }else{
              Swal.fire({
                title: 'Atención!',
                text: data.mensaje,
                icon: 'error',
                confirmButtonText: 'Continuar'
              }).then((result) => {
                $("#registro-conductor").trigger("click");
              });
          }
      }
  });
}

function cambiarEstadoUsuario(id,id_estado){

    var datos = {};
    datos["id"] = id;
    datos["id_estado"] = id_estado;
    datos["modificado_por"] = 'rminarro';

    $.ajax({
        url: "api/usuarios/cambiar-estado-usuario.php",
        method: "POST",
        dataType: "json",
        data: datos,
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#usuarios-permisos").trigger("click");
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#usuarios-permisos").trigger("click");
                });
            }
        }
    });
}

function cargarListaUsuarios(){
  
  $.ajax({
    url: "api/usuarios/usuarios-lista.php",
    method: "POST",
    dataType: "json",
    complete: function (e) {
      //$.unblockUI();
    },
    beforeSend: function (e) {
      $("#table-lista-usuarios > tbody").html('');
      //$.blockUI();
    },
    success: function (data) {
      
      if(data.UsuariosCount > 0){
        
        html = '';
        
        for (var i = 0; i < data.UsuariosCount; i++) {

          html += '<tr class="">';
            html += '<td class="text-center">';
              html += '<a href="#" onclick="editarUsuario('+data.Usuarios[i].id+');" title="Editar Usuario" style="margin-right:5px;"><i class="nc-icon nc-circle-10"></i></a>';
              switch (data.Usuarios[i].id_estado) {
                case '2':
                    html += '<a href="#" onclick="cambiarEstadoUsuario('+data.Usuarios[i].id+',1);" title="Activar Usuario"><i class="nc-icon nc-simple-add"></i></a>';
                    break;
                default:
                    html += '<a href="#" onclick="cambiarEstadoUsuario('+data.Usuarios[i].id+',2);" title="Inactivar Usuario"><i class="nc-icon nc-simple-remove"></i></a>';
                    break;
              }
            html += '</td>';
            html += '<td>' + data.Usuarios[i].nombre + ' ' + data.Usuarios[i].apellido + '</td>';
            html += '<td>' + data.Usuarios[i].ci + '</td>';
            html += '<td>' + data.Usuarios[i].usuario + '</td>';
            switch (data.Usuarios[i].id_estado) {
              case '1':
                html += '<td class="text-center"><div class="alert alert-success"><span>Activo</span></div></td>';
                break;
              case '2':
                html += '<td class="text-center"><div class="alert alert-warning"><span>Inactivo</span></div></td>';
                break;
              default:
                break;
            }
            html += '<td>' + data.Usuarios[i].creado_por + '</td>';
            html += '<td>' + data.Usuarios[i].fecha_creacion + '</td>';
          html += '</tr>';

        }
        
        $("#table-lista-usuarios > tbody").append(html);
      }

      var table = $('#table-lista-usuarios').DataTable({
        language: {
          url: 'assets/js/plugins/es-ES.json',
        },
      });
    }
  });

  

}

function registrarUsuario(formData){
    
    $.ajax({
        url: "api/usuarios/registrar-usuario.php",
        method: "POST",
        dataType: "json",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#usuarios").trigger("click");
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#registro-usuario").trigger("click");
                });
            }
        }
    });
}

function editarUsuario(id){
    $('#content').html('');
    $('#content').load('partials/editar-usuario-form.php?id='+id);
}

function actualizarUsuario(formData){
    
    $.ajax({
        url: "api/usuarios/actualizar-usuario.php",
        method: "POST",
        dataType: "json",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        complete: function (e) {
            //$.unblockUI();
        },
        success: function (data) {
            if(data.status == 1){
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'success',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                   $('#content').load('partials/editar-usuario-form.php?id='+data.id);
                });
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#registro-usuario").trigger("click");
                });
            }
        }
    })
}

async function cargarDatosUsuario(id){

    await cargarEstados();

    var datos = {};
    datos["id"] = id;

    const res = await $.ajax({
        url: "api/usuarios/cargar-datos-usuario.php",
        method: "POST",
        dataType: "json",
        data: datos,
        beforeSend: function (e) {
            $('#form-editar-usuario').trigger("reset");
        },
        success: function (data) {

            if(data.UsuarioCount > 0){
                for (var i = 0; i <data.UsuarioCount; i++) {
                    $('#id').val(data.Usuario[i].id);
                    $('#nombre').val(data.Usuario[i].nombre);
                    $('#apellido').val(data.Usuario[i].apellido);
                    $('#ci').val(data.Usuario[i].ci);
                    $('#usuario').val(data.Usuario[i].usuario);
                    $('#id_estado').val(data.Usuario[i].id_estado);
                }
            }else{
                Swal.fire({
                  title: 'Atención!',
                  text: data.mensaje,
                  icon: 'error',
                  confirmButtonText: 'Continuar'
                }).then((result) => {
                  $("#conductores").trigger("click");
                });
            }
        }

    });

    return res;
}