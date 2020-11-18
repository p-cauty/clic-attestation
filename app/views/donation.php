<section class="bg-light py-2">
    <div class="container p-0">
        <div class="row align-items-center justify-content-center text-center">
            <div class="col-md-6">
                <small>Vous êtes chaque jour plus nombreux à utiliser <?= NAME ?> et nous en sommes ravis ! Aidez-nous
                    à maintenir le service:</small>
            </div>
            <div class="col-md-6">
                <form action="https://www.paypal.com/donate" method="post" target="_top" class="mt-2">
                    <input type="hidden" name="hosted_button_id" value="XGV4DEC6WVFYL"/>
                    <input type="image" class="img-fluid"
                           src="<?= IMG ?>paypal_btn.png" border="0"
                           name="submit" title="PayPal - The safer, easier way to pay online!"
                           alt="Donate with PayPal button"/>
                </form>
            </div>
        </div>
    </div>
</section>
