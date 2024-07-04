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
                                <Column field="author" header="Загрузил"></Column>
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
                        <div v-for="file in files_ready" :key="file.id" class="mb-4">
                            <InlineMessage class="w-full" severity="success">{{ file.filename }} | Загрузил: {{ file.author }}</InlineMessage>
                            <template v-if="categoriesByFile[file.id] && categoriesByFile[file.id].length">
                                <DataTable :value="categoriesByFile[file.id]" table-style="border-color: green">
                                    <Column field="category" header="Наименование категории">
                                        <template #body="{ data }">
                                            {{ data.category || 'Без категории' }}
                                        </template>
                                    </Column>
                                    <Column field="created_at" header="Дата загрузки">
                                        <template #body="{ data }">
                                            {{ new Date(data.created_at).toLocaleDateString() }}
                                        </template>
                                    </Column>
                                    <Column field="category" header="Скачать файл">
                                        <template #body="{ data }">
                                            <a @click.prevent="downloadCategory(file.id, data.drug_category_id)">
                                                <i class="pi pi-file-export feature-icon"></i>
                                            </a>
                                        </template>
                                    </Column>
                                </DataTable>
                            </template>
                            <template v-else>
                                <p>Предложение не разбито на лоты</p>
                            </template>
                        </div>
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
                            <Column field="author" header="Загрузил"></Column>
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
import ProfileTabMenu from "./ProfileTabMenu.vue";
import InlineMessage from "primevue/inlinemessage";


export default {
    components: {ProfileTabMenu, LoginButton, Header, Footer, TabMenu, TabView, TabPanel, DataTable, Column, InlineMessage},
    data() {
        return {
            categoriesByFile: {}
        };
    },
    methods: {
        ...mapActions('upload', ['fetchFiles', 'fetchReadyFiles', 'fetchOffers', 'downloadCategoryFile', 'fetchExcelRows']),
        async downloadCategory(fileId, categoryId) {
            const response = await this.downloadCategoryFile({ fileId, categoryId });
            window.open(response, '_blank');
        },
        async getCategories(file) {
            const rows = await this.fetchExcelRows(file.id);
            const categories = Object.keys(rows || {}).map(category => {
                const categoryId = rows[category][0]?.drug_category_id || 'no-category';
                return {
                    category: category !== 'Без категории' ? category : null,
                    created_at: file.created_at,
                    fileId: file.id,
                    drug_category_id: categoryId
                };
            });
            this.categoriesByFile = { ...this.categoriesByFile, [file.id]: categories };
        }
    },
    computed: {
        ...mapState('upload', ['files', 'files_ready', 'offers']),
    },
    watch: {
        files_ready: {
            immediate: true,
            handler(newFiles) {
                newFiles.forEach(file => {
                    this.getCategories(file);
                });
            }
        }
    },
    created() {
        this.fetchFiles();
        this.fetchReadyFiles();
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
