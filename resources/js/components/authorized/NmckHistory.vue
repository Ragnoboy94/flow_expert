<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <ProfileTabMenu></ProfileTabMenu>
            <div class="mt-5">
                <DataTable :value="files" table-style="border-color: green">
                    <Column field="filename" header="Имя файла"></Column>
                    <Column field="created_at" header="Дата">
                        <template #body="{ data }">
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </template>
                    </Column>
                    <Column field="filename" header="Скачать черновик">
                        <template #body="{ data }">
                            <a :href="`/uploads/${data.filename}`" download>
                                <i class="pi pi-file-export feature-icon"></i>
                            </a>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "../Header.vue";
import Footer from "../Footer.vue";
import LoginButton from "../buttons/LoginButton.vue";
import TabView from "primevue/tabview";
import TabPanel from 'primevue/tabpanel';
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ProfileTabMenu from "./ProfileTabMenu.vue";


export default {
    components: {ProfileTabMenu, LoginButton, Header, Footer, TabView, TabPanel, DataTable, Column},
    data() {
        return {
            files: [],
        }
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
