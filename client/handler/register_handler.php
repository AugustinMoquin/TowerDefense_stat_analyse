<?php


session_start();


if (isset($_POST['forminscription'])) {
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['passwd'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $passwd = $_POST['passwd'];
        $passwd2 = $_POST['passwd2'];
        $passwdhash = sha1($_POST['passwd']);
        $passwd2hash = sha1($_POST['passwd2']);
        $usernamelength = strlen($username);
        $passwdlength = strlen($passwd);
        $test = Sécuritymdp($passwd, $passwdlength);
        if ($usernamelength <= 50) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $requser = $bdd->prepare("SELECT * FROM users WHERE user_name = ?");
                $requser->execute(array($username));
                $userexist = $requser->rowCount();
                if ($userexist == 0) {
                    if ($passwd == $passwd2) {
                        if ($passwdlength >= 3) {
                            if ($test == 4) {
                                $insertmbr = $bdd->prepare("INSERT INTO users(email,user_name,mdp) VALUES(?,?,?)");
                                $insertmbr->execute(array($email, $username, $passwdhash));
                                $message = "Votre compte a bien était créé";
                            } else {
                                $message = "Votre Mot de passe n'est pas assez sécurise , il faut des mins 
                                , des maj , des chiffres et un caractéres spécial";
                            }
                        } else {
                            $message = "Votre Mdp n'est pas assez long";
                        }

                    } else {
                        $message = "Password incorrect";
                    }
                } else {
                    $message = "User déja existant";
                }
            } else {
                $message = "Votre adresse mail n'est pas valide !";
            }
        } else {
            $message = "votre pseudo ne doit pas depasse 50 charactère";
        }
    } else {
        $message = "Tous les champs doivent etre compléter";
    }





}

if (isset($_POST['formconnexion'])) {
    if (!empty($_POST['username']) && !empty($_POST['passwd'])) {
        $username = htmlspecialchars($_POST['username']);
        $passwd = sha1($_POST['passwd']);

        $requser = $bdd->prepare("SELECT * FROM users WHERE user_name = ? && mdp= ?");
        $requser->execute(array($username, $passwd));
        $userexist = $requser->rowCount();

        if ($userexist >= 1) {
            $userinfo = $requser->fetch();
            $_SESSION['Id'] = $userinfo['ID_user'];
            $_SESSION['username'] = $userinfo['username'];
            $message = "tu es connécté";
            setcookie('username', $username, time() + 3600 * 24, '/', '', true, true);
            setcookie('password', $passwd, time() + 3600 * 24, '/', '', true, true);
            setcookie('id', $userinfo['ID_user'], time() + 3600 * 24, '/', '', true, true);
            header("Location: ../pages/user/user_profile.php");
        } else {
            $message = "ce profil n'éxiste pas";
        }
    } else {
        $message = "Tous les champs doivent etre compléter";
    }

}

function Sécuritymdp($passwd, $passwdlength): int
{
    $security = 0;
    $securitymaj = 0;
    $securityspe = 0;
    $securitynum = 0;
    for ($i = 0; $i < $passwdlength; $i++) {
        $lettre = $passwd[$i];
        if ($lettre >= 'a' && $lettre <= 'z') {
            $security = 0;
            $security = $security + 1;
        } elseif ($lettre >= 'A' && $lettre <= 'Z') {
            $securitymaj = 0;
            $securitymaj = $securitymaj + 1;
        } elseif ($lettre >= '0' && $lettre <= '9') {
            $securitynum = 0;
            $securitynum = $securitynum + 1;
        } else {
            $securityspe = 0;
            $securityspe = $securityspe + 1;
        }

        $final = $securityspe + $securitynum + $securitymaj + $security;
    }
    return $final;
}
?>