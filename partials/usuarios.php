<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Lista de Usuarios</h4>
            </div>
			<div class="card-body">
				
                <div class="table-responsive">
                    <table id="table-lista-usuarios" class="table">
                      <thead class="text-primary">
                          <th class="text-center">Acciones</th>
                          <th>Nombre Completo</th>
                          <th>C.I.</th>
                          <th>Usuario</th>
                          <th class="text-center">Estado</th>
                          <th>Creado por</th>
                          <th>Fecha creación</th>
                      </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
      cargarListaUsuarios();
    });

</script>