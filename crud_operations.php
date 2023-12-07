<?php
include 'db.php';

if (!isset($_POST['operacion'])) {
    echo "No se especificó ninguna operación.";
    exit;
}

$operacion = $_POST['operacion'];

switch ($operacion) {
    case 'crear':
        if (!isset($_POST['nombre'], $_POST['tipo'], $_POST['edad'])) {
            echo "Todos los campos son necesarios para crear una nueva mascota.";
            exit;
        }
        
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $edad = $_POST['edad'];

        $sql = "INSERT INTO mascotas (nombre, tipo, edad) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([$nombre, $tipo, $edad]);
            echo "Mascota agregada con éxito.";
        } catch (PDOException $e) {
            echo "Error al agregar mascota: " . $e->getMessage();
        }
        break;

    case 'leer':
        $sql = "SELECT * FROM mascotas";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute();
            $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($mascotas);
        } catch (PDOException $e) {
            echo "Error al leer mascotas: " . $e->getMessage();
        }
        break;

    case 'actualizar':
        if (!isset($_POST['id'], $_POST['nombre'], $_POST['tipo'], $_POST['edad'])) {
            echo "Todos los campos son necesarios para actualizar la mascota.";
            exit;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $edad = $_POST['edad'];

        $sql = "UPDATE mascotas SET nombre = ?, tipo = ?, edad = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([$nombre, $tipo, $edad, $id]);
            echo "Mascota actualizada con éxito.";
        } catch (PDOException $e) {
            echo "Error al actualizar mascota: " . $e->getMessage();
        }
        break;

    case 'eliminar':
        if (!isset($_POST['id'])) {
            echo "Se requiere ID para eliminar la mascota.";
            exit;
        }
        
        $id = $_POST['id'];

        $sql = "DELETE FROM mascotas WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        try {
            $stmt->execute([$id]);
            echo "Mascota eliminada con éxito.";
        } catch (PDOException $e) {
            echo "Error al eliminar mascota: " . $e->getMessage();
        }
        break;

    default:
        echo "Operación no válida.";
        break;
}
?>
