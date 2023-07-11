<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Registro de Conductores</h4>
            </div>
			<div class="card-body">
				<div id="alerts"></div>
				<form id="form-registrar-conductor">
                  <div class="row">
                    <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" placeholder="Nombre">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="apellido">Apellido</label>
                        <input type="text" class="form-control" placeholder="Apellido">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 px-1">
                      <div class="form-group">
                        <label>C.I.</label>
                        <input type="text" class="form-control" placeholder="C.I.">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label for="fec_nacimiento">Fec. Nacimiento</label>
                        <input type="text" class="form-control" placeholder="Fec. Nacimiento">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-primary btn-round">Guardar conductor</button>
                    </div>
                  </div>
                </form>
			</div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
      
		/*cargarEstados();

		$("#form-registrar-conductor").submit(function(event){
			guardarConductor();
			return false;
		});*/

    });

</script>