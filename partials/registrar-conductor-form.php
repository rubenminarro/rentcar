<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Registro de Conductores</h4>
            </div>
			<div class="card-body">
				<div id="alerts"></div>
				<form id="form-registrar-conductor" name="form-registrar-conductor" enctype="multipart/form-data">
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
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label for="fec_nac">Fecha Nacimiento</label>
                        <input id="fec_nac" name="fec_nac" type="date" class="form-control" placeholder="Fecha Nacimiento" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="id_estado">Estado</label>
                        <select class="form-control" id="id_estado" name="id_estado" required></select>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label for="documento">Documento</label>
                        <input id="documento" name="documento" type="file" style="opacity: 100;position: inherit;" class="form-control" placeholder="Documento" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button id="btn-registrar-conductor" type="submit" class="btn btn-primary btn-round">Registrar conductor</button>
                    </div>
                  </div>
                </form>
			</div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
      
		  cargarEstadosConductores();

      $("#form-registrar-conductor").submit(function(e){

        e.preventDefault();

        var formData = new FormData($(this)[0]);

        registrarConductor(formData);
        
      });

		});

</script>