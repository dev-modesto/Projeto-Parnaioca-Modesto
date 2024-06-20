<?php
    include '../../include/navbar-lateral/navbar-lateral.php';
?>

    <section class="formulario-gravar-setor">
        <!-- formulario envio setor -->
         <h1>Adicionar setor</h1>
        <form class="form" action="include/gSetor.php" method="post">
            <div class="mb-3">
                <label for="setor">Setor</label>
                <input class="form-control" type="text" name="setor" required>
            </div>
            <div class="form-container-button">
                <button class='botao' type="submit">Adicionar</button>
            </div>
        </form>
        <!-- fim formulario -->


</body>
</html>