<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Confirm Password</div>

                        <div class="card-body">
                            Please confirm your password before continuing

                            <form method="POST">
<!--                                @csrf-->

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password">

<!--                                        @error('password')-->
                                        <span class="invalid-feedback" role="alert">
                                        <strong>Password</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Confirm Password
                                        </button>

<!--                                        @if (Route::has('password.request'))-->
                                        <a class="btn btn-link" href="#">
                                            Forgot Your Password
                                        </a>
<!--                                        @endif-->
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
    name: "Confirm"
}
</script>

<style scoped>

</style>
