<?php
use App\Core\Forms\Form;
$this->title = 'Sign in';
$this->stylesheets = ['/css/sign_in.css'];
?>
<section class="section">
    <div class="columns">
        <h1 class="title">Sign in</h1>
        <div class="box">
            <?php
            if (empty($model)) {
                exit('Model is empty');
            }
            $form = new Form('POST', '', 'signing-form', 'signingForm');
            $form->begin();
            ?>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <?php echo $form->inputField($model, 'email', ['type' => 'email', 'name' => 'email', 'placeholder' => 'enter your email', 'required' => 'required']) ?>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
                <?php echo $form->inputField($model, 'password', ['type' => 'password', 'name' => 'password', 'placeholder' => 'enter your password', 'required' => 'required']) ?>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">
                Sign in
            </button>

            <?php $form->end(); ?>
        </div>
    </div>


</section>