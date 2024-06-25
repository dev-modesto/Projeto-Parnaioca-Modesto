<?php
    include __DIR__  . '/../../../config/conexao.php';
    
    if(isset($_GET['id'])){

        $id = $_GET['id'];
        echo $id;

        $sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = " . $id;

        $consulta = mysqli_query($con,$sql);
        $array = mysqli_fetch_array($consulta);

        $minhaVariavel = 'trouxe';
        header('location: ../index.php?id='.$id);
        
        // if($array = mysqli_fetch_array($consulta)){
        //     echo "<pre>";
        //     print_r($array);
        // }

    };

?>