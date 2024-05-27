<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container p-fluid">
            <div class="title-section">
                <h3>Формирование обоснование НМЦК</h3>
                <p>
                    Для того, чтобы перейти к скачиванию обоснования НМЦК необходимо загрузить потребность и коммерческие предложения.
                </p>
                <p v-if="!selectedFile" class="text-green-600">Выберите предложение</p>
            </div>
            <DataTable v-model:selection="selectedFile" :value="files" selectionMode="single" dataKey="id" :metaKeySelection="false" @rowSelect="onRowSelect" @rowUnselect="onRowUnselect" table-style="border-color: green">
                <Column field="filename" header="Имя файла"></Column>
                <Column field="created_at" header="Дата загрузки">
                    <template #body="{ data }">
                        {{ new Date(data.created_at).toLocaleDateString() }}
                    </template>
                </Column>
            </DataTable>
            <div class="flex mt-3 col-12">
                <Checkbox v-model="openSource" :binary="true"
                          inputId="openSource"/>
                <label for="openSource"> Использовать цены из открытых источников</label>
            </div>
            <Button label="Подготовить файл для скачивания" class="consultation-button" @click="prepareFile" :disabled="!selectedFile"/>
        </div>
    </section>
    <Footer></Footer>
</template>

<script>
import Header from "./../Header.vue";
import Footer from "./../Footer.vue";
import DataTable from "primevue/datatable";
import Checkbox from 'primevue/checkbox';
import Column from 'primevue/column';
import {mapActions, mapState} from "vuex";


export default {
    components: {Header, Footer, DataTable, Checkbox, Column},
    data() {
        return {
            selectedFile: null,
            openSource: false
        };
    },
    methods: {
        ...mapActions('upload', ['fetchFiles', 'prepareNMCKFile']),
        onRowSelect(event) {
            this.selectedFile = event.data;
        },
        onRowUnselect(event) {
            this.selectedFile = null;
        },
        async prepareFile() {
            if (!this.selectedFile) {
                alert('Пожалуйста, выберите файл.');
                return;
            }

            const requestData = {
                fileId: this.selectedFile.id,
                openSource: this.openSource
            };

            try {
                await this.prepareNMCKFile(requestData);
                alert('Запрос на подготовку файла отправлен успешно.');
            } catch (error) {
                console.error('Ошибка при подготовке файла:', error);
            }
        }
    },
    computed: {
        ...mapState('upload', ['files']),
    },
    created() {
        this.fetchFiles();
    }
}
</script>


<style scoped>

Fieldset {
    margin-bottom: 2%;
}
</style>

