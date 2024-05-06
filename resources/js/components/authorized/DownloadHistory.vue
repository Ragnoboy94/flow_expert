<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <div>
                <TabMenu :model="items" :activeIndex="activeIndex"/>
            </div>
            <TabView>
                <TabPanel>
                    <template #header>
                        <Button class="consultation-button" label="Загруженная потребность"></Button>
                    </template>
                        <p class="m-0">
                            <DataTable :value="files" table-style="border-color: green">
                                <Column field="filename" header="Имя файла"></Column>
                                <Column field="created_at" header="Дата добавления">
                                    <template #body="{ data }">
                                        {{ new Date(data.created_at).toLocaleDateString() }}
                                    </template>
                                </Column>
                                <Column field="filename" header="Скачать исходный">
                                    <template #body="{ data }">
                                        <a :href="`/uploads/${data.filename}`" download>
                                            <i class="pi pi-file-export feature-icon"></i>
                                        </a>
                                    </template>
                                </Column>
                            </DataTable>
                        </p>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <Button class="consultation-button" label="Сформированный лот"></Button>
                    </template>
                    <p class="m-0">
                        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                        laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto
                        beatae vitae dicta sunt explicabo. Nemo enim
                        ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                        dolores eos qui ratione voluptatem sequi nesciunt. Consectetur, adipisci velit, sed quia non
                        numquam eius modi.
                    </p>
                </TabPanel>
                <TabPanel>
                    <template #header>
                        <Button class="consultation-button" label="Коммерческое предложение"></Button>
                    </template>
                    <p class="m-0">
                        At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum
                        deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non
                        provident, similique sunt in culpa qui
                        officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis
                        est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil
                        impedit quo minus.
                    </p>
                </TabPanel>
            </TabView>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import LoginButton from "../buttons/LoginButton.vue";
import TabMenu from "primevue/tabmenu";
import {mapActions, mapState} from "vuex";
import TabView from "primevue/tabview";
import TabPanel from 'primevue/tabpanel';
import DataTable from "primevue/datatable";
import Column from "primevue/column";


export default {
    components: {LoginButton, Header, Footer, TabMenu, TabView, TabPanel, DataTable, Column},
    data() {
        return {
            items: [
                {
                    label: 'Профиль пользователя', to: '/profile', command: () => {
                        this.navigate('/profile')
                    }
                },
                {
                    label: 'История загрузок', to: '/download_history', command: () => {
                        this.navigate('/download_history')
                    }
                },
                {
                    label: 'Черновик по расчёту нмцк', to: '/nmck_history', command: () => {
                        this.navigate('/nmck_history')
                    }
                },
            ],
        };
    },
    methods: {
        ...mapActions('upload', ['fetchFiles']),
        navigate(route) {
            this.$router.push(route);
        },
    },
    computed: {
        ...mapState('upload', ['files']),
        activeIndex() {
            const activeItem = this.items.findIndex(item => this.$route.path === item.to);
            return activeItem !== -1 ? activeItem : null;
        },
    },
    created() {
        this.fetchFiles();
    }

}
</script>

<style scoped>

.user-details h4 {
    margin-top: 0;
    font-size: 1.25em;
}

.user-details p {
    margin: 0.5em 0;
    font-size: 1em;
}

.card-landing2 {
    height: 100%;
    border: 2px solid #00A950;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
    border-radius: 7vh;
    text-decoration: none;
}

</style>
