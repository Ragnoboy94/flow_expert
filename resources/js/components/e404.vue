<template>
    <div class="page-404">
        <div class="content">
            <h1>404</h1>
            <p>К сожалению, запрашиваемая страница не найдена.</p>
            <router-link to="/" class="home-link">Вернуться на главную</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "PageNotFound",
};
</script>

<style scoped lang="scss">
.page-404 {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    text-align: center;

    .content {
        transform: translateY(-50%);

        h1 {
            font-size: 6rem;
            margin-bottom: 1rem;
        }

        p {
            margin-bottom: 2rem;
        }

        .home-link {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #00A950;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;

            &:hover {
                background-color: darken(#00A950, 10%);
            }
        }
    }
}
</style>
