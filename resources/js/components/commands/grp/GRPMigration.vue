<template>
<div class="container">
    <flash-message :type="type" :message="message"></flash-message>
    <div class="row" v-if="loading"><i class="fas fa-spinner fa-spin fa-2x"></i> Running command...</div>
    <div class="row">
        <div class="btn-group d-flex justify-content-center">
            <button type="submit" class="btn btn-dark" @click="execute('CREATE')">Create Migration</button>
            <button type="submit" class="btn btn-dark" @click="execute('RUN')">Run Migration</button>
            <button type="submit" class="btn btn-dark" @click="execute('ROLLBACK')">Rollback Migration</button>
        </div>
    </div>
</div>
</template>

<script>
    import FlashMessage from '../../FlashMessage';

    export default {
        name: 'GRPMigration',
        components: { FlashMessage },
        data() {
            return {
                type: '',
                message: '',
                loading: false,
            }
        },
        methods: {
            execute(command) {
                this.loading = true

                this.axios.post('/api/grp/migration/execute-migration', {command: command})
                .then(response => {
                    this.type = 'success';
                    this.message = response.data
                })
                .catch(error => {
                    this.type = 'danger';
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
                .finally(() => this.loading = false)
            }
        }
    }
</script>

<style scoped>
.btn {
    margin-right: 10px;
    margin-bottom: 10px !important;
    width: 100px;
}
</style>
