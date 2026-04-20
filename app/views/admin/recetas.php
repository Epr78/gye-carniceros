<div class="admin-page">
    <div class="admin-block">

        <!-- HEADER -->
        <div class="admin-header">
            <h1 class="admin-title">Recetas</h1>

            <a href="<?php echo BASE_URL; ?>/admin.php?route=receta-crear" class="btn-new">
                + Crear nueva receta
            </a>
        </div>

        <?php if (empty($recetas)): ?>
            <p>No hay recetas registradas.</p>
        <?php else: ?>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Slug</th>
                            <th>Activa</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recetas as $receta): ?>
                            <tr>
                                <td><?php echo (int)$receta['id']; ?></td>
                                <td><?php echo htmlspecialchars($receta['titulo']); ?></td>
                                <td><?php echo htmlspecialchars($receta['slug']); ?></td>
                                <td><?php echo (int)$receta['activa'] === 1 ? 'Sí' : 'No'; ?></td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/admin.php?route=receta-editar&id=<?php echo (int)$receta['id']; ?>">
                                        Editar
                                    </a>
                                    |
                                    <a href="<?php echo BASE_URL; ?>/admin.php?route=receta-toggle&id=<?php echo (int)$receta['id']; ?>">
                                        <?php echo (int)$receta['activa'] === 1 ? 'Desactivar' : 'Activar'; ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php endif; ?>
        <p class="back-link">
            <a href="<?php echo BASE_URL; ?>/admin.php?route=dashboard">
                ← Volver al dashboard
            </a>
        </p>
    </div>
</div>