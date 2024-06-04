<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Получение приведённой потребности</h3>
                <p>Скачайте шаблон и заполните его. Далее загрузите заполненный документ в формате Excel.</p>
            </div>
            <div class="flex align-items-stretch flex-column lg:flex-row">
                <div class="flex mt-3 lg:col-6">
                    <a href="/downloads/template.xlsx" class="w-12" download="privedonnaya_potrebnost.xlsx">
                        <Button class="consultation-button h-3rem" label="Скачать шаблон" icon="pi pi-file-export"
                                icon-pos="right"/>
                    </a>
                </div>
                <div class="flex mt-3 lg:col-6">
                    <input type="file" ref="fileInput" @change="handleFileUpload" accept=".xlsx"
                           style="display: none;"/>
                    <Button class="consultation-button h-3rem text-green-500 bg-white border-green-500 border-1"
                            label="Загрузить файл" icon="pi pi-upload" icon-pos="right" @click="triggerFileInput"/>
                </div>
            </div>
            <span v-if="uploadStatus" style="color: green">{{ uploadStatus }}</span>
            <div v-if="files.length" class="files-table mt-3">
                <h4>Загруженные файлы:</h4>
                <DataTable :value="files">
                    <Column field="filename" header="Имя файла"></Column>
                    <Column field="count_accept" header="Позиций связано"></Column>
                    <Column field="count_failed" header="Позиций не связано"></Column>
                    <Column field="status_name" header="Статус">
                        <template class="text-center" #body="{ data }">
                            {{data.status_name}}
                            <div v-if="data.status_name === 'Обработка'">
                                <ProgressBar :value="progressValues[data.id]" :showValue="true"></ProgressBar>
                            </div>
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
                    <Column field="created_at" header="Дата">
                        <template #body="{ data }">
                            {{ new Date(data.created_at).toLocaleDateString() }}
                        </template>
                    </Column>
                    <Column field="error_description" header="Ошибки"></Column>
                    <Column field="id">
                        <template #body="{ data }">
                            <Button v-if="data.status_name === 'Готов'  || data.status_name === 'Ошибка'" link icon-pos="right" icon="pi pi-trash" @click="deleteData = data; deleteDialogVisible = true"/>
                        </template>
                    </Column>
                </DataTable>
                <Dialog header="Удалить?" v-if="deleteData" v-model:visible="deleteDialogVisible" @update:visible="handleDialogDeleteVisibilityChange" :modal="true" :closable="true"
                        :showHeader="true" :style="{ width: '450px' }">
                    <span class="p-text-secondary block mb-5">Запись {{ deleteData.filename}} и файлы будут удалены! Уверены?</span>

                    <div class="flex justify-content-end gap-2">
                        <Button class="consultation-button" type="button" label="Удалить" @click="deleteDialogVisible = false; deleteDemand(deleteData.id) ; deleteData = null"></Button>
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
import ProgressBar from "primevue/progressbar";
import Dialog from "primevue/dialog";

export default {
    components: { Header, Footer, DataTable, Column, ProgressBar, Dialog },
    data() {
        return {
            selectedFile: null,
            openSource: false,
            intervalId: null,
            progressIntervalId: null,
            progressValues: {},
            deleteDialogVisible: false,
            deleteData: null
        };
    },
    computed: {
        ...mapState('upload', ['uploadStatus', 'files']),
    },
    methods: {
        ...mapActions('upload', ['uploadFile', 'fetchFiles', 'deleteDemand']),
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.uploadFile(file).then(() => {
                    this.fetchFiles();
                    setTimeout(() => {
                        this.fetchFiles();
                    }, 5000);
                });
                this.$refs.fileInput.value = '';
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        refreshData() {
            this.fetchFiles();
        },
        calculateProgress(createdAt) {
            const createdTime = new Date(createdAt).getTime();
            const currentTime = new Date().getTime();
            const elapsedTime = (currentTime - createdTime) / 1000;
            const totalDuration = 10 * 60;
            const progress = (elapsedTime / totalDuration) * 100;
            return Math.min(progress, 100).toFixed(1);
        },
        updateProgressValues() {
            this.files.forEach(file => {
                if (file.status_name === 'Обработка') {
                    const progress = this.calculateProgress(file.created_at);
                    this.progressValues = {
                        ...this.progressValues,
                        [file.id]: this.calculateProgress(file.created_at)
                    };
                }
            });
        },
        handleDialogDeleteVisibilityChange () {
            this.deleteData = null;
        }
    },
    created() {
        this.fetchFiles();
        this.intervalId = setInterval(() => {
            this.refreshData();
        }, 60000);
        this.progressIntervalId = setInterval(() => {
            this.updateProgressValues();
        }, 1000);
    },
    beforeUnmount() {
        clearInterval(this.intervalId);
        clearInterval(this.progressIntervalId);
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
