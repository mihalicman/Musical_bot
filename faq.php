<?php
session_start();
require_once "vendor/connect.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/nav-bar.css">
    <link rel="stylesheet" href="./assets/css/footer.css">
    <link rel="stylesheet" href="./assets/css/faq.css">
    <link href="http://fonts.cdnfonts.com/css/roboto" rel="stylesheet">
    <title>Lietotāja instrukcija</title>
</head>
<body>
    <div class="wrapper">
        
    <?php include 'assets/views/nav-bar.php';?>

        <div class="main">
            <div class="user_instruction">
                <h1 style="margin-left: 24px; margin-bottom:10px;">Lietotājs</h1>
                <hr style="height:1px; background-color:white; margin-bottom:20px; margin-left:15px; margin-right:7px; margin-top:0px;">
                <p style="margin-top: -10px; margin-left: 24px;">Dotajā mājaslapā lietotājs sākumā varēs tikai apskatīt, meklēt grāmatas pēc nosaukuma vai kategorijām, kā arī ir iespēja aizpildīt kontaktformu,
                    lai sazinātos ar administrāciju. Lai parādītos iespēja lasīt, pievienot un vērtēt grāmatas, lietotājam vajadzēs piereģistrēties. Reģistrētajam 
                    lietotājam parādās daudz citas iespējas, piemēram, kā lasīt, pievienot, vērtēt grāmatas. Savā profilā lietotājs varēs meklēt sev pievienotās
                    grāmatās vai arī dzēst tās no sava profila.
                </p>
                <ul>
                    <li>
                    <h3>Meklēšanas josla</h3> <br>
                        <p>
                        Lietotājs var meklēt grāmatas pēc nosaukuma vai izvēloties atbilstošo kategoriju - parādīsies grāmatu grupa.
                        </p>
                    </li>
                    <li>
                    <h3>Reģistrācija</h3> <br>
                        <p>
                        Reģistrācija dod dažus priekšrocības pret lietotajiem kuri nereģistrējas, piemēram: <br>
                        1.	Grāmatu pievienošana izlasei. <br>
                        2.	Grāmatu vērtēšana. <br>
                        3.	Ir iespēja saglabāt grāmatas sev profilā un dzēst no tā. <br>
                        4.	Sazināšana ar administraciju(jāizpilda formu).
                        </p>
                    </li>
                    <li>
                    <h3>Grāmatas pievienošana</h3> <br>
                        <p>
                        Lietotājs var pievienot sev profilā grāmatas, kuri iepatikās viņam.
                        </p>
                    </li>
                    <li>
                    <h3>Papildinformācija</h3> <br>
                        <p>
                        Pašā apakšā ir pogas, kur var atrast blogu, cenas, informāciju un kontaktus.
                        </p>
                    </li>
                </ul>
            </div>
            <?php
            if (isset($_SESSION['user'])){
                $admin = $_SESSION['user']['admin'];
                if ($admin === '1') {
                    echo "
                    <div class='admin_instruction'>
                    <h1 style='margin-left: 24px; margin-bottom: 10px;'>Administrators</h1>
                    <hr style='height:1px; background-color:white; margin-bottom:20px; margin-left:15px; margin-right:7px; margin-top:0px;'>
                    <p style='margin-top: -10px; margin-left: 24px;'>Administratoram ir pieejamas visas iespējas, kas ir dotas reģistrētajam
                    lietotājam un pat vairāk. Administratoram vēl parādās iespēja pievienot, dzēst un rediģēt grāmatas, kā arī rediģēt, meklēt un dzēst lietotājus. Var
                    rediģēt/pievienot tādas opcijas grāmatām: nosaukums, autors, apraksts, bilde, kategorija un datums. Lietotājam var rediģēt tādas opcijas kā e-pastu,
                    lietotājvārdu un administratora tiesības. Dzēšot lietotāju vai grāmatu, tie arī izdzēsās pilnībā no datubāzes.
                    </p>
                    <ul>
                        <li>
                        <h3> Profila meklēšanas josla </h3> <br>
                            <p>
                            Ir iespēja meklēt lietotājus un grāmatas profilā pēc nosaukuma. Ievadot vismaz vienu burtu tiek izvadīti visi rezultāti ar meklēto burtu nosaukumā, ja ievadīt divus burtus tiek izvadīti nosaukumi ar tiem diviem burtiem nosaukumā u.t.t.
                            </p>
                        </li>
                        <li>
                        <h3> Grāmatas rediģēšana </h3> <br>
                            <p>
                            Administrators var rediģēt grāmatu datus, ja ir parādījusies kaut kāda kļūda, jeb cits iemesls. Beidzot reģistrāciju grāmatas dati atjaunojās datubāzē. Rediģējot grāmatu, administratoram ir iespēja izmainīt: <br>
                            1.	Grāmatas nosaukumu <br>
                            2.	Grāmatas autoru <br>
                            3.	Grāmatas aprakstu/īsu stāstu par grāmatu <br>
                            4.	Bildi grāmatas vākam <br>
                            5.	Kategoriju kura pieder dotai grāmatai <br>
                            6.	Datumu kurā grāmata tika pievienota mājaslapai
                            </p>
                        </li>
                        <li>
                        <h3> Lietotāja rediģēšana </h3> <br>
                            <p>
                            Administrators var rediģēt lietotāja datus, ja lietotājs ir aizrakstījis vēstuli šajā sakarā, jeb lietotāja vārds vai e-pasts satur necenzētu leksiku, jeb, ja rodas iemesls iedot piekļuvi pie administratora tiesībām. Beidzot reģistrāciju lietotāja dati atjaunojās datubāzē. Rediģējot lietotāju, administratoram ir iespēja izmainīt: <br>
                            1.	Lietotāja profila vārdu <br>
                            2.	Lietotāja e-pastu <br>
                            3.	Piekļuvi pie administratora tiesībām
                            </p>
                        </li>
                        <li>
                        <h3> Grāmatas/lietotāja dzēšana </h3> <br>
                            <p>
                            Dota iespēja izdzēst lietotāju vai arī grāmatu no mājaslapas datubāzes. Grāmatu var izdzēst, ja grāmatas autors nevēlas redzēt savu grāmatu mūsu mājaslapā. Lietotāju var izdzēst, ja viņš pārkāpj lietošanas noteikumus vairākas reizes.
                            </p>
                        </li>
                        <li>
                        <h3> Grāmatas pievienošana </h3> <br>
                            <p>
                            Administrators var pēc izvēles pievienot jebkuru jaunu grāmatu mājaslapā. Pēc veiksmīgas pievienošanas, lietotājam uzreiz parādīsies iespēja to grāmatu sākt lasīt. Lai pievienotu grāmatu vajag pievienot šādus datus: <br>
                            1.	Grāmatas nosaukumu <br>
                            2.	Grāmatas autoru <br>
                            3.	Grāmatas aprakstu/īsu stāstu par grāmatu <br>
                            4.	Bildi grāmatas vākam <br>
                            5.	Kategoriju kura pieder dotai grāmatai <br>
                            6.	Datumu kurā grāmata tika pievienota mājaslapai
                            </p>
                        </li>
                    </ul>
                </div>
                ";
                } else {
                    echo '';
                }
            }
            ?>
            

        </div>
    
    <?php include 'assets/views/footer.html'?>
    </div>
</body>
</html>