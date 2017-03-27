
<!DOCTYPE html>
<html>
    <head>
        <title>Bienvenue sur Smart-Pix</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="stylesheet" href="/public/css/style.css" />
        <style>
            img{
                max-width: 100%;
            }
            .logo {
                float: left;
                width: 80px;
            }
            .box{
                border: 1px solid grey;
                margin: 10px;
                padding: 5px;
            }
            .box h3{
                background-color: #2089e6;
                margin: -5px;
                margin-bottom: 5px;
                padding-left: 10px;
                color: #fff;
            }
            .box ul{
                list-style: none;
                width: 100%;
                padding: 0;
                margin: -6px;
            }
            .box ul li{
                border: 1px solid gray;
                padding-left: 10px;
                padding-top: 5px;
                width: 100%;
            }
            .button{
                text-align: center;
                border: 1px solid grey;
                width: 40%;
                border-radius: 10px;
                background-color: azure;
                margin: auto;
                cursor: pointer;
            }
            footer{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <header>
            <img src="/public/image/logo.png" alt="Smart-Pix Logo" class="logo"/>
            <nav>
                <i class="fa fa-search" aria-hidden="true"></i>
                <input type="text" placeholder="Recherche par photo, catégorie, artiste..."/>
                <select>
                    <option>Connexion / Inscription</option>
                </select>
            </nav>
        </header>
        <div class="container">
            <div class="row">
                <section class="col-4">
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
                    <img src="http://placehold.it/250x120" />
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
