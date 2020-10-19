<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
<title><?= $page_title ?? ''; ?></title>
    <link href="https://fonts.googleapis.com/css?family=Henny+Penny|Pattaya|Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
</head>
<body>

<header class="mb-5">
 
<div class="container-fluid header-top">
</div>
<div class="paris-logo-div">
  <a class="text-center rounded d-flex justify-content-center" href="index.php">
      <img class = "paris-logo" alt="logo" src="images/logo.png">
    </a>
  </div>
  <div>
  <nav class="navbar navbar-expand-lg navbar-light font-weight-bold navigation-bar shadow-sm">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon hamburger"></span>
            </button>
          
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="about.php">About <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="blog.php">blog <span class="sr-only">(current)</span></a>
                </li>
              </ul>
              <ul class="navbar-nav ml-auto">
               <?php if (!auth_user()) :?>
                <li class="nav-item active">
                  <a class="nav-link" href="login.php">Log-in <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="signup.php">Sign up <span class="sr-only">(current)</span></a>
                </li>
                <?php else :?> 
                  <li class="nav-item active">
                    <a class="nav-link" href="profile.php"><?= htmlentities($_SESSION['user_name']);?></a>
                  </li>
                  <li class="nav-item active">
                    <a class="nav-link" href="logout.php">Log-out <span class="sr-only">(current)</span></a>
                  </li>
               <?php endif;?>
               
              </ul>
            </div>
        </div>
    </nav>
  </div>
    
</header>
