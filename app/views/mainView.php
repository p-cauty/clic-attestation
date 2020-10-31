<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?= $TITLE ?></title>
        <link href="<?= ASSETS ?>/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="<?= ASSETS ?>/img/favicon.png" />
        <link rel="apple-touch-icon" type="image/x-icon" href="<?= ASSETS ?>/img/favicon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.24.1/feather.min.js" crossorigin="anonymous"></script>
       
        <!-- Matomo -->
        <script type="text/javascript">
          var _paq = window._paq = window._paq || [];
          /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
          _paq.push(['trackPageView']);
          _paq.push(['enableLinkTracking']);
          (function() {
            var u="//analytics.justauth.me/";
            _paq.push(['setTrackerUrl', u+'matomo.php']);
            _paq.push(['setSiteId', '3']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
          })();
        </script>
        <!-- End Matomo Code -->
    </head>
    <body>
        <div id="layoutDefault">
            <div id="layoutDefault_content">
                <main>
                    <?php require_once @$appView; ?>
                </main>
            </div>
            <div id="layoutDefault_footer">
                <footer class="footer pt-10 pb-5 mt-auto bg-white footer-light">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="footer-brand"><?= NAME ?></div>
                                <div class="mb-3">Générez des attestations<br />en un clic !</div>
                                <div class="icon-list-social mb-5">
                                    <a class="icon-list-social-link" href="mailto:<?= CONTACT_EMAIL ?>"><i class="fas fa-envelope"></i></a>
                                    <a class="icon-list-social-link" href="<?= SOCIAL_TWITTER ?>"><i class="fab fa-twitter"></i></a>
                                    <a class="icon-list-social-link" href="<?= SOCIAL_INSTAGRAM ?>"><i class="fab fa-instagram"></i></a>
                                    <a class="icon-list-social-link" href="<?= SOCIAL_GITHUB ?>"><i class="fab fa-github"></i></a>
                                </div>
                            </div>
                        </div>
                        <hr class="my-5" />
                        <div class="row align-items-center">
                            <div class="col-md-6 small">Fait avec ❤ par <a href="https://peter.cauty.fr">Peter Cauty</a> en Novembre 2020</div>
                            <div class="col-md-6 text-md-right small">
                                <a href="<?= GITHUB ?>">Voir sur Github</a>
                                &middot;
                                <a href="javascript:void(0)" onclick="alert('Aucune donnée n\'est sauvegardée.')">Politique de confidentialité</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= ASSETS ?>/js/scripts.js"></script>
    </body>
</html>
