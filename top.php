<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!--=============== BOXICONS ===============-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

        <!--=============== CSS ===============-->
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="style.css">

        <title>Responsive bottom navigation</title>
    </head>
    <body>
        <!--=============== HEADER ===============-->
        <header class="header" id="header">
            <nav class="nav container">
                <style>
                    .nav__logo {
                        display: flex;
                        align-items: center;
                        text-decoration: none;
                    }

                    .logo-img {
                        width: 75px;
                        border-radius: 10px;
                    }

                    .logo-text {
                        display: inline-block;
                        white-space: nowrap;
                        overflow: hidden;
                        text-overflow: ellipsis;
                    }

                    @media screen and (max-width: 768px) {
                        .logo-text {
                            display: none;
                        }
                    }

                </style>
                <a href="index.php" class="nav__logo">
                    <img src="logo.png" alt="" class="logo-img">
                    <span class="logo-text">တပ်မတော်ကာကွယ်ရေးဦးစီးချုပ်ရုံး</span>
                </a>
                
                <div class="nav__menu" id="nav-menu">
                    <ul class="nav__list">
                        <li class="nav__item">
                            <a href="index.php" class="nav__link ">
                                <i class="fa-solid fa-house" style="font-size:20px;"></i>
                                <span class="nav__name">Home</span>
                            </a>
                        </li>
                        
                        <li class="nav__item">
                            <a href="telegraph.php" class="nav__link">
                                <i class="fa-solid fa-envelope" style="font-size:20px;"></i>
                                <span class="nav__name">ကြေးနန်းပို့</span>
                            </a>
                        </li>

                        <li class="nav__item">
                            <a href="mm.php" class="nav__link">
                                <i class="fa-solid fa-map" style="font-size:20px;"></i>
                                <span class="nav__name">စစ်/မြေ</span>
                            </a>
                        </li>

                        <li class="nav__item">
                            <a href="#portfolio" class="nav__link">
                                <i class="fa-solid fa-newspaper" style="font-size:20px;"></i>
                                <span class="nav__name">စစ်သတင်း</span>
                            </a>
                        </li>

                        <li class="nav__item">
                            <a href="#contactme" class="nav__link">
                                <i class="fa-solid fa-rss" style="font-size:20px;"></i>
                                <span class="nav__name">သတင်းပို့မည်</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <img src="assets/img/perfil.png" alt="" class="nav__img">
            </nav>
        </header>