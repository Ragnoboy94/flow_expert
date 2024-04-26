<template>
    <section class="landing-block2 ">
        <div class="content-container">
            <Carousel :value="employees" :numVisible="3" :numScroll="1" :responsiveOptions="responsiveOptions" circular :autoplayInterval="3000">
                <template #item="slotProps">
                    <div class="border-1 surface-border border-round m-2  p-3">
                        <div class="mb-3">
                            <div class="relative mx-auto">
                                <img :src="'https://primefaces.org/cdn/primevue/images/product/' + slotProps.data.image" :alt="slotProps.data.name" class="w-full border-round" />
                            </div>
                        </div>
                        <div class="mb-3 font-medium">{{ slotProps.data.name }}</div>
                        <div class="flex justify-content-between align-items-center">
                            <div class="mt-0 font-semibold text-xl">${{ slotProps.data.job }}</div>
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
                    image: 'photo1',
                    name: 'Гуккина Юлия Александровна',
                    job: 'Эксперт по всему'
                }
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

.about-text h1 {
    font-weight: bold;
    color: #000;
}

.about-content {
    max-width: 80%;
}

.image-container {
    margin-left: 10%;
    margin-right: 10%;
}

.card-landing2 {
    height: 100%;
    border: 2px solid #00A950;
    padding: 1rem;
    box-shadow: 0 4px 8px rgba(0, 169, 80, 0.2);
    border-radius: 7vh;
    text-decoration: none;
}

.registry-title {
    font-size: 1.2rem;
    margin-bottom: 1rem;
}

.registry-icon {
    font-size: 2rem;
    color: #00A950;
}

@media screen and (max-width: 991px) {
    .about-content {
        max-width: 100%;
    }
}
</style>
