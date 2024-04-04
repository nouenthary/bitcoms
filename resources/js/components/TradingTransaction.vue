<template>
    <div>
        Test Home

        {{data}}
    </div>
</template>

<script>
    import axios from 'axios'
    export default {
        name: "TradingTransaction",
        data: () => ({
            data: [
                {
                    id: 1,
                    name: "string"
                }
            ]
        }),
        methods: {
            fetchData() {
                // axios.get('/get_trading_by_user')
                //     .then(data => {
                //         console.log(data)
                //     })


            }
        },
        created() {
            this.fetchData();
        }
    }
</script>

<style scoped>

</style>
