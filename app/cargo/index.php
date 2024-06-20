<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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

    <form class='setor-formulario'>
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>


    
    <!-- fim formulario -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>