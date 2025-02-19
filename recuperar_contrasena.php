<?php include 'templates/header.php'; ?>

<div class="container mt-5">
    <h2>Recuperar Contrasena</h2>
    <form action="procesar_recuperacion.php" method="POST">
        <div class="form-group">
            <label for="correo">Correo:</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="metodo">Metodo de Recuperacion:</label>
            <select name="metodo" class="form-control" required>
                <option value="correo">Correo</option>
                <option value="whatsapp">WhatsApp</option>
                <option value="mensaje">Mensaje de Texto</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Enviar Codigo</button>
    </form>
</div>

<?php include 'templates/footer.php'; ?>

