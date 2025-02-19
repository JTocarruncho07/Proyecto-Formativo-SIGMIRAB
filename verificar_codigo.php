<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <h2>Verificar Codigo</h2>
    <form action="cambiar_contrasena.php" method="POST">
        <div class="form-group">
            <label for="codigo">Codigo de Verificacion:</label>
            <input type="text" name="codigo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Verificar</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>
