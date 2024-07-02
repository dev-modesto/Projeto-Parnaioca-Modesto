<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';

    if(isset($_POST['cargo'])){
        
        $cargo = trim($_POST['cargo']);
        $salario = trim($_POST['salario']);
        $idSetor = $_POST['idSetor'];
        $salarioConvertido = converterMonetario($salario);

        $stmt = mysqli_prepare($con, "INSERT INTO tbl_cargo(id_cargo, nome_cargo, salario, id_setor) VALUES (NULL, ?, ?, ?)");

        mysqli_stmt_bind_param($stmt, 'sdi',$cargo,$salarioConvertido,$idSetor);

        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>
