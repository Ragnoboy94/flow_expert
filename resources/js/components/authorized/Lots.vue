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
                <DataTable v-model:expandedRows="expandedRows" :value="files" dataKey="id"
                           tableStyle="border-color: green">
                    <Column field="filename" header="Имя файла"></Column>
                    <Column field="status_name" header="Статус"></Column>
                    <Column field="count_row" header="Количество позиций"></Column>
                    <Column field="law" header="Выберите закон-основания">
                        <template #body="{ data }">
                            <div>
                                <div class="flex align-items-center">
                                    <RadioButton v-model="selectedLaw[data.id]" :inputId="'fz44-' + data.id"
                                                 name="law-{{ data.id }}" value="44-ФЗ"/>
                                    <label :for="'fz44-' + data.id" class="ml-2">44-ФЗ</label>
                                </div>
                                <div class="flex align-items-center">
                                    <RadioButton v-model="selectedLaw[data.id]" :inputId="'fz223-' + data.id"
                                                 name="law-{{ data.id }}" value="223-ФЗ"/>
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
                            <Button link class="text-green-500" :label="isRowExpanded(data) ? 'ЗАКРЫТЬ' : 'ОТКРЫТЬ'" :disabled="!data.split_into_lots" @click="toggleRowExpansion(data)"/>
                        </template>
                    </Column>
                    <Column field="created_at" header="Дата загрузки">
                        <template #body="{ data }">
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </template>
                    </Column>
                    <template #expansion="{ data }">
                        <div class="p-3">
                            <template v-if="loadingRows[data.id]">
                                <Skeleton width="100%" height="2rem" class="mb-2" borderRadius="16px" />
                                <Skeleton width="100%" height="2rem" class="mb-2" borderRadius="16px" />
                                <Skeleton width="100%" height="2rem" class="mb-2" borderRadius="16px" />
                            </template>
                            <template v-else>
                                <div v-for="(rows, category) in data.excelRows" :key="category" class="border-1 border-green-400 mb-4">
                                    <DataTable :value="rows">
                                        <Column field="item_name">
                                            <template #header class="flex-none">
                                                <div class="flex justify-content-between align-items-center xl:w-12 lg:w-8 md:w-5 sm:w-3">
                                                    <InlineMessage class="w-full" severity="success">{{ category }}</InlineMessage>
                                                    <div class="flex">
                                                        <Button icon="pi pi-pencil" class="p-button-text p-button-success" @click="editCategory(category, data.id)" />
                                                        <Button icon="pi pi-download" class="p-button-text p-button-success" @click="downloadCategory(rows)" />
                                                    </div>
                                                </div>
                                            </template>
                                        </Column>
                                    </DataTable>
                                </div>
                                <div v-if="!Object.keys(data.excelRows).length">Лот еще не разбит</div>
                            </template>
                        </div>
                    </template>
                </DataTable>
                <Dialog v-model:visible="editDialogVisible" class="xl:w-8 lg:w-9 md:w-10 sm:w-11 w-12" :modal="true"
                        :dismissableMask="true" header="Редактировать строки категории">
                    <template #header>
                        <div class="text-center">
                            <span class="font-bold text-header">Редактировать строки категории</span>
                        </div>
                    </template>
                    <DataTable :value="editCategoryRows" editMode="cell" @cell-edit-complete="saveEdit">
                        <Column field="department" header="Отделение" style="width: 10%">
                            <template #body ="{ data }">
                                <InputText class="w-12" v-model="data.department" />
                            </template>
                        </Column>
                        <Column field="item_name" header="Наименование" style="width: 30%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.item_name" />
                            </template>
                        </Column>
                        <Column field="release_form" header="Форма выпуска" style="width: 10%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.release_form" />
                            </template>
                        </Column>
                        <Column field="unit" header="Ед. изм." style="width: 10%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.unit" />
                            </template>
                        </Column>
                        <Column field="quantity" header="Количество" style="width: 10%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.quantity" />
                            </template>
                        </Column>
                        <Column field="price" header="Цена" style="width: 10%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.price" />
                            </template>
                        </Column>
                        <Column field="sum" header="Сумма" style="width: 10%">
                            <template #body="{ data }">
                                <InputText class="w-12" v-model="data.sum" />
                            </template>
                        </Column>
                        <Column field="drug_category" header="Категория" style="width: 10%">
                            <template #body="{ data }">
                                <Dropdown :options="categories" optionLabel="name" v-model="data.drug_category"  class="w-full" />
                            </template>
                        </Column>
                    </DataTable>
                    <div class="p-dialog-footer">
                        <Button label="Отмена" icon="pi pi-times" @click="editDialogVisible = false" class="p-button-text" />
                        <Button label="Сохранить" icon="pi pi-check" @click="saveEdit" class="p-button-text" />
                    </div>
                </Dialog>
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
import Skeleton from "primevue/skeleton";
import InlineMessage from "primevue/inlinemessage";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Dropdown from "primevue/dropdown";

export default {
    components: { Header, Footer, DataTable, Column, RadioButton, Skeleton, InlineMessage, Dialog, InputText, Dropdown },
    data() {
        return {
            selectedLaw: {},
            expandedRows: {},
            loadingRows: {},
            editingRows: {},
            editDialogVisible: false,
            editCategoryRows: [],
            editCategory: null,
            currentFileId: null
        };
    },
    computed: {
        ...mapState('upload', ['files', 'categories']),
    },
    methods: {
        ...mapActions('upload', ['fetchReadyFiles', 'splitLotsAPI', 'fetchExcelRows', 'updateExcelRows', 'fetchCategories']),
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
        async toggleRowExpansion(file) {
            const updatedExpandedRows = { ...this.expandedRows };
            if (updatedExpandedRows[file.id]) {
                delete updatedExpandedRows[file.id];
                this.expandedRows = updatedExpandedRows;
            } else {
                this.loadingRows = { ...this.loadingRows, [file.id]: true };
                this.expandedRows = { ...this.expandedRows, [file.id]: true };

                const rows = await this.fetchExcelRows(file.id);
                file.excelRows = rows;

                this.loadingRows = { ...this.loadingRows, [file.id]: false };
            }
        },
        isRowExpanded(file) {
            return !!this.expandedRows[file.id];
        },
        editCategory(category, fileId) {
            this.currentFileId = fileId;
            const file = this.files.find(f => f.id === fileId);
            if (file && file.excelRows && file.excelRows[category]) {
                this.editCategoryRows = JSON.parse(JSON.stringify(file.excelRows[category]));
            }
            this.editCategory = category;
            this.editDialogVisible = true;
        },
        async saveEdit() {
            const fileIndex = this.files.findIndex(file => file.excelRows && file.excelRows[this.editCategory]);
            if (fileIndex !== -1) {
                const cleanedRows = this.editCategoryRows.map(row => {
                    const { drug_category, ...cleanedRow } = row;
                    if (drug_category && typeof drug_category === 'object') {
                        cleanedRow.drug_category_id = drug_category.id;
                    } else {
                        cleanedRow.drug_category_id = null;
                    }
                    return cleanedRow;
                });
                this.files[fileIndex].excelRows[this.editCategory] = this.editCategoryRows;
                await this.updateExcelRows({ fileId: this.files[fileIndex].id, rows: cleanedRows });
            }
            this.editDialogVisible = false;
        },
        downloadCategory(rows) {
            // Логика для скачивания категории
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
        this.fetchCategories();
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
.text-header {
    color: #00a950;
    text-align: center;
}
</style>
