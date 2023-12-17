<?php
    require_once("connect.php");

    $_SESSION["change"] = 
            'document.getElementById("registracija").style.display="none"; 
            document.getElementById("pieslegties").style.display="block";';

    if(isset($_POST['Pieslegties'])){
        $lietotajvards = $_POST['lietotajvards'];
        $parole = $_POST['parole'];
    }

    if($lietotajvards == "" && $parole == "") {
        $_SESSION["change"];
        $_SESSION['error'] = "Tukšs lauks atstāts!";
        header("Location: ../LogInPage.php");
        exit();
    }

    if ($query = $conn->prepare("SELECT UserID, Password FROM user WHERE Username='{$lietotajvards}';")) {
        $query->execute();
        $query->store_result();
        if ($query->num_rows > 0) {
            $ID = 0;
            $passHash = "";
            $query->bind_result($ID, $passHash);
            $query->fetch();
            if(password_verify($parole, $passHash)) {
                $_SESSION['ID'] = $ID;
                header("Location: ../index.php");
                exit();
            }
            else {
                $_SESSION["change"];
                $_SESSION['error'] = "Nepareizi ievadīts e-pasts vai parole!";
                header("Location: ../LogInPage.php");
                exit();
            }
        }
        else {
            $_SESSION["change"];
            $_SESSION['error'] = "Nepareizi ievadīts e-pasts vai parole!";
            header("Location: ../LogInPage.php");
            exit();
        }
    }
    
    
?>