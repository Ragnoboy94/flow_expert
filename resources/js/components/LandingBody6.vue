<template>
    <section class="landing-block2 ">
        <div class="content-container">
            <div class="title-section">
                <h3>Команда Flow Expert</h3>
            </div>
            <Carousel :value="employees" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="3000">
                <template #item="slotProps">
                    <div class="border-1 surface-border border-round m-2  p-3">
                        <div class="mb-3">
                            <div class="relative mx-auto">
                                <img :src="'images/' + slotProps.data.image" :alt="slotProps.data.name" class="w-full border-round" />
                            </div>
                        </div>
                        <div class="mb-3 font-medium">{{ slotProps.data.name }}</div>
                        <div class="flex justify-content-between align-items-center">
                            <div class="mt-0 font-semibold text-xl">{{ slotProps.data.job }}</div>
                        </div>
                    </div>
                </template>
            </Carousel>
        </div>
    </section>
</template>

<script>
import Carousel from "primevue/carousel";

export default {
    name: 'LandingBody6',
    components: {
        Carousel
    },
    data() {
        return {
            employees: [
                {
                    image: 'emp_photo_1.webp',
                    name: 'Гуккина Юлия Александровна',
                    job: 'Эксперт по всему'
                },
                {
                    image: 'emp_photo_2.webp',
                    name: 'Новолотцкий Александр Юрьевич',
                    job: 'Эксперт по всему'
                },
                {
                    image: 'emp_photo_3.webp',
                    name: 'Фролова Анна',
                    job: 'Эксперт по всему'
                },
                {
                    image: 'emp_photo_4.webp',
                    name: 'Бонячук Мария Владимировна',
                    job: 'Системный аналитик проекта Flow Expert'
                },
            ],
            responsiveOptions: [
                {
                    breakpoint: '1400px',
                    numVisible: 2,
                    numScroll: 1
                },
                {
                    breakpoint: '1199px',
                    numVisible: 3,
                    numScroll: 1
                },
                {
                    breakpoint: '767px',
                    numVisible: 2,
                    numScroll: 1
                },
                {
                    breakpoint: '575px',
                    numVisible: 1,
                    numScroll: 1
                }
            ]
        };
    }
};
</script>

<style scoped>

</style>
