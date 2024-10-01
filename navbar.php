<style>
    /* Navbar stijl */
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
        background-color: #4acac5;
        color: white;
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
        flex-grow: 1;
        margin: 0 30px;
        position: relative;
    }

    .navbar .search-bar input[type="text"] {
        width: 100%;
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
        position: relative;
        display: inline-block;
    }

    .navbar .hamburger {
        font-size: 30px;
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
        <div class="hamburger">&#9776;</div>
    </div>
</div>