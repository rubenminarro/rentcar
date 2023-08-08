<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"> Lista de Conductores</h4>
            </div>
			<div class="card-body">
				<div id="alerts"></div>
                <div class="table-responsive">
                    <table id="table-lista-conductores" class="table">
                        <thead class="text-primary">
                            <th class="text-center">Acciones</th>
                            <th>Nombre Completo</th>
                            <th>C.I.</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Historial</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="historialConductorModal" tabindex="-1" role="dialog" aria-labelledby="historialConductorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="historialConductorModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="agregarHistorialConductorModal" tabindex="-1" role="dialog" aria-labelledby="agregarHistorialConductorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarHistorialConductorModalLabel">Agregar historial al conductor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form-agregar-historial-conductor">
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="submit" id="btn-guardar-historial-conductor" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>

    $(document).ready(function () {
      
  		cargarListaConductores();

  		$("#form-agregar-historial-conductor").submit(function(e){
  			
        e.preventDefault();
        guardarHistorialConductor();
  			
  		});

    });

</script>