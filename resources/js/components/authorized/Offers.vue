<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container" style="max-width: 100%;">
            <div class="title-section">
                <h3>Формирование коммерческих предложений</h3>
                <p>Укажите данные</p>
            </div>
            <form @submit.prevent="submitOfferForm">
                <div class="flex flex-column lg:flex-row">
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText class="field" v-model="formData.sender" required/>
                            <label for="formData.sender">От кого предложение</label>
                        </FloatLabel>
                    </div>
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText type="date" class="field" v-model="formData.date" required/>
                            <label for="formData.date">Дата</label>
                        </FloatLabel>

                    </div>
                    <div class="flex mt-3 lg:col-3">
                        <FloatLabel class="w-12">
                            <InputText v-mask="'#########'" class="field" v-model="formData.positions"
                                       required/>
                            <label class="mb-1" for="formData.positions">Сколько позиций</label>
                        </FloatLabel>
                    </div>
                    <div class="flex lg:col-3" style="margin-top: 0.9rem; margin-bottom: 0.4rem;">
                        <Button label="Выбрать файл" @click="triggerFileInput"
                                class="consultation-button text-green-500 bg-white border-green-500 border-1"
                                icon="pi pi-file" iconPos="right"/>
                        <input type="file" ref="fileInput" @change="handleFileUpload" accept=".pdf"
                               style="display: none;"/>
                    </div>
                </div>
            </form>
            <span v-if="uploadStatus" style="color: green">{{ uploadStatus }}</span>
            <div v-if="files.length" class="files-table mt-3">
                <h4>Сформированное коммерческое предложение:</h4>
                <DataTable :value="files">
                    <Column field="filename" header="Международное не патентованное наименование"></Column>
                    <Column field="count_accept" header="Торговое наименование"></Column>
                    <Column field="count_failed" header="Форма выпуска"></Column>
                    <Column field="status_name" header="Ед."></Column>
                    <Column field="count_failed" header="Кол-во"></Column>
                    <Column field="status_name" header="Цена (без ндс и оптовой надбавки)"></Column>
                    <Column field="count_failed" header="Сумма (без ндс и оптовой надбавки)"></Column>
                </DataTable>
            </div>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import {mapActions, mapState} from "vuex";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import FloatLabel from "primevue/floatlabel";

export default {
    components: {Header, Footer, DataTable, Column, Button, InputText, FloatLabel},
    data() {
        return {
            formData: {
                sender: '',
                date: ' ',
                positions: ''
            },
            selectedFile: null
        };
    },
    computed: {
        ...mapState('upload', ['uploadStatus', 'files']),
    },
    methods: {
        ...mapActions('upload', ['uploadOfferFile', 'fetchFiles']),
        handleFileUpload(event) {
            this.selectedFile = event.target.files[0];
            if (this.selectedFile) {
                this.submitOfferForm();
            }
        },
        triggerFileInput() {
            this.$refs.fileInput.click();
        },
        async submitOfferForm() {
            if (this.formData.sender && this.formData.date && this.formData.positions && this.selectedFile) {
                const formData = new FormData();
                formData.append('sender', this.formData.sender);
                formData.append('date', this.formData.date);
                formData.append('positions', this.formData.positions);
                formData.append('file', this.selectedFile);

                await this.uploadOfferFile(formData);

                this.formData.sender = '';
                this.formData.date = ' ';
                this.formData.positions = '';
                this.selectedFile = null;
                this.$refs.fileInput.value = '';
            } else {
                alert('Пожалуйста, заполните все поля формы и выберите файл.');
            }
        }
    },
    created() {
        this.fetchFiles();
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
label {
    margin-left: 1.2rem;
    margin-top: -0.8rem;
}
</style>
