<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Edición de Usuarios</h4>
            </div>
			<div class="card-body">
				<div id="alerts"></div>
				<form id="form-editar-usuario" name="form-editar-usuario" oninput='confirmar_password.setCustomValidity(confirmar_password.value != password.value ? "Las contraseñas no coinciden." : "")'>
				  <input type="hidden" id="id" name="id">
                  <div class="row">
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Nombre" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input id="apellido" name="apellido" type="text" class="form-control" placeholder="Apellido" required>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label for="ci">N° Documento</label>
                        <input id="ci" name="ci" type="number" class="form-control" placeholder="N° Documento" required>
                      </div>
                    </div>
                  </div> 
                  <div class="row">
				  	<div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label for="id_estado">Estado</label>
                        <select class="form-control" id="id_estado" name="id_estado" required></select>
                      </div>
                    </div>
				 	<div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label for="usuario">Usuario</label>
                        <input id="usuario" name="usuario" type="text" class="form-control" placeholder="Usuario" required>
                      </div>
                    </div>
					<div class="col-md-3 px-1">
                      <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="Nueva contraseña" pattern="[a-z0-9.\-]{8,}" title="La contraseña de contener número y letras y más de ocho caracteres.">
                      </div>
                    </div>
					<div class="col-md-3 px-1">
                      <div class="form-group">
                        <label for="confirmar_password">Confirmar contraseña</label>
                        <input id="confirmar_password" name="confirmar_password" type="confirmar_password" class="form-control" placeholder="Confirmar nueva contraseña" pattern="[a-z0-9.\-]{8,}" title="La contraseña debe contener número y letras y más de ocho caracteres.">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button id="btn-editar-usuario" type="submit" class="btn btn-primary btn-round">Editar Usuario</button>
                    </div>
                  </div>
                </form>
			</div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
      
		  var id = <?php echo isset($_GET['id']) ? $_GET['id'] : 0; ?>;

      if(id > 0){
        cargarDatosUsuario(id);
      }

      $("#form-editar-usuario").submit(function(e){

        e.preventDefault();

        var formData = new FormData($(this)[0]);

        actualizarUsuario(formData);
        
      });

		});
</script>