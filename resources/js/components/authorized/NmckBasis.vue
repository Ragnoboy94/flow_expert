<template>
    <Header></Header>
    <section class="landing-block2">
        <div class="content-container p-fluid">
            <div class="title-section">
                <h3>Формирование обоснование НМЦК</h3>
                <p>
                    Для того, чтобы перейти к скачиванию обоснования НМЦК необходимо загрузить потребность и
                    коммерческие предложения.
                </p>
                <p v-if="!selectedFile" class="text-green-600">Выберите предложение</p>
            </div>
            <DataTable v-model:selection="selectedFile" :value="files" selectionMode="single" dataKey="id"
                       :metaKeySelection="false" @rowSelect="onRowSelect" @rowUnselect="onRowUnselect"
                       table-style="border-color: green">
                <Column field="filename" header="Имя файла"></Column>
                <Column field="created_at" header="Дата загрузки">
                    <template #body="{ data }">
                        {{ new Date(data.created_at).toLocaleDateString() }}
                    </template>
                </Column>
            </DataTable>
            <div class="flex mt-3 col-12">
                <Checkbox v-model="openSource" :binary="true" inputId="openSource"/>
                <label for="openSource"> Использовать цены из открытых источников</label>
            </div>
            <div class="flex flex-column lg:flex-row lg:flex-wrap mt-3">
                <Fieldset class="border-round-3xl lg:col-8 col-12" legend="Метод средневзвешенной цены">
                    <p class="m-0">
                        <div class="flex-1 lg:mr-2 mb-3">
                            <DataTable stripedRows :value="monthlyData" editMode="cell"
                                       @cell-edit-complete="onCellEditComplete">
                                <Column field="month" header="Месяц" :editable="false"></Column>
                                <Column field="price" header="Цена" style="width: 33%">
                                    <template #editor="{ data, field }">
                                        <InputNumber mode="currency" currency="RUB" locale="ru-RU" v-model="data[field]"/>
                                    </template>
                                </Column>
                                <Column field="quantity" header="Количество" style="width: 33%">
                                    <template #editor="{ data, field }">
                                        <InputNumber v-model="data[field]"/>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </p>
                </Fieldset>
                <Fieldset class="border-round-3xl lg:col-4 col-12" legend="Метод референтных цен">
                    <p class="m-0">
                        <div class="flex-1 lg:ml-2 mb-3">
                            <DataTable stripedRows :value="periodicData" editMode="cell"
                                       @cell-edit-complete="onCellEditComplete">
                                <Column field="period" header="Период" :editable="false" style="width: 50%"></Column>
                                <Column field="quantity" header="Количество" style="width: 50%">
                                    <template #editor="{ data, field }">
                                        <InputNumber v-model="data[field]"/>
                                    </template>
                                </Column>
                            </DataTable>
                        </div>
                    </p>
                </Fieldset>
            </div>
            <Button label="Подготовить файл для скачивания" class="consultation-button" @click="prepareFile"
                    :disabled="!selectedFile"/>
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
import InputNumber from "primevue/inputnumber";
import { mapActions, mapState } from "vuex";
import Fieldset from "primevue/fieldset";

export default {
    components: { Header, Footer, DataTable, Checkbox, Column, InputNumber, Fieldset },
    data() {
        return {
            selectedFile: null,
            openSource: false,
        };
    },
    methods: {
        ...mapActions('upload', ['fetchFiles', 'prepareNMCKFile', 'fetchData']),
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
        },
        onCellEditComplete(event) {
            let {data, newValue, field} = event;
            data[field] = newValue;
        }
    },
    computed: {
        ...mapState('upload', ['files', 'monthlyData', 'periodicData']),
    },
    created() {
        this.fetchFiles();
        this.fetchData();
    }
}
</script>

<style scoped>
Fieldset {
    margin-bottom: 2%;
}
</style>
