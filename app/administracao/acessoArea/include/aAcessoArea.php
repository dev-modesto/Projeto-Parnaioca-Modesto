<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id-funcionario'];

        $sac = isset($_POST['sac']) ? $_POST['sac'] : 0;
        $logistica = isset($_POST['logistica']) ? $_POST['logistica'] : 0;
        $administracao = isset($_POST['administracao']) ? $_POST['administracao'] : 0;

        $sql = 
            "UPDATE tbl_acesso_area SET sac=$sac, logistica=$logistica, administracao=$administracao WHERE id_funcionario = $id";

        if(mysqli_query($con, $sql)) {
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }
        mysqli_close($con);
    }

?>