<?php
    include '../../include/navbar-lateral/navbar-lateral.php';
?>

    <section class="formulario-gravar-setor">
        <!-- formulario envio setor -->
        <h1>Adicionar setor</h1>
        <span class="separador"></span>
        <form action="include/gSetor.php" method="post">
            <div class="mb-3">
                <label class="font-1-s" for="form-label setor">Setor</label>
                <input class="form-control" type="text" name="setor" required>
            </div>
            <div class="form-container-button">
                <button class='btn btn-primary' type="submit">ADICIONAR</button>
            </div>
        </form>
        <!-- fim formulario -->
    </section>

</body>
</html>