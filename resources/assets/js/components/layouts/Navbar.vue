<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                    <div class="container">
                        <router-link :to="{name:'home'}">
                            <a class="nav-link">App Name</a>
                        </router-link>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
<!--                                @guest-->
<!--                                @if (Route::has('login'))-->
                                <li class="nav-item">
                                    <router-link :to="{name:'login'}">
                                        <a class="nav-link">Login</a>
                                    </router-link>
                                </li>
<!--                                @endif-->

<!--                                @if (Route::has('register'))-->
                                <li class="nav-item">
                                    <router-link :to="{name:'register'}">
                                        <a class="nav-link">Register</a>
                                    </router-link>
                                </li>
<!--                                @endif-->
<!--                                @else-->
                                <li v-if="false" class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        User Name
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item">
                                          Logout
                                        </a>
                                        <form id="logout-form" method="POST" class="d-none">
<!--                                            @csrf-->
                                        </form>
                                    </div>
                                </li>
<!--                                @endguest-->
                            </ul>
                        </div>
                    </div>
                </nav>
    </div>

</template>

<script>
export default {
name: "Navbar"
}
</script>

<style scoped>

</style>
