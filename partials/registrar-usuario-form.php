<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Registro de Usuarios</h4>
            </div>
			<div class="card-body">
				<div id="alerts"></div>
				<form id="form-registrar-usuario" name="form-registrar-usuario" oninput='confirmar_password.setCustomValidity(confirmar_password.value != password.value ? "Las contraseñas no coinciden." : "")'>
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
                        <label for="password">Contraseña</label>
                        <input id="password" name="password" type="password" class="form-control" placeholder="password" pattern="[a-z0-9.\-]{8,}" title="La contraseña de contener número y letras y más de ocho caracteres." required>
                      </div>
                    </div>
					<div class="col-md-3 px-1">
                      <div class="form-group">
                        <label for="confirmar_password">Confirmar contraseña</label>
                        <input id="confirmar_password" name="confirmar_password" type="confirmar_password" class="form-control" placeholder="Contraseña" pattern="[a-z0-9.\-]{8,}" title="La contraseña debe contener número y letras y más de ocho caracteres." required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button id="btn-registrar-usuario" type="submit" class="btn btn-primary btn-round">Registrar Usuario</button>
                    </div>
                  </div>
                </form>
			</div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
      
		cargarEstados();

      $("#form-registrar-usuario").submit(function(e){

        e.preventDefault();

        var formData = new FormData($(this)[0]);

        registrarUsuario(formData);

		});

	});

</script>