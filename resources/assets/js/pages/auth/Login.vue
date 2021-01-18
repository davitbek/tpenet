<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>
                        <div class="card-body">
                            <form method="POST" action="login">
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E Mail</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="" required autocomplete="email" autofocus>
<!--                                        @error('email')-->
                                        <span class="invalid-feedback" role="alert">
                                        <strong>message</strong>
                                    </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control " placeholder="Password" name="password" required autocomplete="current-password">
                                        <span class="invalid-feedback" role="alert">
                                        <strong>message</strong>
                                    </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" >
                                            <label class="form-check-label" for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                           Login
                                        </button>
                                        <router-link :to="{name:'reset'}">
                                            <a class="btn btn-link">
                                                Forgot Your Password
                                            </a>
                                        </router-link>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login"
}
</script>

<style scoped>

</style>
