import { mapState } from 'vuex';

export default {
    computed: {
        ...mapState({
            userData: state => state.user.userData,
            mainData: state => state.app.mainData,
            isLoggedIn: state => state.auth.isAuthenticated,
        })
    }
}
