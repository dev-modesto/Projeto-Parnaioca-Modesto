<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <!-- formulario envio cargo -->
    <form action="include/gFuncionario.php" method="post">
        <label for="nome">Nome</label><br>
        <input type="text" name="nome" required>
        <br>
    
        <label for="cpf">CPF</label><br>
        <input type="text" name="cpf" required>
        <br>

        <label for="telefone">Telefone</label><br>
        <input type="fone" name="telefone" required>
        <br>
    
        <label for="id_cargo">Cargo</label><br>
        <select name="id_cargo" required>
            <?php
                include '../../config/conexao.php';
                $query = "SELECT id_cargo, nome_cargo FROM tbl_cargo";
                $result = mysqli_query($con, $query);
    
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id_cargo'] . "'>" . $row['nome_cargo'] . "</option>";
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