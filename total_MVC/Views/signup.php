<?php
session_start();
require_once(ROOT_PATH . 'Controllers/UserController.php');
$user = new UserController();
$userPrams = $user->index();
// バリデーション
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $errors = [];
    if (empty($_POST['name'])) {
      $errors['name'] = '*ユーザーネームを入力してください。';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = '*メールアドレスを入力してください。';
    } else {
        //重複チェック
        foreach($userPrams['users'] as $user) {
            if($user['email'] == $_POST['email']) {
                $errors['email'] = "このメールアドレスはすでに登録されています。";
            }
        }
    }
    if (empty($_POST['password'])) {
        $errors['password'] = '*パスワードを入力してください。';
    } elseif (!preg_match('/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,30}+\z/',$_POST['password'])) {
        $errors['password'] = '*8文字以上で半角英小文字大文字数字を含んで入力してください';
    }
    if(count($errors) === 0){
        // もしエラーがなかったらsignUp()を適用
        $user = new UserController();
        $signUp = $user->signUp();
        header('Location:login.php');
    }
}

?>


<!doctype html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.83.1">
    <title>新規登録画面</title>

    <link rel="canonical" href="https://getbootstrap.jp/docs/5.0/examples/sign-in/">

    

    <!-- Bootstrap core CSS -->
<link href=https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="/css/signup.css" rel="stylesheet">
    <link href="/css/header.css" rel="stylesheet">
    <link href="/css/footer.css" rel="stylesheet">
  </head>

  <?php include('header.php'); ?>


  <body class="text-center">

    
<main class="form-signin">
  <form action="signup.php" method="post">
    <h1 class="h3 mb-3 fw-normal">会員登録</h1>

    <?php if(!empty($errors['name'])): ?>
                <div class="" style="color:red">
                  <p><?= $errors['name'];?></p>
                </div>
    <?php endif; ?>
    <?php if(!empty($errors['email'])): ?>
                <div class="" style="color:red">
                  <p><?= $errors['email'];?></p>
                </div>
    <?php endif; ?>
    <?php if(!empty($errors['password'])): ?>
                <div class="" style="color:red">
                  <p><?= $errors['password'];?></p>
                </div>
    <?php endif; ?>


    <div class="form-floating">
      <input type="name" class="form-control" name="name" id="floatingInput" placeholder="キャリコン太郎">
      <label for="floatingInput">ユーザーネーム</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Eメールアドレス</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">パスワード</label>
    </div>

    <button class="w-100 btn2 btn-lg btn-primary2" type="submit">登録</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2022</p>
  </form>
</main>


<?php include('footer.php'); ?>


    
  </body>
</html>