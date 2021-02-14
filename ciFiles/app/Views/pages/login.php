<main class="page-content" id="login">

    <div class="row">

        <div class="col l4 m12 s12"></div>
        <div class="col l4 m12 s12">

            <div class="logo-container center">
                <img src="<?php echo site_url("assets/images/logo.jpeg"); ?>" class="w-50">
            </div>
            

            <form action="<?php echo site_url("login-exe"); ?>" method="post">

                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                </div>

                <div class="input-field">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password">
                </div>

                <button type="submit" class="btn w-100">Login</button>
            
            </form>

        </div>
        <div class="col l4 m12 s12"></div>
    
    </div>

</main>