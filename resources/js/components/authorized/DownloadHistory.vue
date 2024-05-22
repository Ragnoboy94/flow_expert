<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <ProfileTabMenu></ProfileTabMenu>
            <TabView>
                <TabPanel>
                    <template #header>
                        <Button class="consultation-button" label="Загруженная потребность"></Button>
                    </template>
                        <p class="m-0">
                            <DataTable :value="files" table-style="border-color: green">
                                <Column field="filename" header="Имя файла"></Column>
                                <Column field="created_at" header="Дата загрузки">
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
                                <Column field="filename" header="Скачать обработанный">
                                    <template #body="{ data }">
                                        <a v-if="data.new_filename" :href="`/processed_files/${data.new_filename}`" download>
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
                        <DataTable :value="files" table-style="border-color: green">
                            <Column field="filename" header="Имя файла"></Column>
                            <Column field="created_at" header="Дата загрузки">
                                <template #body="{ data }">
                                    {{ new Date(data.created_at).toLocaleDateString() }}
                                </template>
                            </Column>
                            <Column field="filename" header="Cкачать исходный файл ">
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
                        <Button class="consultation-button" label="Коммерческое предложение"></Button>
                    </template>
                    <p class="m-0">
                        <DataTable :value="offers" table-style="border-color: green">
                            <Column field="filename" header="Имя файла">
                                <template #body="{ data }">
                                    КОММЕРЧЕСКОЕ ПРЕДЛОЖЕНИЕ
                                </template>
                            </Column>
                            <Column field="created_at" header="Дата загрузки">
                                <template #body="{ data }">
                                    {{ new Date(data.created_at).toLocaleDateString() }}
                                </template>
                            </Column>
                            <Column field="file_status_id" header="Скачать обработанный">
                                <template #body="{ data }">
                                    <a v-if="data.file_status_id === 3" :href="`/offers_export/${data.excel_file_path}`" download>
                                        <i class="pi pi-file-export feature-icon"></i>
                                    </a>
                                    <span v-else>
                                        Файл находится в процессе обработки!
                                    </span>
                                </template>
                            </Column>
                        </DataTable>
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
import offers from "./Offers.vue";
import ProfileTabMenu from "./ProfileTabMenu.vue";


export default {
    components: {ProfileTabMenu, LoginButton, Header, Footer, TabMenu, TabView, TabPanel, DataTable, Column},
    methods: {
        ...mapActions('upload', ['fetchFiles', 'fetchOffers']),
    },
    computed: {
        ...mapState('upload', ['files', 'offers']),
    },
    created() {
        this.fetchFiles();
        this.fetchOffers();
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
