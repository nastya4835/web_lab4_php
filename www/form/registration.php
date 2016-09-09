<?
  header('Content-Type: text/html; charset=utf-8');

  function checkEmail($mail) {
    if (strlen($mail)==0) return true;
    
    if (!preg_match("/^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i",$mail)) {
        return false;
      }
    return true;
  }

  // Показываем форму Авторизация
  $isLogin = false;
  // Показываем форму Регистрация
  $isRegister = false;
  // Показываем форму Восстановление пароля
  $isForgot = false;

  // Общая переменная для хранения email
  $email = '';
  // Флаг, указывающий на валидность email
  $emailIsValid = true;
  $loginIsValid = true;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['register_form'])) {
      $email = $_POST['reg_email'];
      $login = $_POST['reg_login'];
      $password = $_POST['reg_pass'];
      $repassword = $_POST['reg_repass'];

      $isRegister = true;
      echo $email . " " . $login . " " . $password . " " . $repassword;
    } else if (isset($_POST['login_form'])) {
      $login = $_POST['auth_login'];
      $password = $_POST['auth_pass'];

      $isLogin = true;
      echo $login . " " . $password;
    } else if (isset($_POST['forgot_form'])) {
      $email = $_POST['forgot_email'];

      $isForgot = true;
      echo $email;
    }

    $emailIsValid = checkEmail($email);
    $loginIsValid = strlen($login) >= 5;
    $passIsValid = strlen($password) >= 4 && $login != $password && ($isRegister ? $password == $repassword : true);
  } else {
    $isLogin = true;
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
	<meta charset="UTF-8">
	<title>Регистрация</title>
	<link rel='stylesheet prefetch' href="css/font-awesome.min.css" />
	<link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
  <link rel="stylesheet" href="css/styles.css" media="screen" type="text/css" />
</head>

<body>

<div class="box">
  <nav id="tabs" class="tabs">
    <a id="tabLogin" class=<? echo "'iconLogin " . ($isLogin ? "active" : "") . " blueBox'" ?> title="Войти"></a>
    <a id="tabRegister" class=<? echo "'iconRegister " . ($isRegister ? "active" : "") . " greenBox'" ?> title="Регистрация"></a>
    <a id="tabForgot" class=<? echo "'iconForgot " . ($isForgot ? "active" : "") . " redBox'" ?> title="Забыл пароль?"></a>
  </nav>

  <div class="containerWrapper">


    <div id="containerLogin" class=<? echo "'tabContainer " . ($isLogin ? "active" : "") . "'" ?>>
      <form id="auth_form" method="POST">
        <input type="hidden" name="login_form"/>
        <h2 class="loginTitle">Авторизация</h2>
        <div class="loginContent">
          <div class="inputWrapper">
            <input type="text" name="auth_login" id="auth_login_id" onkeyup="CountLogin('auth_login_id','auth_login_view','auth_login_correct','auth_pass_id','auth_pass_correct')" placeholder="Логин" <? if ($isLogin) { echo "value='" . $login . "'";} ?> />
            <div class="mini">введено: <span id="auth_login_view">0</span></div>
            <div class="info" id="auth_login_correct">не менее 5 символов</div>
          </div>
        <div class="inputWrapper">
          <input  type="password" name="auth_pass" id="auth_pass_id" maxLength="20" onkeyup="CountPass('auth_pass_id','auth_pass_view','auth_pass_correct','auth_login_id', 'auth_login_correct')" value="" placeholder="Пароль" />
        <div class="mini">введено: <span id="auth_pass_view">0</span></div>
        <div class="info" id="auth_pass_correct">пароль должен содержать от 4 до 20 символов</div>
        </div>
      </div>
      <button style="margin-top: 30px;" class="blueBox"><span class="iconLogin"></span> ВОЙТИ</button>
      <div class="clear"></div>
    </form>
    </div>


    <div id="containerRegister" class=<? echo "'tabContainer " . ($isRegister ? "active" : "") . "'" ?>>
      <form id="reg_form" method="POST">
        <input type="hidden" name="register_form"/>
        <h2 class="loginTitle">Регистрация</h2>
        <div class="registerContent">
          <div class="inputWrapper">
            <input type="text" name="reg_email" id="email_id_reg" placeholder="Ваш email" <?
            if ($isRegister) { 
              echo "value='" . $email . "'"; 
              echo "style='"; 
              if ($emailIsValid) { echo "border: 1px solid rgb(86, 155, 68);"; }
              else { echo "border: 1px solid rgb(255, 0, 0);";}
              echo "'";
            } ?> />
            <span id="valid_reg"></span>
          </div>
        </div>

        <div class="inputWrapper">
          <input type="text" name="reg_login" id="reg_login_id" onkeyup="CountLogin('reg_login_id','reg_login_view','reg_login_correct','reg_pass_id','reg_pass_correct')" placeholder="Логин" <? if ($isRegister) { echo "value='" . $login . "'";} ?> />
          <div class="mini">введено: <span id="reg_login_view">0</span></div>
          <div class="info" id="reg_login_correct"> <? if ($isRegister && $loginIsValid) { echo "верно";} else { echo "не менее 5 символов";} ?> </div>
        </div>

        <div class="inputWrapper">
          <input  type="password" name="reg_pass" id="reg_pass_id" maxLength="20" onkeyup="CountPass('reg_pass_id','reg_pass_view','reg_pass_correct','reg_login_id','reg_login_correct','reg_repass_id','reg_repass_correct')" value="" placeholder="Пароль" />
          <div class="mini">введено: <span id="reg_pass_view">0</span></div>
          <div class="info" id="reg_pass_correct"> <? if ($isRegister && $passIsValid) { echo "верно";} else { echo "длина от 4 до 20 символов и не совпадает с логином";} ?> </div>
        </div>  

        <div class="inputWrapper" style="margin-top: 45px;">
          <input type="password" name="reg_repass" id="reg_repass_id" onkeyup="CorrectPass('reg_repass_id','reg_true_pass_view','reg_repass_correct','reg_pass_id')" value="" placeholder="Повторите пароль" />
          <div class="mini">введено: <span id="reg_true_pass_view">0</span></div>
          <div class="info" id="reg_repass_correct"></div>
        </div>

        <button class="greenBox"><span class="iconRegister"></span> Зарегистрироваться</button>
        <div class="clear"></div>
      </form>
    </div>
    <div class="clear"></div>


    <div id="containerForgot" class=<? echo "'tabContainer " . ($isForgot ? "active" : "") . "'" ?>>
      <form id="rec_form" method="POST">
        <input type="hidden" name="forgot_form"/>
          <h2 class="loginTitle">Восстановления пароля</h2>
          <div class="loginContent">
            <div class="inputWrapper">
              <input id="email_id_rec"  type="text" name="forgot_email" placeholder="Ваш email" <? if ($isForgot) { echo "value='" . $email . "'";} ?> />
              <span id="valid_rec"></span>
            </div>
          <div class="placeholder"></div>
        </div>
        <button class="redBox"><span class="iconForgot"></span> Восстановить</button>
        <div class="clear"></div>
      </form>
    </div>
    <div class="clear"></div>
  </div>
</div>

  <script src="js/jquery-2.2.3.js"></script>
  <script src="js/index.js"></script>
  <script type="text/javascript" src="js/main.js"></script>
</body>
</html>