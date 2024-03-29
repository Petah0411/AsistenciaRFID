<?php  
//Connect to database
require'connectDB.php';

//Add user
if (isset($_POST['Add'])) {
     
    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];
    
    //check if there any selected user
    $sql = "SELECT add_card FROM users WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {

                if (!empty($Uname) && !empty($Number) && !empty($Email)) {
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=? AND id NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }
                            $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, user_date=CURDATE(), device_uid=?, device_dep=?, add_card=1 WHERE id=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error_select_Fingerprint";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "sdssssi", $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                mysqli_stmt_execute($result);

                                echo 1;
                                exit();
                            }
                        }
                        else {
                            echo "El número de serie ya no existe!";
                            exit();
                        }
                    }
                }
                else{
                    echo "Campos Vacíos";
                    exit();
                }
            }
            else{
                echo "Este usuario ya existe";
                exit();
            }    
        }
        else {
            echo "No hay tarjeta seleccionada!";
            exit();
        }
    }
}
// Update an existance user 
if (isset($_POST['Update'])) {

    $user_id = $_POST['user_id'];
    $Uname = $_POST['name'];
    $Number = $_POST['number'];
    $Email = $_POST['email'];
    $dev_uid = $_POST['dev_uid'];
    $Gender = $_POST['gender'];

    //check if there any selected user
    $sql = "SELECT add_card FROM users WHERE id=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
      echo "SQL_Error";
      exit();
    }
    else{
        mysqli_stmt_bind_param($result, "i", $user_id);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)) {

            if ($row['add_card'] == 0) {
                echo "Primero, necesitas añadir el usuario!";
                exit();
            }
            else{
                if (empty($Uname) && empty($Number) && empty($Email)) {
                    echo "Campos vacíos";
                    exit();
                }
                else{
                    //check if there any user had already the Serial Number
                    $sql = "SELECT serialnumber FROM users WHERE serialnumber=? AND id NOT like ?";
                    $result = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($result, $sql)) {
                        echo "SQL_Error";
                        exit();
                    }
                    else{
                        mysqli_stmt_bind_param($result, "di", $Number, $user_id);
                        mysqli_stmt_execute($result);
                        $resultl = mysqli_stmt_get_result($result);
                        if (!$row = mysqli_fetch_assoc($resultl)) {
                            $sql = "SELECT device_dep FROM devices WHERE device_uid=?";
                            $result = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($result, $sql)) {
                                echo "SQL_Error";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($result, "s", $dev_uid);
                                mysqli_stmt_execute($result);
                                $resultl = mysqli_stmt_get_result($result);
                                if ($row = mysqli_fetch_assoc($resultl)) {
                                    $dev_name = $row['device_dep'];
                                }
                                else{
                                    $dev_name = "All";
                                }
                            }
                                    
                            if (!empty($Uname) && !empty($Email)) {

                                $sql="UPDATE users SET username=?, serialnumber=?, gender=?, email=?, device_uid=?, device_dep=? WHERE id=?";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql)) {
                                    echo "SQL_Error_seleccionar_tarjeta";
                                    exit();
                                }
                                else{
                                    mysqli_stmt_bind_param($result, "sdssssi", $Uname, $Number, $Gender, $Email, $dev_uid, $dev_name, $user_id );
                                    mysqli_stmt_execute($result);

                                    echo 1;
                                    exit();
                                }
                            }
                        }
                        else {
                            echo "El número de serie ya está tomado!";
                            exit();
                        }
                    }
                }
            }    
        }
        else {
            echo "No hay usuario seleccionado para ser actualizado!";
            exit();
        }
    }
}
// select fingerprint 
if (isset($_GET['select'])) {

    $card_uid = $_GET['card_uid'];

    $sql = "SELECT * FROM users WHERE card_uid=?";
    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select";
        exit();
    }
    else{
        mysqli_stmt_bind_param($result, "s", $card_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        // echo "User Fingerprint selected";
        // exit();
        header('Content-Type: application/json');
        $data = array();
        if ($row = mysqli_fetch_assoc($resultl)) {
            foreach ($resultl as $row) {
                $data[] = $row;
            }
        }
        $resultl->close();
        $conn->close();
        print json_encode($data);
    } 
}
// delete user 
if (isset($_POST['delete'])) {

    $user_id = $_POST['user_id'];

    if (empty($user_id)) {
        echo "No hay usuario seleccionado para ser eliminado!";
        exit();
    } else {
        $sql = "DELETE FROM users WHERE id=?";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo "SQL_Error_delete";
            exit();
        }
        else{
            mysqli_stmt_bind_param($result, "i", $user_id);
            mysqli_stmt_execute($result);
            echo 1;
            exit();
        }
    }
}
?>