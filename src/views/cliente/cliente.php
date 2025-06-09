<?php use RapiExpress\Lang; ?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Basic Page Info -->
		<meta charset="utf-8" />
		<title>RapiExpress</title>
		<link rel="icon" href="assets\img\logo-rapi.ico" type="image/x-icon">

		 

		<!-- Mobile Specific Metas -->
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, maximum-scale=1"
		/>

	
		

		
		 
	</head>
	<body>
		 	<?php include 'src\views\layout\barras.php'; ?>

		<div class="mobile-menu-overlay"></div>

		<div class="main-container">
			
				
					<div class="page-header">
						<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="title">
									<h4><?= Lang::get('clients') ?></h4>
								</div>
								<nav aria-label="breadcrumb" role="navigation">
									<ol class="breadcrumb">
										<li class="breadcrumb-item">
											<a href="index.php?c=dashboard&a=index">RapiExpress</a>
										</li>
										 <li class="breadcrumb-item active" aria-current="page"><?= Lang::get('clients') ?></li>
									</ol>
								</nav>
							</div>
						</div>
					</div>
							
		
		

<div class="card-box mb-30">
    <div class="pd-30">
        <h4 class="text-blue h4"><?= Lang::get('client_list') ?></h4>
       <?php if (isset($_SESSION['mensaje']) && isset($_SESSION['tipo_mensaje'])): ?>
    <div class="alert alert-<?php echo $_SESSION['tipo_mensaje'] === 'success' ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['mensaje']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php 
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
    ?>
<?php endif; ?>

        <div class="pull-right">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#clienteModal">
    <i class="fa fa-user-plus"></i> <?= Lang::get('add_client') ?>
</button>
        </div>
    </div>
    <div class="pb-30">
        <table class="data-table table stripe hover nowrap" id="clientesTable">
            <thead>
               <tr>
        <th><?= Lang::get('id_number') ?></th>
        <th><?= Lang::get('full_name') ?></th>
        <th><?= Lang::get('phone') ?></th>
        <th><?= Lang::get('email') ?></th>
        <th><?= Lang::get('status') ?></th>
        <th><?= Lang::get('registration_date') ?></th>
        <th class="datatable-nosort"><?= Lang::get('actions') ?></th>
    </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cliente): ?>
                <tr>
                    <td><?= htmlspecialchars($cliente['cedula']) ?></td>
                    <td class="table-plus"><?= htmlspecialchars($cliente['nombre'] . ' ' . $cliente['apellido']) ?></td>
                    <td><?= htmlspecialchars($cliente['telefono']) ?></td>
                    <td><?= htmlspecialchars($cliente['email']) ?></td>
                    <td>
                        <span class="badge badge-<?= $cliente['estado'] == 'activo' ? 'success' : 'danger' ?>">
                            <?= ucfirst($cliente['estado']) ?>
                        </span>
                    </td>
                    <td><?= date('d/m/Y', strtotime($cliente['fecha_registro'])) ?></td>
                   <td>
    <div class="dropdown">
        <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
            <i class="dw dw-more"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#view-cliente-modal-<?= $cliente['id_cliente'] ?>">
                <i class="dw dw-eye"></i> Ver Detalles
            </a>
           <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit-cliente-modal-<?= $cliente['id_cliente'] ?>">
    <i class="dw dw-edit2"></i> Editar
</a>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete-cliente-modal" 
               onclick="document.getElementById('delete_cliente_id').value = <?= $cliente['id_cliente'] ?>">
                <i class="dw dw-delete-3"></i> <?= $cliente['estado'] == 'activo' ? 'Eliminar' : 'Eliminar' ?>
            </a>
        </div>
    </div>
</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para agregar cliente -->
<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalLabel">Registrar Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="index.php?c=cliente&a=registrar">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Cédula</label>
                                <input type="text" pattern="\d{6,10}" class="form-control" name="cedula" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control" name="estado" required>
                                    <option value="activo" selected>Activo</option>
                                    <option value="inactivo">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombres</label>
                                <input type="text" class="form-control" name="nombre" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Apellidos</label>
                                <input type="text" class="form-control" name="apellido" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" name="telefono" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <textarea class="form-control" name="direccion" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalles del Cliente (Solo lectura) -->
<?php foreach ($clientes as $cli): ?>
<div class="modal fade bs-example-modal-lg" id="view-cliente-modal-<?= $cli['id_cliente'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= Lang::get('client_details') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('id_card') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['cedula']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('status') ?></label>
                            <input type="text" class="form-control" value="<?= ucfirst(Lang::get($cli['estado'])) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('first_name') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['nombre']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('last_name') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['apellido']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('email') ?></label>
                            <input type="email" class="form-control" value="<?= htmlspecialchars($cli['email']) ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('phone') ?></label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($cli['telefono']) ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><?= Lang::get('address') ?></label>
                            <textarea class="form-control" rows="3" readonly><?= htmlspecialchars($cli['direccion']) ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><?= Lang::get('registration_date') ?></label>
                            <input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($cli['fecha_registro'])) ?>" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Lang::get('close') ?></button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>


<!-- Modal para Editar Cliente -->
<?php foreach ($clientes as $cli): ?>
<div class="modal fade" id="edit-cliente-modal-<?= $cli['id_cliente'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?= Lang::get('edit_client') ?></h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <form method="POST" action="index.php?c=cliente&a=editar">
                <div class="modal-body">
                    <input type="hidden" name="id_cliente" value="<?= $cli['id_cliente'] ?>">
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= Lang::get('id_card') ?></label>
                            <input type="text" class="form-control" name="cedula" value="<?= htmlspecialchars($cli['cedula']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= Lang::get('status') ?></label>
                            <select class="form-control" name="estado" required>
                                <option value="activo" <?= $cli['estado'] == 'activo' ? 'selected' : '' ?>><?= Lang::get('active') ?></option>
                                <option value="inactivo" <?= $cli['estado'] == 'inactivo' ? 'selected' : '' ?>><?= Lang::get('inactive') ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= Lang::get('first_name') ?></label>
                            <input type="text" class="form-control" name="nombre" value="<?= htmlspecialchars($cli['nombre']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= Lang::get('last_name') ?></label>
                            <input type="text" class="form-control" name="apellido" value="<?= htmlspecialchars($cli['apellido']) ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label><?= Lang::get('email') ?></label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($cli['email']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label><?= Lang::get('phone') ?></label>
                            <input type="text" class="form-control" name="telefono" value="<?= htmlspecialchars($cli['telefono']) ?>" required>
                        </div>
                    </div>
                    <label><?= Lang::get('address') ?></label>
                    <textarea class="form-control" name="direccion" rows="3" required><?= htmlspecialchars($cli['direccion']) ?></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Lang::get('cancel') ?></button>
                    <button type="submit" class="btn btn-primary"><?= Lang::get('save_changes') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>


<!-- Modal para Eliminar Cliente -->
<div class="modal fade" id="delete-cliente-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content text-center p-4">
			<div class="modal-body">
				<i class="bi bi-exclamation-triangle-fill text-danger mb-3" style="font-size: 3rem;"></i>
			<h4 class="mb-20 font-weight-bold text-danger"><?= Lang::get('delete_client') ?></h4>
				<p class="mb-30 text-muted"><?= Lang::get('delete_warning') ?></p>

				<form method="POST" action="index.php?c=cliente&a=eliminar">
					<input type="hidden" name="id" id="delete_cliente_id">
					<div class="row justify-content-center gap-2" style="max-width: 200px; margin: 0 auto;">
						<div class="col-6 px-1">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Lang::get('no') ?></button>
						</div>
						<div class="col-6 px-1">
							<button type="submit" class="btn btn-danger"><?= Lang::get('yes') ?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>










				
				<div class="footer-wrap pd-20 mb-20 card-box">
					RapiExpress © 2025 - Sistema de Gestión de Paquetes				
				</div>
			</div>
		</div>
 

	 
	
		 
	</body>
</html>
