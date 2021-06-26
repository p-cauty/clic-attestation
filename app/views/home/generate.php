<?php

use PitouFW\Core\Alert;
use PitouFW\Core\Request;
use PitouFW\Core\Utils;

?>
<header class="page-header page-header-dark bg-img-repeat bg-blue pt-3 pt-lg-10" style='background-image: url("<?= IMG ?>pattern-shapes.png")'>
    <div class="page-header-content">
        <div class="container px-4">
            <div class="row align-items-center">
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <?= Alert::handle() ?>
                    <div class="notice alert alert-info text-center">
                        Les restrictions sanitaires, c'est terminé depuis le Dimanche 20 Juin 2021 ! Allez donc profiter
                        de la vie !
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
