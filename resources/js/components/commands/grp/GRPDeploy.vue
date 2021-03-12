<template>
<div class="container">
    <flash-message :type="type" :message="message"></flash-message>
    <div class="row" v-if="loading"><i class="fas fa-spinner fa-spin fa-2x"></i> Running deploy...</div>
    <div class="row">
        <div class="btn-group d-flex justify-content-center">
            <button type="submit" class="btn btn-dark" @click="execute('GRP3')">Deploy GRP3</button>
            <button type="submit" class="btn btn-dark" @click="execute('GRP2')">Deploy GRP2</button>
        </div>
    </div>
</div>
</template>

<script>
    import FlashMessage from '../../FlashMessage';

    export default {
        name: 'GRPDeploy',
        components: { FlashMessage },
        data() {
            return {
                type: '',
                message: '',
                loading: false,
            }
        },
        methods: {
            execute(project) {
                this.loading = true

                this.axios.post('/api/grp/deploy/execute-deploy', {project: project})
                .then(response => {
                    this.type = 'success';
                    this.message = response.data
                })
                .catch(error => {
                    this.type = 'danger';
                    console.log(error.response.data)
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
