<?php

use PitouFW\Core\Alert;

?>
<header class="page-header page-header-dark bg-img-repeat bg-blue pt-3 pt-lg-10" style='background-image: url("<?= IMG ?>pattern-shapes.png")'>
    <div class="page-header-content">
        <div class="container">
            <?= Alert::handle() ?>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="page-header-title mb-5">Créez votre générateur personnel d'attestations</h1>
                    <ol class="page-header-text">
                        <li>Remplissez le formulaire ci-contre</li>
                        <li>Créez un raccourci sur votre bureau ou votre écran d'accueil (Android & iOS)</li>
                        <li>Utilisez le raccourci à chaque fois que vous avez besoin d'une attestation</li>
                        <li>Choisissez juste le motif, une attestation conforme est générée à votre nom et à la bonne date !</li>
                    </ol>
                    <div class="text-center mt-5">
                        <div style="font-size:112px;font-weight:bold;" class="odometer" id="counter">0</div>
                        <div style="font-size:32px;">Attestations générées</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card rounded-lg text-dark">
                        <div class="card-header py-4">Renseignez vos informations une seule fois !</div>
                        <div class="card-body">
                            <form method="post">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="firstname">Prénom</label>
                                        <input class="form-control rounded-pill" id="firstname" name="firstname" type="text" placeholder="Jean" required />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="lastname">Nom</label>
                                        <input class="form-control rounded-pill" id="lastname" name="lastname" type="text" placeholder="Dupont" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="birth_date">Date de naissance</label>
                                        <input class="form-control rounded-pill" id="birth_date" name="birth_date" type="text" placeholder="jj/mm/aaaa" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}" required />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="birth_location">Lieu de naissance</label>
                                        <input class="form-control rounded-pill" id="birth_location" name="birth_location" type="text" placeholder="Ville" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small text-gray-600" for="street_address">Adresse complète</label>
                                    <input class="form-control rounded-pill mb-3" id="street_address" name="street_address" type="text" placeholder="N°, voie et complément" required />
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input class="form-control rounded-pill" id="birth_date" name="postal_code" type="tel" placeholder="Code postal" required />
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input class="form-control rounded-pill" id="birth_location" name="city" type="text" placeholder="Ville" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="small text-gray-500 text-justify">
                                        En remplissant ce formulaire, vous acceptez que les informations fournies servent
                                        à générer des attestations de déplacement dérogatoires.<br />
                                        <a href="<?= WEBROOT ?>terms#privacy">En savoir plus</a>.
                                    </label>
                                </div>
                                <button class="btn btn-green btn-marketing btn-block rounded-pill mt-4" type="submit">Créer mon lien personnel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="<?= JS ?>odometer.min.js"></script>
<script type="text/javascript">
    const updateCounter = () => {
        fetch('<?= APP_URL ?>api/count').then(response => response.json().then(json => {
            document.getElementById('counter').innerText = json.data.count;
        }));
    };
    setInterval(updateCounter, 10000);
    updateCounter();
</script>
