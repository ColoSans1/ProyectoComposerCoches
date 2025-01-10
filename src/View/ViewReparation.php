<?php if (!empty($reparation) && is_array($reparation)): ?>
    <!-- Mostrar detalles de la reparación -->
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white text-center">
                        <h2 class="mb-0">Reparation Details</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <tbody>
                                <tr>
                                    <th scope="row" class="text-end">Reparation ID:</th>
                                    <td><?= htmlspecialchars($reparation['id_reparacion'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Workshop ID:</th>
                                    <td><?= htmlspecialchars($reparation['id_taller'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">License Plate:</th>
                                    <td><?= htmlspecialchars($reparation['matricula_vehiculo'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Workshop Name:</th>
                                    <td><?= htmlspecialchars($reparation['nombre_taller'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Register Date:</th>
                                    <td><?= htmlspecialchars($reparation['fecha_registro'] ?? 'N/A') ?></td>
                                </tr>
                                <tr>
                                <tr>
    <th scope="row" class="text-end">Photo:</th>
    <td>
        <?php
        if (!empty($reparation['foto_vehiculo'])) {
            echo '<img src="data:image/jpeg;base64,' . base64_encode($reparation['foto_vehiculo']) . '" alt="Vehicle Photo" class="img-fluid" />';
        } else {
            echo 'No photo available';
        }
        ?>
    </td>
</tr>


                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning text-center mt-5">No reparation data found. Please try again.</div>
<?php endif; ?>
