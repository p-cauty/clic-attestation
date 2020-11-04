<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Request;

?>
<header class="page-header page-header-dark bg-img-repeat bg-blue pt-3 pt-lg-10" style='background-image: url("<?= IMG ?>pattern-shapes.png")'>
    <div class="page-header-content">
        <div class="container px-2">
            <div class="row align-items-center">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <?= Alert::handle() ?>
                    <div class="alert alert-warning text-center">
                        Si vous rencontrez un problème avec votre date de naissance,
                        <a href="<?= WEBROOT ?>">générez un nouveau lien</a>, tout devrait fonctionner.
                    </div>
                    <div class="card rounded-lg text-dark mb-2">
                        <div class="card-header py-4"><?= $firstname ?>, générez dès maintenant votre attestation !</div>
                        <div class="card-body">
                            <form method="get" action="<?= WEBROOT ?>attestation/<?= Request::get()->getArg(1) ?>">
                                <div class="form-group">
                                    <label class="small text-gray-600" for="reason">Motif du déplacement</label>
                                    <select class="form-control rounded-pill" id="reason" name="reason" required>
                                        <option value="">-- Choisissez un motif --</option>
                                        <option value="travail">Déplacement sur le lieu de travail</option>
                                        <option value="achats">Achats de première nécessité</option>
                                        <option value="sante">Consultations et examens de santé</option>
                                        <option value="famille">Motif familial impérieux ou assistance aux personnes</option>
                                        <option value="handicap">Accompagnement des personnes en situation de handicap</option>
                                        <option value="sport_animaux">Sport & animaux</option>
                                        <option value="convocation">Convocation judiciaire ou administrative</option>
                                        <option value="missions">Participation à des missions d'intérêt général</option>
                                        <option value="enfants">Déplacement pour chercher les enfants à l’école</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="made_in">Fait à</label>
                                        <input class="form-control rounded-pill" id="made_in" name="made_in" type="text" placeholder="Ville" value="<?= $made_in ?>" required />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="small text-gray-600" for="output">Type de rendu</label>
                                        <select class="form-control rounded-pill" id="output" name="output">
                                            <option value="show" selected>Afficher</option>
                                            <option value="download">Télécharger</option>
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-green btn-marketing btn-block rounded-pill mt-4" type="submit">Générer mon attestation</button>
                            </form>
                        </div>
                    </div>
                    <div class="alert alert-info text-center">N'oubliez pas de mettre cette page en favoris pour ne pas la perdre !</div>
                </div>
            </div>
        </div>
    </div>
</header>
