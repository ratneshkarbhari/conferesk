<main class="page-content" id="login" style="padding: 3% 0;">

    <div class="row">

        <div class="col l4 m12 s12"></div>
        <div class="col l4 m12 s12">

            <div class="logo-container center">
                <img src="<?php echo site_url("assets/images/logo.jpeg"); ?>" class="w-50">
                <p class="red-text"><?php echo $error; ?></p>
            </div>            

            <form action="<?php echo site_url("login-exe"); ?>" method="post">

                <div class="mb-3">
                    <label for="department">Department</label>
                    <select name="department" id="department" >
                        <option value="admin">Admin</option>
                        <option value="marketing">Marketing</option>
                        <option value="sales">Sales</option>
                        <option value="hr">Human Resource</option>
                        <option value="design">Design</option>
                    </select>
                </div>

                <div class="input-field">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email">
                </div>

                <div class="input-field">
                    <label for="password">Password</label><span style="position: absolute; right: 0;cursor: pointer;" id="show-hide-pwd">Show Password</span>
                    <input type="password" name="password" id="password">
                </div>
                <script>
                $("span#show-hide-pwd").click(function (e) { 
                    e.preventDefault();
                    if($("input#password").attr("type")=="password"){
                        $("input#password").attr("type","text");
                        $("span#show-hide-pwd").html("Hide Password");
                    }else{
                        $("input#password").attr("type","password");
                        $("span#show-hide-pwd").html("Show Password");
                    }
                });
                </script>
                <button type="submit" class="btn w-100">Login</button>
            
            </form>

        </div>
        <div class="col l4 m12 s12"></div>
    
    </div>

</main>