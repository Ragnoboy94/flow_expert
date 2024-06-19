<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Вы не авторизованы</h3>
                <p>Для дальнейшего использования нашего сайта вам необходимо заказать консультацию или
                    авторизоваться</p>
            </div>
            <div class="flex align-items-stretch flex-column lg:flex-row">
                <div class="flex-1 mt-3 lg:col-6">
                    <ConsultationModal></ConsultationModal>
                </div>
                <div class="flex mt-3 lg:col-6">
                    <LoginButton></LoginButton>
                </div>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import ConsultationModal from "./buttons/ConsultationButton.vue";
import LoginButton from "./buttons/LoginButton.vue";
import {mapActions, mapState} from "vuex";

export default {
    components: {LoginButton, ConsultationModal, Header, Footer},
    computed: {
        ...mapState('auth', ['isAuthenticated'])
    },
    methods: {
        ...mapActions('auth', ['checkAuthentication']),
        redirectIfAuthenticated() {
            if (this.isAuthenticated) {
                const redirectUrl = this.$route.query.redirect || '/';
                this.$router.push(redirectUrl);
            }
        }
    },
    created() {
        this.checkAuthentication().then(() => {
            this.redirectIfAuthenticated();
        });
    }
}
</script>

<style scoped>
.title-section p {
    font-size: 1.5em;
    color: #333;
    text-indent: 0;
}
</style>
