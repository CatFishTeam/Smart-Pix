
<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue sur Smart-Pix</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="public/css/style.css" />
    </head>
    <body>
        <header>
            <div class="container">
                <div class="row">
                    <section class="col-4">
                        <img src="public/image/logo.png" alt="Smart-Pix Logo" class="logo"/>
                        <nav>
                            <i class="fa fa-search" aria-hidden="true"></i>
                            <input type="text" placeholder="Recherche par photo, catégorie, artiste..."/>
                        </nav>
                    </section>
                    <section class="col-2">
                        <select>
                            <option>Connexion / Inscription</option>
                        </select>
                    </section>
                </div>
            </div>
        </header>
        <div class="container">
            <div class="row">
                <section class="col-4">
                    <img src="public/image/background.png" />
                    <div class="button">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Voir plus d'images
                    </div>
                </section>
                <aside class="col-2">
                    <div class="box">
                        <h3>Photo du jour</h3>
                        <img src="http://placehold.it/250x120" />
                    </div>
                    <div class="box">
                        <h3>Catégories</h3>
                        <ul>
                            <li>Nature
                            <li>Urbain
                            <li>Animaux
                            <li>Mode
                            <li>Arts
                            <li>Architecture
                            <li>...
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
        <footer>
            Smart-Pix © - 2017
        </footer>
    </body>
</html>
