<template>
    <div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Verify E-Mail</div>

                        <div class="card-body">
                            @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                verifycation email
                            </div>
                            @endif

                            rfkjln rf
                            If you did not receive the email
                            <form class="d-inline" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">click request anhoter</button>.
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
    name: "Verify"
}
</script>

<style scoped>

</style>
