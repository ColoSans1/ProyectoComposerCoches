<?php
if (isset($reparation)) {
    ?>
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
                                    <td><?= htmlspecialchars($reparation['id_reparation']) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Workshop ID:</th>
                                    <td><?= htmlspecialchars($reparation['id_workshop']) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">License Plate:</th>
                                    <td><?= htmlspecialchars($reparation['license_plate']) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Workshop Name:</th>
                                    <td><?= htmlspecialchars($reparation['name_workshop']) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Register Date:</th>
                                    <td><?= htmlspecialchars($reparation['register_date']) ?></td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Photo:</th>
                                    <td>
                                        <img src="<?= htmlspecialchars($reparation['photo_url']) ?>" alt="Vehicle Photo" class="img-fluid rounded" style="max-width: 300px;">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row" class="text-end">Watermark Text:</th>
                                    <td><?= htmlspecialchars($reparation['watermark_text']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer text-center">
                        <a href="index.php" class="btn btn-secondary btn-lg">Back to Query</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
} else {
    echo "<div class='alert alert-warning text-center mt-5'>No reparation data found. Please try again.</div>";
}
?>
