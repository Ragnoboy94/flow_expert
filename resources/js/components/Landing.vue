<template>
    <Header/>
    <LandingBody1></LandingBody1>
    <LandingBody2></LandingBody2>
    <LandingBody3></LandingBody3>
    <LandingBody4></LandingBody4>
    <LandingBody5></LandingBody5>
    <LandingBody7/>
    <ConfirmationModal />
    <Dialog v-model:visible="showUserConfirmationDialog" header="Пользователь успешно зарегистрирован!" :modal="true" :showHeader="true" :dismissableMask="true" class="xl:w-6 lg:w-7 md:w-8 sm:w-9">
        <div class="text-center text-success">
            <p>Пользователь был успешно подтвержден. Теперь он можете пользоваться всеми функциями платформы.</p>
        </div>
    </Dialog>
    <Footer/>
</template>

<script>
import Header from "./Header.vue";
import LandingBody1 from "./LandingBody1.vue";
import LandingBody2 from "./LandingBody2.vue";
import LandingBody3 from "./LandingBody3.vue";
import LandingBody4 from "./LandingBody4.vue";
import LandingBody5 from "./LandingBody5.vue";
import LandingBody7 from "./LandingBody7.vue";
import Footer from "./Footer.vue";
import ConfirmationModal from "./ConfirmationModal.vue";
import Dialog from "primevue/dialog";
import {mapActions, mapMutations, mapState} from "vuex";

export default {
    name: 'Landing',
    components: {
        Footer,
        LandingBody7,
        Header,
        LandingBody5,
        LandingBody4,
        LandingBody3,
        LandingBody2,
        LandingBody1,
        ConfirmationModal,
        Dialog
    },
    data() {
        return {
            showUserConfirmationDialog: false
        };
    },
    async created() {
        const urlParams = new URLSearchParams(window.location.search);
        const uuid = urlParams.get('uuid');
        const accessToken = urlParams.get('access_token');

        if (uuid) {
            const response = await this.confirmOrganization(uuid);
            if (response) {
                this.SET_UUID(uuid);
                this.SET_CONFIRMATION_DIALOG(true);
            }
            const url = new URL(window.location);
            url.searchParams.delete('uuid');
            window.history.replaceState({}, document.title, url);
        }

        if (accessToken) {
            const response = await this.confirmUser(accessToken);
            if (response) {
                this.showUserConfirmationDialog = true;
            }
            const url = new URL(window.location);
            url.searchParams.delete('access_token');
            window.history.replaceState({}, document.title, url);
        }
    },
    methods: {
        ...mapMutations('organization', ['SET_UUID', 'SET_CONFIRMATION_DIALOG']),
        ...mapActions('organization', ['confirmOrganization', 'confirmUser']),
    }
};
</script>
