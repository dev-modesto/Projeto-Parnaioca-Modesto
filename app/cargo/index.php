<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <!-- formulario envio cargo -->
    <form action="include/gCargo.php" method="post">
        <label for="nome">Cargo</label><br>
        <input type="text" name="nome" required>
        <br>
    
        <label for="salario">Salário</label><br>
        <input type="number" name="salario" required>
        <br>
    
        <label for="id_setor">Setor</label><br>
        <select name="id_setor" required>
            <?php
                include '../../config/conexao.php';
                $query = "SELECT id_setor, nome_setor FROM tbl_setor";
                $result = mysqli_query($con, $query);
    
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id_setor'] . "'>" . $row['nome_setor'] . "</option>";
                }
                mysqli_close($con);
            ?>
        </select>
        <br>
    
        <button type="submit">Enviar</button>
    </form>
    
    <!-- fim formulario -->
</body>
</html>