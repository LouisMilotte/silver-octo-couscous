<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/style.css"; ?>">

</head>

<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/index.php"; ?>" style="color:white;">
  <img src="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/img/canvas.png"; ?>" width="30" height="30" class="d-inline-block align-top" alt="">
  Gifticality
  </a>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/index.php"; ?>" style="color:white;">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/pages/people.php"; ?>" style="color:white;">People</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/pages/wishlist.php"; ?>" style="color:white;">Wishlist</a>
      </li>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="<?php echo "http://" . $_SERVER["HTTP_HOST"] . "/pages/search.php"; ?>" style="color:white;">Search</a>
      </li>
    </ul>
  </div>
</nav>