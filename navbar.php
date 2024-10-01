<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    /* Navbar stijl */
    /* Navbar stijl */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: #4acac5;
        color: white;
        position: relative;
        /* Belangrijk om elementen te centreren */
    }

    .navbar .logo {
        display: flex;
        align-items: center;
        font-size: 24px;
    }

    .navbar .logo img {
        width: 50px;
        height: 50px;
        margin-right: 10px;
    }

    .navbar .search-bar {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        /* Centrer de zoekbalk horizontaal */
    }

    .navbar .search-bar input[type="text"] {
        width: 700px;
        /* Breedte van de zoekbalk */
        padding: 10px 40px 10px 20px;
        font-size: 16px;
        border-radius: 50px;
        border: none;
        outline: none;
        background-color: white;
    }

    .navbar .search-bar i {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #4acac5;
        font-size: 20px;
    }

    .navbar .dropdown {
        display: flex;
        align-items: center;
    }

    .navbar .hamburger {
        font-size: 30px;
        cursor: pointer;
    }


    /* Dropdown-menu stijl */
    .dropdown-menu {
        display: none;
        /* Begin verstopt */
        position: absolute;
        right: 0;
        top: 60px;
        background-color: white;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        border-radius: 12px;
        overflow: hidden;
        z-index: 1000;
        min-width: 180px;
        transition: all 0.3s ease;
        /* Smooth transition */
        opacity: 0;
        transform: translateY(-10px);
        /* Start slightly above */
        visibility: hidden;
        /* Hidden by default */
    }

    /* Toon het dropdown-menu als zichtbaar */
    .dropdown-menu.show {
        display: block;
        opacity: 1;
        transform: translateY(0);
        /* Animate down */
        visibility: visible;
    }

    .dropdown-menu a {
        display: block;
        padding: 12px 20px;
        color: #4acac5;
        text-decoration: none;
        font-size: 16px;
        transition: background-color 0.3s ease;
    }

    .dropdown-menu a:hover {
        background-color: #f0f0f0;
        color: #3a3a3a;
    }

    /* Afgeronde hoeken op de menu-items voor een moderner gevoel */
    .dropdown-menu a:first-child {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .dropdown-menu a:last-child {
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }
</style>

<div class="navbar">
    <div class="logo">
        <a href="index.php">
            <img src="logo-color.png" alt="Logo"> <!-- Voeg hier je logo afbeelding toe -->
        </a>
    </div>
    <div class="search-bar">
        <input type="text" id="zoekveld" placeholder="Zoek Naar Boten...">
        <i class="fa fa-search"></i>
    </div>

    <div class="dropdown">
        <div class="hamburger" onclick="toggleMenu()">&#9776;</div> <!-- Klikbare hamburger -->
        <div class="dropdown-menu" id="dropdownMenu">
            <a href="profiel.php">Account</a>
            <a href="#">Mijn reserveringen</a>
        </div>
    </div>
</div>

<script>
    function toggleMenu() {
        const menu = document.getElementById('dropdownMenu');
        if (menu.classList.contains('show')) {
            menu.classList.remove('show');
        } else {
            menu.classList.add('show');
        }
    }

    // Sluit het dropdown-menu wanneer je buiten klikt
    window.onclick = function(event) {
        if (!event.target.matches('.hamburger')) {
            const dropdowns = document.getElementsByClassName('dropdown-menu');
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>