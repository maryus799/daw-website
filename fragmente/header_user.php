<header>
    <div class="container mt-2">
        <div class="form-check form-switch position-fixed top-0 start-0 m-3">
            <input class="form-check-input" type="checkbox" id="tema">
            <label class="form-check-label" for="tema">
                <i class="bi bi-sun theme-icon light"></i>
                <i class="bi bi-moon theme-icon dark"></i>
            </label>
        </div>
    </div>
</header>
<nav>
    <label id="hamburger" for="ch-menu">
        <img src="/resurse/imagini/menu.png" alt="menu">
    </label>
    <input id="ch-menu" type="checkbox">
    <ul class="meniu">
        <li>
            <a href="/pagini/user.php">
            <div class="button">
                    <i class="bi bi-journal-bookmark-fill" style="color: black;"></i>
                    <div class="bar"></div>Reviste
                </div>
            </a>
        </li>
        <li>
            <a href="/pagini/profil.php">
                <div class="button">
                    <i class="bi bi-person-fill" style="color: black;"></i>
                    <div class="bar"></div>Profilul Meu
                </div>
            </a>
        </li>
        <li>
            <a href="/fragmente/logout.php">
                <div class="button">
                <i class="bi bi-box-arrow-right" style="color: black;"></i>
                    <div class="bar"></div>Ieșire
                </div>
            </a>
        </li>
    </ul>
</nav>