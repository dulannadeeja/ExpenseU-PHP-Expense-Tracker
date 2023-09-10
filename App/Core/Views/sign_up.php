<?php use App\Core\Forms\Form; ?>
<!-- Section: Design Block -->
<section class="">
    <!-- Jumbotron -->
    <div class="px-4 py-5 px-md-5 text-center text-lg-start" style="background-color: hsl(0, 0%, 96%)">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="my-5 display-3 fw-bold ls-tight">
                        The best offer <br />
                        <span class="text-primary">for your business</span>
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Eveniet, itaque accusantium odio, soluta, corrupti aliquam
                        quibusdam tempora at cupiditate quis eum maiores libero
                        veritatis? Dicta facilis sint aliquid ipsum atque?
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-5 px-md-5">
                            <?php
                            if(empty($model)){
                                exit('Model is empty');
                            }
                            $form = new Form('POST','','signup-form','signupForm');
                            $form->begin();
                            ?>
                                <!-- 2 column grid layout with text inputs for the first and last names -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <?php echo $form->inputField($model, 'firstName',['type'=>'text','name'=>'firstName','placeholder'=>'enter your first name','required'=>'required']) ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-outline">
                                            <?php echo $form->inputField($model, 'lastName',['type'=>'text','name'=>'lastName','placeholder'=>'enter your last name','required'=>'required']) ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <?php echo $form->inputField($model, 'email',['type'=>'email','name'=>'email','placeholder'=>'enter your email','required'=>'required']) ?>
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <?php echo $form->inputField($model, 'password',['type'=>'password','name'=>'password','placeholder'=>'enter your password','required'=>'required']) ?>
                                </div>

                                <!-- Confirm Password input -->
                                <div class="form-outline mb-4">
                                    <?php echo $form->inputField($model, 'confirmPassword',['type'=>'password','name'=>'confirmPassword','placeholder'=>'confirm your password','required'=>'required']) ?>
                                </div>

                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">
                                    Sign up
                                </button>

                                <!-- Register buttons -->
                                <div class="text-center">
                                    <p>or sign up with:</p>
                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-facebook-f"></i>
                                    </button>

                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-google"></i>
                                    </button>

                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-twitter"></i>
                                    </button>

                                    <button type="button" class="btn btn-link btn-floating mx-1">
                                        <i class="fab fa-github"></i>
                                    </button>
                                </div>
                            <?php $form->end(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jumbotron -->
</section>
<!-- Section: Design Block -->