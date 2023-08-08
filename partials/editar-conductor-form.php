<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title"> Edición de Conductores</h4>
      </div>
    	<div class="card-body">
    		<form id="form-editar-conductor" name="form-editar-conductor" enctype="multipart/form-data">
          <input type="hidden" id="id" name="id">
          <input type="hidden" id="documento-anterior" name="documento-anterior">
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
              <div>
                <div id="documento-img" class="mb-1 d-flex justify-content-center"></div>
                <div class="d-flex justify-content-center">
                    <div class="btn btn-defaul btn-rounded">
                      <label class="form-label text-white m-1" for="documento-nuevo">Agregar nuevo Documento</label>
                      <input id="documento-nuevo" name="documento-nuevo" type="file" class="form-control d-none" />
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="update ml-auto mr-auto">
              <button id="btn-editar-conductor" type="submit" class="btn btn-primary btn-round">Actualizar conductor</button>
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
        cargarDatosConductor(id);
      }

      $("#form-editar-conductor").submit(function(e){

        e.preventDefault();

        var formData = new FormData($(this)[0]);

        actualizarConductor(formData);
        
      });

		});
</script>