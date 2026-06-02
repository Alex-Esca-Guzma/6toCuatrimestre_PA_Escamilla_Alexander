<?php
// Modificado por Alex Escamilla

    require_once ("../config/connection.php");
    require_once ("../includes/header.php")
?>

<div class="page-header">
    <h1><i class="fas fa-plus-circle"></i> Nuevo Usuario </h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <form action="save.php" method="POST">
        <div class="form-group">
            <label><i class="fas fa-user"></i> Nombre </label>
            <input type="text" name="nombre" placeholder="Ej: Alex" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-user"></i> Apellido </label>
            <input type="text" name="apellido" placeholder="Ej: Escamilla" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Correo </label>
            <input type="email" name=" correo" placeholder="Ej: arroyo123@gmail.com" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Teléfono </label>
            <input type="text" name="telefono" placeholder="Ej: 9813024313" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Contraseña </label>
            <input type="password" name="contrasena" placeholder="Ej: al4n_23@at" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Rol </label>
            <select name="id_rol" required>
                <option value="1">Administrador</option>
                <option value="2">Bibliotecario</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<?php include_once "../includes/footer.php"; ?>