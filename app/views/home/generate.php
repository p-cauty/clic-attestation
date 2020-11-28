<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Request;

?>
<header class="page-header page-header-dark bg-img-repeat bg-blue pt-3 pt-lg-10" style='background-image: url("<?= IMG ?>pattern-shapes.png")'>
    <div class="page-header-content">
        <div class="container px-4">
            <div class="row align-items-center">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <?= Alert::handle() ?>
                    <?php if($birth_date === '01/01/1970'): ?>
                        <div id="birthdate-alert" class="notice alert alert-warning text-center">
                            <span class="alert-close" onclick="closeNotice('birthdate-alert')" title="Ne plus afficher ce message">&times;</span>
                            Êtes-vous né le 01/01/1970 ? Si oui, vous pouvez ignorer ce message. Si non,
                            <a href="<?= WEBROOT ?>">générez un nouveau lien</a>.
                        </div>
                    <?php endif ?>
                    <div id="v2-alert" class="notice alert alert-success text-center">
                        <span class="alert-close" onclick="closeNotice('v2-alert')" title="Ne plus afficher ce message">&times;</span>
                        <?= NAME ?> est déjà compatible avec la nouvelle attestation du 28 Novembre !
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
                                        <option value="achats_culturel_cultuel">Achats de première nécessité</option>
                                        <option value="achats_culturel_cultuel">Établissement culturel ou lieu de culte</option>
                                        <option value="sante">Consultations et examens de santé</option>
                                        <option value="famille">Motif familial impérieux</option>
                                        <option value="famille">Assistance aux personnes</option>
                                        <option value="famille">Garde d'enfants</option>
                                        <option value="handicap">Personnes en situation de handicap</option>
                                        <option value="sport_animaux">Sport & animaux (3h à 20km)</option>
                                        <option value="convocation">Convocation judiciaire ou administrative</option>
                                        <option value="convocation">Service public</option>
                                        <option value="missions">Missions d'intérêt général</option>
                                        <option value="enfants">École et activités périscolaires</option>
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
                    <div id="bookmark-alert" class="notice alert alert-info text-center">
                        <span class="alert-close" onclick="closeNotice('bookmark-alert')" title="Ne plus afficher ce message">&times;</span>
                        N'oubliez pas de mettre cette page en favoris pour ne pas la perdre
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
