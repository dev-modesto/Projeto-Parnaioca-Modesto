<?php
    include '../../include/navbar-lateral/navbar-lateral.php';
?>
<div class="conteudo">


    <!-- formulario envio cargo -->
    <form class="form-container" action="include/gFuncionario.php" method="post">
        <h1>Cadastrar Funcionario</h1>
        <span class="separador"></span>
        <div class="mb-3">
            <label class="font-1-s" for="nome">Nome completo</label>
            <input class="form-control" type="text" name="nome" required>
        </div>

        <div class="mb-3">
            <label class="font-1-s" for="cpf">CPF</label>
            <input class="form-control" type="text" name="cpf" required>
        </div>

        <div class="mb-3">
            <label class="font-1-s" for="telefone">Telefone</label>
            <input class="form-control" type="fone" name="telefone" required>
        </div>
        
        <div class="mb-3">
            <label for="id_cargo">Cargo</label>
                <select class="form-select" name="id_cargo" required>
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
        </div>

        <div class="form-container-button">
            <button class='btn btn-primary' type="submit">ADICIONAR</button>
        </div>

    </form>
    </div>
    <!-- fim formulario -->
</body>
</html>