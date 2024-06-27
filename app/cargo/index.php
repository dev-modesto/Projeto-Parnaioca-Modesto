<?php
    include '../../include/navbar-lateral/navbar-lateral.php';
?>
    <section class="form-container">
        <!-- formulario envio cargo -->
        <form action="include/gCargo.php" method="post">
            <h1>Adicionar cargo</h1>
            <span class="separador"></span>
            <div class="mb-3">
                <label class="font-1-s" for="form-label nome">Cargo</label>
                <input class="form-control" type="text" name="nome" required>
            </div>

            <div class="mb-3">
                <label class="font-1-s" for="form-label salario">Salário</label>
                <input class="form-control" type="number" name="salario" required>
            </div>
            
            <label for="id_setor">Setor</label>
            <select class="form-select" name="id_setor" required>
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
            <div class="form-container-button">
                <button class='btn btn-primary' type="submit">ADICIONAR</button>
            </div>
        </form>
</section>