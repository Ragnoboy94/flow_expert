<template>
    <div class="page-404">
        <div class="content">
            <h1>Доступ запрещен</h1>
            <p>Для должности "{{ positionName }}" доступ к этой странице запрещен.</p>
            <p>Пожалуйста, свяжитесь с администратором, если вы считаете, что это ошибка.</p>
            <router-link to="/" class="home-link">Вернуться на главную</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "Forbidden",
    computed: {
        positionName() {
            const position = this.$store.state.auth.position;
            return position ? position.name : 'Которую вы выбрали при регистрации';
        }
    }
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
