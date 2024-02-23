<?php

    include 'conexion_be.php';

    $nombre_completo = $_POST['nombre_completo'];
    $correo = $_POST['correo'];
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    //encriptamiento hash
    
    $contrasena = hash('sha512', $contrasena);

    $query = "INSERT INTO usuarios(nombre_completo, correo, usuario, contrasena) 
            VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena')";

    //Verificacion de correo en la bd
    $consulta = "SELECT * FROM usuarios WHERE correo = '$correo' "; 
    $verificar_correo = mysqli_query($conexion, $consulta); 

    if(mysqli_num_rows($verificar_correo) > 0){
        echo '
            <script>
                alert("Este correo ya está registrado, intenta con uno diferente");
                window.location = "../index.php";
            </script>
        ';
        exit(0);
        mysqli_close($conexion);
    }

    if(!filter_var($correo, FILTER_VALIDATE_EMAIL)){
        echo '
        <script>
            alert("Por favor ingresa un correo válido");
            window.location = "../index.php";
        </script>
        ';
        exit();
        mysqli_close($conexion);
    }

    //Verificacion de usuario en bd
    $consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' "; 
    $verificar_usuario= mysqli_query($conexion, $consulta); 

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '
            <script>
                alert("Este usuario ya está registrado, intenta con uno diferente");
                window.location = "../index.php";
            </script>
        ';
        exit();
        mysqli_close($conexion);
    }

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario creado exitosamente");
                window.location = "../index.php";
            </script>
        ';
    }else{
        echo '
            <script>
                alert("Inténtalo de nuevo, usuario no almacenado");
                window.location = "../index.php";
            </script>
        ';
    }
    mysqli_close($conexion);
?>