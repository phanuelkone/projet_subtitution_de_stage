<?php
require_once('functions.php');
?>
<!DOCTYPE html>
<!-- Source nav Coding By CodingNepal - codingnepalweb.com -->
<html lang="en">


<style>

.avatar {
  float: right;
  margin: 10px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
}


</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ===== CSS ===== -->
    <link rel="stylesheet" href="Style/main.css">

    <!-- ===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>

    <title>Nav_bar</title>
</head>

<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sidebarOpen'></i>
            <span class="logo navLogo"><a href="index.php">ALTERED</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="index.php">ALTERED</a></span>
                    <i class='bx bx-x siderbarClose'></i>
                </div>

                <ul class="nav-links">
                   
                  
                    
                
                    <?php if (isset($_SESSION['user'] ) &&   $_SESSION['user']['validated'] == 1  || isset($_SESSION['user'] ) &&   $_SESSION['user']['validated'] == 1      ) { ?>
 
                        <img src="img/<?php echo $_SESSION['user']['avatar']; ?>" alt="Avatar" class="avatar">


                        <li><a href="index.php">Home</a></li>
                        <li><a href="b.php">Shop</a></li>
                        
                        <li><a href="Exposition.php">Exposition</a></li>
                        <li><a href="affichage.php">Account</a></li>
                       

                        <?php if ($_SESSION['user']['premium'] == 1) { ?>
                            <li><img src="img/couronne.png" alt="Premium" class="logo-couronne"></li>

                        <?php } ?>
                        <li><a href="logout.php">Logout</a></li>
                        <?php if ($_SESSION['user']['premium'] == 0) { ?>
                            <li><a href="Premium.php">Premium</a></li>
                        <?php } ?>

                        <?php } 
 else { ?>

    <!-- Code à exécuter lorsque la condition n'est pas remplie -->
    <li><a href="index.php">Home</a></li>
    <li><a href="register.php">Sign in</a></li>
    <li><a href="login.php">Log in</a></li>

<?php } ?>








                </ul>

            </div>

            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>

                <div class="searchBox">
                    <div class="searchToggle">
                        <i class='bx bx-x cancel'></i>
                        <i class='bx bx-search search'></i>
                    </div>

                    <div class="search-field">
                        <input type="text" placeholder="Search...">
                        <i class='bx bx-search'></i>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const body = document.querySelector("body"),
            nav = document.querySelector("nav"),
            modeToggle = document.querySelector(".dark-light"),
            searchToggle = document.querySelector(".searchToggle"),
            sidebarOpen = document.querySelector(".sidebarOpen"),
            siderbarClose = document.querySelector(".siderbarClose");

        let getMode = localStorage.getItem("mode");
        if (getMode && getMode === "dark-mode") {
            body.classList.add("dark");
        }

        // js code to toggle dark and light mode
        modeToggle.addEventListener("click", () => {
            modeToggle.classList.toggle("active");
            body.classList.toggle("dark");

            // js code to keep user selected mode even page refresh or file reopen
            if (!body.classList.contains("dark")) {
                localStorage.setItem("mode", "light-mode");
            } else {
                localStorage.setItem("mode", "dark-mode");
            }
        });

        // js code to toggle search box
        searchToggle.addEventListener("click", () => {
            searchToggle.classList.toggle("active");
        });


        //   js code to toggle sidebar
        sidebarOpen.addEventListener("click", () => {
            nav.classList.add("active");
        });

        body.addEventListener("click", e => {
            let clickedElm = e.target;

            if (!clickedElm.classList.contains("sidebarOpen") && !clickedElm.classList.contains("menu")) {
                nav.classList.remove("active");
            }
        });
    </script>

</body>

</html>