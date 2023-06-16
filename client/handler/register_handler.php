<?
require $_SERVER['DOCUMENT_ROOT']."/towerdefense_stat_analyse/src/boostrap.php";
$conn = conn();
session_start();

if (isset($POST['register_form'])){
    if (!empty($POST['username']) && !empty($POST['email']) && !empty($POST['password']) && !empty($POST['password2'])){
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $passwd = $_POST['password'];
        $passwd2 = $_POST['password2'];
        $passwdhash = sha1($_POST['password']);
        $passwd2hash = sha1($_POST['password2']);
        $usernamelength = strlen($username);
        $passwdlength = strlen($password);
        $test=Validation($passwd,$passwdlength);
    //     if ($usernamelength <= 50) {
    //         if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $requser= $bdd->prepare("SELECT * FROM user WHERE username = ?");
    //             $requser->execute(array($username));
    //             $userexist = $requser->rowCount();
    //             if ($userexist==0) {
    //                 if ($passwd == $passwd2) {
    //                     if ($passwdlength >=3 ) {  
    //                         if ($test==4) {
    //                             $insertmbr = $bdd->prepare("INSERT INTO users(email,username,mdp) VALUES(?,?,?)");
    //                             $insertmbr->execute(array($email,$username,$passwdhash));
    //                             $message = "Votre compte a bien était créé";
    //                         }else {
    //                             $message = "Votre MDP doit contenir au moins une min, une Maj, 
    //                             un Chiffre et un caractère spécial";
    //                         }
    //                     }else {
    //                         $message = "Votre Mdp n'est pas assez long";
    //                     }
    //                 }else {
    //                     $message ="Password incorrect";
    //                 }
    //             }else {
    //                 $message ="User déja existant";
    //             }
    //         }else {
    //             $message = "Votre adresse mail n'est pas valide !";
    //         } 
    //     }else {
    //         $message = "votre pseudo ne doit pas depasse 50 charactère";
    //     }     
    // }else {
    //     $message ="Tous les champs doivent etre compléter";
    // }                
}



function Validation($passwd,$passwdlength) : bool{
    $security = 0;
    $securitymaj=0;
    $securityspe=0;
    $securitynum =0;
    for ($i = 0; $i < $passwdlength; $i++) {
        $lettre = $passwd[$i];
        if ($lettre>='a' && $lettre<='z') {
            $security = 0;
            $security =$security+1 ;
        }elseif ($lettre>='A' && $lettre <='Z') {
            $securitymaj=0;
            $securitymaj =$securitymaj+1 ;
        }elseif ($lettre>='0' && $lettre<='9') {
            $securitynum =0;
            $securitynum =$securitynum+1 ;
        }else {
            $securityspe=0;
            $securityspe =$securityspe+1 ;
        }
       
        $res = $securityspe+$securitynum+$securitymaj+$security;
    }
    if($res == 4){
        return true;
    }else{
        return false;
    }
}

?>