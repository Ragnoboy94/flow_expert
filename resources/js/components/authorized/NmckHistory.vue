<template>
    <Header></Header>
    <section class="landing-block2 about-section">
        <div class="content-container">
            <ProfileTabMenu></ProfileTabMenu>
            <div class="mt-5">
                <DataTable :value="nmckFiles" table-style="border-color: green">
                    <Column field="filename" header="Имя файла">
                        <template #body>
                            Сформированное НМЦК
                        </template>
                    </Column>
                    <Column field="created_at" header="Дата">
                        <template #body="{ data }">
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </template>
                    </Column>
                    <Column field="filename" header="Скачать черновик">
                        <template #body="{ data }">
                            <a :href="`${data.filename}`" download>
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
import ProfileTabMenu from "./ProfileTabMenu.vue";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import {mapState, mapActions} from "vuex";

export default {
    components: {ProfileTabMenu, Header, Footer, DataTable, Column},
    data() {
        return {};
    },
    computed: {
        ...mapState('upload', ['nmckFiles']),
    },
    methods: {
        ...mapActions('upload', ['fetchNmckFiles']),
    },
    created() {
        this.fetchNmckFiles();
    }
}
</script>

<style scoped>
.about-section {
    padding: 20px;
}
</style>
