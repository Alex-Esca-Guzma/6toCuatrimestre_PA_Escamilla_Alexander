<?php
// Modificado por Alex Escamilla

    require_once("../config/connection.php");
    require_once("../includes/header.php");

    $id = intval($_GET["id"] ?? 0);
    
    if ($id > 0) {
        $stmt = $conn->prepare("SELECT id, nombre, apellido, telefono, correo, password FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado=$stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $stmt->close();
        $conn->close();
    } else {
        header("Location: index.php?error=" . urlencode("ID inválido"));
        exit;
    }
?>

<div class="page-header">
    <h1><i class="fas fa-user-edit"></i> Editar Usuario</h1>
    <a href="index.php" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <form action="update.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario["id"] ?? $id ?>">

        <div class="form-group">
            <label><i class="fas fa-user"></i> Nombre </label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($usuario["nombre"] ?? "") ?>" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-user"></i> Apellido </label>
            <input type="text" name="apellido" value="<?= htmlspecialchars($usuario["apellido"] ?? "") ?>" required>
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Telefono </label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($usuario["telefono"] ?? "") ?>">
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Correo </label>
            <input type="email" name="correo" value="<?= $usuario["correo"] ?? "" ?>">
        </div>

        <div class="form-group">
            <label><i class="fas fa-tag"></i> Contrasena </label>
            <input type="password" name="contrasena" value="<?= $usuario["password"] ?? "" ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Actualizar
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<?php
    require_once("../includes/footer.php");
?>