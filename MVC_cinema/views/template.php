<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cerulean/bootstrap.min.css" integrity="sha384-3fdgwJw17Bi87e1QQ4fsLn4rUFqWw//KU0g8TvV6quvahISRewev6/EocKNuJmEw" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="public/css/style.css">
    <title> <?=$title?> </title>
</head>
<body id="color-body">

    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="img_affiche/th.jpg" class="logo" alt="logo" srcset=""> </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php?action=acceuil">Acceuil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=listsFilms">Films</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=listsRealisateurs">Réalisateurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=listsActeurs">Acteurs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?action=listsGenres">Genres</a>
        </li>
      
      </ul>
      <form action="index.php?action=recherche"  method="post" class="d-flex">
      <!-- <form action="index.php?action=recherche"  method="get" class="d-flex"> -->
        <input class="form-control me-sm-2" type="text" name="resultat">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
    </header>

    <main>
        <div class="containte mb-5">
            <?=$contenu?>
        </div>
    </main>

    <footer class="fixed-bottom">
        <div class="container ">
            <div class="row text-center">
                <div class="col-12">
                    <nav>
                      <a href="#">CGU</a>
                      <a href="#">Plan du site</a>
                      <a href="#">Mention légal</a>
                    </nav>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-12 mt-2" >
                    <small>@copyright-TL</small>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>