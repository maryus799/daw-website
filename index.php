<!DOCTYPE html>
<html lang="ro">

<head>
    <title>Dezvoltare Aplicații ManolovSky</title>
    <meta name="keywords"
        content="ManolovSky, aplicații mobile, cumpără aplicații, dezvoltare aplicații, app development, android, ios, web, programare">
    <meta name="description"
        content="Crează-ți propria aplicație pentru a crește vizibilitatea companiei tale. ManolovSky te ajută să realizezi o nouă aplicație sau să-ți transformi website-ul într-o aplicație pentru mobil.">
    <?php include('fragmente/head.php'); ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/resurse/css/layout.css" type="text/css" />
    <link rel="stylesheet" href="/resurse/css/customizare_butoane.css" type="text/css" />
    <script type="text/javascript" src=/resurse/js/produse.js></script>
    <link href="/resurse/css/produse.css" type="text/css" rel="stylesheet" />
</head>

<body class="fixed-background">
    <?php include('fragmente/header.php'); ?>
    <main>
        <div id="grid-pagina">
            <div class="row justify-content-center g-5">
                <section id="welcome">
                    <div class="banner-container">
                        <h2 class="banner">Bine ați venit pe pagina oficială a site-ului cu Reviste Online Educative
                            <span class="text">Mano</span>
                            <i class="fas fa-heart heart-icon" style="color: red;"></i>
                            <span class="text">Sky</span> !!
                        </h2>
                    </div>
                    <div id="video-vtt">
                        <div id="stil-video">
                            <video width="1000" height="500" poster="/resurse/imagini/programare.jpg" preload="auto"
                                controls>
                                <source src="/resurse/video/books.mp4" type="video/mp4">
                                <track default src="/resurse/video/tracks/mesaje-ro.vtt" kind="captions" srclang="ro"
                                    label="romana" />
                                <track src="/resurse/video/tracks/mesaje-eng.vtt" kind="captions" srclang="en"
                                    label="engleza" />
                            </video>
                        </div>
                    </div>
                    <p class="p-4">Acest site conține <strong>reviste online educative</strong>. În secțiunea
                        <strong>”Reviste”</strong> regăsiți materiale educative pentru copii de toate vârstele.
                        De asemenea, mai jos sunt cele mai populare aplicații educative create de dezvoltatorul
                        <strong>ManolovSky</strong>.
                        Aplicațiile educative realizate de dezvoltatorul ManlovSky se remarcă în domeniul istoriei
                        prin structura lor bine concepută, care facilitează descoperirea de noi informații atât
                        pentru elevi și studenți, cât și pentru pasionații de istorie. Aceste calități sunt
                        confirmate de premiile obținute la concursurile Digitaliada.
                    </p>
                </section>
                <div id="app1" class="col-md-6 border border-info shadow-lg">
                    <div class="p-4 text-white">
                        <section id="domnitori">
                            <h3>Istorie - Domnitori și Bătălii</h3>
                            <blockquote
                                cite="https://play.google.com/store/apps/details?id=com.manolovsky.domnitorii">
                                Istoria Românilor - Domnitori și Bătălii este o aplicație offline de cultură
                                generală care conține
                                informații cu privire la peste 130 de domnitori ai celor două principate române -
                                Țara Românească
                                (Valahia) și Moldova, precum și aproape 150 de bătălii sau campanii militare
                                desfășurate în secolele
                                XIV-XVII. Prin intermediul aplicației, utilizatorul poate avea acces la scurte
                                prezentări ale
                                domnitorilor și principalelor momente ale unor bătălii celebre. De asemenea,
                                aplicația oferă acces
                                la aproape 200 de surse istorice de încredere în format PDF pentru aprofundarea
                                cunoștințelor, fără a
                                finecesară o conexiune la internet.</blockquote>
                            <figure class="imagini">
                                <picture>
                                    <source srcset="/resurse/imagini/istorie2.jpg" media="(max-width:500px)" />
                                    <source srcset="/resurse/imagini/istorie1.jpg" media="(max-width:1000px)" />
                                    <img src="/resurse/imagini/istorie.jpg" alt="domnitori" title="domnitori" />
                                </picture>
                            </figure>
                            <a class="linkuri" target="_blank"
                                href="https://play.google.com/store/apps/details?id=com.manolovsky.domnitorii">
                                Apasă
                                aici pentru a descărca aplicația <em>Istorie - Domnitori și Bătălii</em></a>
                        </section>
                    </div>
                </div>
                <div id="app2" class="col-md-6 border border-info shadow-lg">
                    <div class="p-4 text-white">
                        <section id="transilvania">
                            <h3>Istorie - Transilvania Quiz</h3>
                            <blockquote
                                cite="https://play.google.com/store/apps/details?id=com.manolovsky.transilvania">
                                Istorie -
                                Transilvania Quiz este o aplicație offline de cultură generală care conține
                                informații cu privire la
                                peste 40 de voievozi, principi și guvernatori ai Transilvaniei și peste 25 de surse
                                istorice în
                                format PDF. Prin intermediul aplicației, utilizatorul poate avea acces la scurte
                                prezentări ale noțiunilor
                                de voievod, principe și guvernator, când au fost folosite aceste titluri în
                                Transilvania și lista
                                cronologică a conducătorilor care au deținut aceste titulaturi. De asemenea,
                                aplicația conține 3
                                feluri de Quiz-uri pentru a-ți verifica cunoștințele sau pentru a te juca în doi.
                            </blockquote>
                            <figure class="imagini">
                                <picture>
                                    <source srcset="/resurse/imagini/transilvania2.jpg" media="(max-width:500px)" />
                                    <source srcset="/resurse/imagini/transilvania1.jpg" media="(max-width:1000px)" />
                                    <img src="/resurse/imagini/transilvania.jpg" alt="domnitori" title="domnitori" />
                                </picture>
                            </figure>
                            <a class="linkuri" target="_blank"
                                href="https://play.google.com/store/apps/details?id=com.manolovsky.transilvania">
                                Apasă aici pentru a descărca aplicația <em>Istorie - Transilvania Quiz</em> </a>
                        </section>
                    </div>
                </div>
                <section id="anunturi">
                    <div class="container-reflexie">
                        <h2 class="text-reflexie">Anunțuri</h2>
                    </div>
                    <?php include('fragmente/stea.php'); ?>
                    <p><time datetime="2024-04-10">12 Septembrie 2024</time> - Lansarea oficială a Site-ului</p>
                    <?php include('fragmente/stea.php'); ?>
                    <p><time datetime="2024-04-10">31 Decembrie 2024</time> - Lansarea Revistelor Educative Online</p>
                    <?php include('fragmente/stea.php'); ?>
                    <p><time datetime="2024-04-10">1 Martie 2025</time> - Lansarea Revistelor Sportive Online</p>
                </section>
            </div>
        </div>
    </main>
    <?php include('fragmente/footer.php'); ?>
</body>

</html>