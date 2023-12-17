<?php
    require_once("connect.php");

    session_start();
    if(isset($_SESSION['lietotajvards']) && isset($_SESSION['ID']))
        header("Location: ../index.php");

    if (isset($_POST['RegPoga'])){

        $atkartots_epasts = $_POST['atkartots_epasts'];
        $epasts = $_POST['epasts'];
        $lietotajvards = $_POST['lietotajvards'];
        $parole = $_POST['parole'];
        $atkartota_parole = $_POST['atkartota_parole'];
    }

    if ($epasts == "" && $atkartots_epasts == "" && $lietotajvards == "" && $parole == "" && $atkartota_parole == ""){
        $_SESSION["error"] = 'Jūs atstājāt tukšu lauku';
        header("Location: ../LogInPage.php");
        exit();
    }

    if (!($parole === $atkartota_parole)) {
        $_SESSION["error"] = 'Jūsu parole nesakrīt!';
        header("Location: ../LogInPage.php");
        exit();
    }
    
    if (!($epasts === $atkartots_epasts)) {
        $_SESSION["error"] = 'Jūsu e-pasta adrese nesakrīt! ' . $epasts . "1" . $atkartots_epasts . "2" . $parole . "3" . $atkartota_parole . "4" . $lietotajvards;
        header("Location: ../LogInPage.php");
        exit();
    }
                
    if (!filter_var($epasts, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["error"] = 'Jūs neesat ievadijuši pareizu e-pastu!';
        header("Location: ../LogInPage.php");
        exit();
    }
                    
    if ( strlen($parole) < 8 && strpbrk($parole, "@!#$.,:;()") == false) {
        $_SESSION["error"] = 'Jūsu parole ir pārāk vāja. Ievadiet paroli vismaz 8 simbolus garu, kas iekļauj Lielo burtu un simbolu!';
        header("Location: ../LogInPage.php");
        exit();
    }

    $query = mysqli_query($conn, "SELECT * FROM user WHERE Username='{$lietotajvards}' OR Email='{$epasts}'");
    if (mysqli_num_rows($query) == 0) {
        $parole = password_hash($parole, PASSWORD_DEFAULT);
        $admin = 0;

        mysqli_query($conn, "INSERT INTO user (`Email`, `Username`, `Password`, `Admin`) VALUES (
            '$epasts', '$lietotajvards', '$parole', '$admin'
        )");
                                    
        $query = mysqli_query($conn, "SELECT * FROM user WHERE Username='{$lietotajvards}'");
        if (mysqli_num_rows($query) == 1) {
            $_SESSION['error'] = 'Veiksmīgi izveidots konts';
            $_SESSION["change"] = 
            'document.getElementById("registracija").style.display="none"; 
            document.getElementById("pieslegties").style.display="block";';
            header("Location: ../LogInPage.php");
            exit();
        }
        else
            $_SESSION["error"] = 'Kļūme notika veidojot jūsu profilu.';
            header("Location: ../LogInPage.php");
            exit();

        header("Location: ../LogInPage.php");
    }
    else
        $_SESSION["error"] = 'Šis lietotājvārds / Epasts tiek jau izmantots. Izmantojiet citu.';
        header("Location: ../LogInPage.php");
        exit();
?>