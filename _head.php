






<!-- fin header -->











<STYle>
/*  fonts et couleurs  */




.submenu {
    display: none;
    position: absolute;
    background-color: gray;
    margin: 5px; /* Ajuster la valeur de la marge selon vos besoins */
}

.submenu a {
    margin: -8px; /* Ajuster la valeur de la marge selon vos besoins */
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
  background-image: url(img/intro3.webp);
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
  background-image: url(img/bb.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;



}

#disponibles {
  background-image: url(img/bro.jpg);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;

 
}

#rs {
  background-image: url(img/figurine-dbz-trunks-adulte-super-saiyan.png);
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