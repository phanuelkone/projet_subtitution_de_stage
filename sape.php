


<?php
require_once('functions.php');
?>






<!-- AUDI FRANCE HOMEPAGE by Wetafan JLGER540799-->

<!-- imports fonts -->
<style>
@import url('http://fonts.cdnfonts.com/css/audi-type-2');
</style>
<style>
@import url('http://fonts.cdnfonts.com/css/audi-type-2?styles=30111');
</style>
<link href="http://fonts.cdnfonts.com/css/audi-type-extended?styles=15538" rel="stylesheet">


<!-- start header -->
<nav>
  
	<ul>
  <div id="logoaudi" class="col-md-1">
  <div id="menu" class="col-md-10">
    <ul>
        <li><a href="b.php">Accueil</a></li>
        <li class="boutique-link">
            <a href="#">Boutique</a>
            <ul class="submenu">
                <li><a href="sape.php">MODE</a></li>
                <li><a href="animaux.php">FAUNE</a></li>

                <li><a href="afrique.php">Afrique</a></li>
                <li><a href="tablaux.php">Peinture</a></li>


            </ul>
        </li>
        <li><a href="#" id="logout-link">Log Out</a></li>
    </ul>
</div>





</nav>
<!-- fin header -->



<script>
	document.getElementById("logout-link").addEventListener("click", function() {
		var previewLink1 = document.getElementById("preview-link1");
		var previewLink2 = document.getElementById("preview-link2");

		if (previewLink1.style.display === "none") {
			previewLink1.style.display = "block";
			previewLink2.style.display = "block";
		} else {
			previewLink1.style.display = "none";
			previewLink2.style.display = "none";
		}
	});
</script>









<!-- fin header -->











<STYle>
/*  fonts et couleurs  */


#menu ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

#menu li {
    display: inline-block;
    margin-right: 10px;
}

#menu a {
    text-decoration: none;
    color: #000;
}

.submenu {
    display: none;
    position: absolute;
    background-color: gray;
    margin: 5px; /* Ajuster la valeur de la marge selon vos besoins */
}

.submenu a {
    margin: -8px; /* Ajuster la valeur de la marge selon vos besoins */
}

.boutique-link:hover .submenu {
    display: block;
}






*{
   font-family: 'Audi Type', sans-serif;}

  .AudiType700 {
 font-family: 'Audi Type Extended', sans-serif;
}
.Audired {
    color: #f50537;
  /*font-weight: strong;*/
}

.rhombus {
     width: 22.4px;
      height: 26.52px;
      transform: skew(-27deg);
    font-size:20px;
    line-height:100px;
    background: #f50537;
}



#Q8avantage
{
  height:600px;
  margin;
  padding: 0px;
  background:black;
  background-image: url(img/afro.jpg);
  top:30%;
  }








  #menu {
      display: inline-block;
      vertical-align: middle;
    }

    ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
    }

    li {
      display: inline-block;
      margin-right: 10px;
    }

    li:last-child {
      margin-right: 0;
    }

    nav {
      text-align: center;
    }

    a {
      display: inline-block;
      padding: 10px 20px;
      background-color: #ccc;
      color: #000;
      text-decoration: none;
    }

    a:hover {
      background-color: #999;
    }

    nav ul {
      display: flex;
      justify-content: space-between;
      list-style: none;
      padding: 0;
    }
  
    nav li {
      flex-grow: 1;
      text-align: center;
    }


    #menue {
      display: flex;
      justify-content: center;
      align-items: center;
    }



/*  styles pour general et tricorps */
body {
  margin: 0;
  padding: 50;
  font-family:'Audi Type Extended', sans-serif;
}

.container {
  display: flex;
  height: 100vh;
  padding:0;
  width:100%
}

.section {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100%;
  overflow: hidden;
  background-size: cover;
  background-position: center;
  color: #fff;
  transition: flex .6s ease;
  position: relative;
}

.section .overlay {
  background-color: rgba(0, 0, 0, 0.5);
  width: 100%;
  height: 100%;
  position: absolute;
  transition: background-color .8s ease;
}

.section .content {
  z-index: 2;
}

.section:hover {
  flex: 2;
}

.section:hover .overlay {
  background-color: rgba(0, 0, 0, 0);
}




#electrique {
  background-image: url(img/faune2.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;



}

#disponibles {
  background-image: url(img/faune1.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;

 
}

#rs {
  background-image: url(img/intro11.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
 
  background-position-y: 0px; /
}



.border{
  border:1px solid black;
  padding:15px 15px 15px;
}
html,body {
  margin: 0;
  padding: 0;
  font-family:;
  background-color: #ffffff ;
}
/*  sensible  */
.dummy_page {
  height: 200px;
  width: 100%;
  background-color: #f0f0f0;
  text-align: left;
  box-sizing: border-box;
  padding: 60px 0px;
}
/*  styles pour footer  */
.footer {
  width: 100%;
  position: absolute;
  height: auto;
  background-color: #000000;
  left: 0
 }
.footer .col {
  width: 190px;
  height: auto;
  float: left;
  box-sizing: border-box;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  padding: 0px 20px 20px 20px;
}
.footer .col h1 {
  margin: 0;
  padding: 0;
  font-family: 'Audi Type', sans-serif;;
  font-size: 14px;
  line-height: 17px;
  padding: 20px 0px 5px 0px;
  color: rgba(255,255,255,255);
  font-weight: normal;
  text-transform: uppercase;
  letter-spacing: 0.250em;
}
.footer .col ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
.footer .col ul li {
  color: #999999;
  font-size: 12px;
  font-family:  'Audi Type', sans-serif;
  font-weight: normal;
  padding: 5px 0px 5px 0px;
  cursor: pointer;
  transition: .2s;
  -webkit-transition: .2s;
  -moz-transition: .2s;
}
.social ul li {
  display: inline-block;
  padding-right: 5px !important;
}

.footer .col ul li:hover {
  color: #ffffff;
  transition: .1s;
  -webkit-transition: .1s;
  -moz-transition: .1s;
}
.clearfix {
  clear: both;
}
@media only screen and (min-width: 1280px) {
  .contain {
    width: 1200px;
    margin: 0 auto;
  }
}
@media only screen and (max-width: 1139px) {
  .contain .social {
    width: 1000px;
    display: block;
  }
  .social h1 {
    margin: 0px;
  }
}
@media only screen and (max-width: 950px) {
  .footer .col {
    width: 33%;
  }
  .footer .col h1 {
    font-size: 14px;
  }
  .footer .col ul li {
    font-size: 14px;
  }
}
@media only screen and (max-width: 500px) {
    .footer .col {
      width: 50%;
    }
    .footer .col h1 {
      font-size: 14px;
    }
    .footer .col ul li {
      font-size: 13px;
    }
}
@media only screen and (max-width: 340px) {
  .footer .col {
    width: 100%;
  }
}

#h1footer{
  padding: 20px;
  color:#e5e5e5;
  font-size:12px;
}

.content h4 a{color:white;text-decoration:none;}
.content h5 a{color:#333333;text-decoration:none;}




.col-sm-4 > span, .col-sm-4 > h1 {
  display: inline-block;
}

#Q7avantage
{
  height:600px;
  margin;
  padding: 0px;
  background:black;
  }

.container-fluid {
    padding:0px!important;
}


/* Réinitialisation des marges et paddings pour le menu */
nav ul, nav li {
  margin: 0;
  padding: 0;
}

/* Positionnement du menu en haut de la page */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: white;
  z-index: 9999;

  
}








#menue {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    
    #menue li:nth-child(2) {
      margin-right: auto;
    }
    
    #logout-link {
      margin-right: 0;
    }




</STYle>

<!-- start tri-corps -->
<div class="container">
  <div id="electrique" class="section">
    <div class="content">
      <h1>Découvrez notre rebrique 
        100/%  Faune </h1>
      <h4><a href="animaux.php">Decouvrez la Faune en peinture .</a></h4>
    </div>
    <div class="overlay"></div>
  </div>
  <div id="disponibles" class="section">
    <div class="content">
    <h1>Nos modèles disponibles immédiatement</h1>
      <h4><a href="animaux.php">Accedez a la boutique et decouvrez.</a></h4>
    </div>
    <div class="overlay"></div>
  </div>
  <div id="rs" class="section">
    <div class="content">
<div class="row">
  <div class="col-sm-4"> <span> <div class="rhombus"></div></span>
    <h1>VOGUE</h1>
    </div>
</div>
      <h4><a href="animaux.php">Decouvrez notre 
        rubriques 100% Faune.</a></h4>
    </div>
    <div class="overlay"></div>
  </div>
</div>

<!-- fin tri-corps -->
<p> 
  <br>
  <!-- START etage 2-->
  <body>
    
<header>
   
</header>

<style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    header {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    
    nav {
      background-color: #f1f1f1;
      padding: 10px;
      text-align: center;
    }
    
    nav a {
      text-decoration: none;
      color: #333;
      padding: 10px;
      margin: 0 5px;
    }
    
    .product {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
    }
    
    .product-item {
      width: 300px;
      margin: 5px;
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }
    
    .product-item img {
      width: 100%;
      max-height: 400px;
      object-fit: cover;
      margin-bottom: 10px;
    }
    
    .add-to-cart-btn {
      background-color: #4CAF50;
      color: #fff;
      border: none;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 12px;
      margin-top: 10px;
      cursor: pointer;
    }
    </style>

<div class="video-bar">
    <!-- Insérez ici le code pour intégrer votre vidéo -->
</div>
<div class="product-container">
<div class="product">
    <?php
    // Connexion à la base de données
    $bdd = connect();

    // Récupérer les produits de la base de données
    $sql = "SELECT * FROM produit WHERE id_produit  IN( 102,103,104,105,106,107,108,109,110,111,112,113)";
    $sth = $bdd->prepare($sql);
    $sth->execute();
    $products = $sth->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $product) {
        echo '<div class="product-item">';
        echo '<img src="img/' . $product["picture"] . '" alt="' . utf8_encode($product["nom_produit"]) . '">';
        echo '<h2>' . utf8_encode($product["nom_produit"]) . '</h2>';
        echo '<p>' . utf8_encode($product["description_produit"]) . '</p>';

        echo '<p>' . number_format($product["prix"], 2, ',', '.') . ' €</p>';


        echo '<a href="payement.php?id=' . $product["id_produit"] . '" class="add-to-cart-btn">Acheter</a>';
        echo '</div>';
    }
    ?>
</div>
</div>
<div class="shop-now">
    <a href="#" class="shop-now-btn">Shop Now</a>
</div>
</body>