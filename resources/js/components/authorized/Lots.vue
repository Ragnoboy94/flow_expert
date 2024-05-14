<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Формирование лотов</h3>
            </div>
            <div class="flex justify-content-end">
                <router-link to="demand">
                    <Button link class="text-green-500" label="Как сформировать потребность?"></Button>
                </router-link>
            </div>
            <div class="files-table mt-3">
                <DataTable :value="files" table-style="border-color: green">
                    <Column field="filename" header="Имя файла"></Column>
                    <Column field="status_name" header="Статус"></Column>
                    <Column field="count_row" header="Количество позиций"></Column>
                    <Column field="law" header="Выберите закон-основания">
                        <template #body="{ data }">
                            <div>
                                <div class="flex align-items-center">
                                    <RadioButton v-model="selectedLaw[data.id]" :inputId="'fz44-' + data.id" name="law-{{ data.id }}" value="44-ФЗ" />
                                    <label :for="'fz44-' + data.id" class="ml-2">44-ФЗ</label>
                                </div>
                                <div class="flex align-items-center">
                                    <RadioButton v-model="selectedLaw[data.id]" :inputId="'fz223-' + data.id" name="law-{{ data.id }}" value="223-ФЗ" />
                                    <label :for="'fz223-' + data.id" class="ml-2">223-ФЗ</label>
                                </div>
                            </div>
                        </template>
                    </Column>
                    <Column field="id">
                        <template #body="{ data }">
                            <Button link class="text-green-500" label="РАЗБИТЬ НА ЛОТЫ" @click="splitLots(data.id)"/>
                        </template>
                    </Column>
                    <Column field="id">
                        <template #body="{ data }">
                            <Button link class="text-green-500" label="ОТКРЫТЬ" :disabled="!data.split_into_lots" @click="toggleDetails(data.id)"/>
                        </template>
                    </Column>
                    <Column field="created_at" header="Дата загрузки">
                        <template #body="{ data }">
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </template>
                    </Column>
                </DataTable>
            </div>
            <div v-for="file in files" :key="file.id">
                <div v-if="file.showDetails" class="details-table mt-3">
                    <DataTable :value="file.excelRows" table-style="border-color: green">
                        <Column field="department" header="Отделение"></Column>
                        <Column field="item_name" header="Наименование"></Column>
                        <Column field="unit" header="Ед. изм."></Column>
                        <Column field="quantity" header="Количество"></Column>
                        <Column field="price" header="Цена"></Column>
                        <Column field="sum" header="Сумма"></Column>
                        <Column field="funding_source" header="Источник финансирования"></Column>
                        <Column field="found" header="Найдено"></Column>
                    </DataTable>
                </div>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import { mapActions, mapState } from "vuex";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import RadioButton from "primevue/radiobutton";
import Button from "primevue/button";

export default {
    components: { Header, Footer, DataTable, Column, RadioButton, Button },
    data() {
        return {
            selectedLaw: {}
        };
    },
    computed: {
        ...mapState('upload', ['files']),
    },
    methods: {
        ...mapActions('upload', ['fetchReadyFiles', 'splitLotsAPI', 'fetchExcelRows']),
        initializeSelectedLaw() {
            this.files.forEach(file => {
                this.selectedLaw = {
                    ...this.selectedLaw,
                    [file.id]: file.law || '44-ФЗ'
                };
            });
        },
        async splitLots(fileId) {
            const selectedLaw = this.selectedLaw[fileId];
            await this.splitLotsAPI({ fileId, selectedLaw });
        },
        toggleDetails(fileId) {
            const file = this.files.find(f => f.id === fileId);
            if (file) {
                file.showDetails = !file.showDetails;
                if (file.showDetails && !file.excelRows) {
                    this.fetchExcelRows(fileId).then(rows => {
                        file.excelRows = rows;
                    });
                }
            }
        }
    },
    watch: {
        files: {
            handler: 'initializeSelectedLaw',
            immediate: true,
            deep: true
        }
    },
    created() {
        this.fetchReadyFiles();
    }
}
</script>

<style scoped>
.title-section p {
    font-size: 1.5em;
    color: #333;
}

.files-table table {
    width: 100%;
    border-collapse: collapse;
}

.files-table th, .files-table td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}
</style>
