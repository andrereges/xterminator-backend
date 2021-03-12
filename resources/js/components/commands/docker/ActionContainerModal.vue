<template>
<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actionModal">Actions - {{ containerName }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="container">
            <span v-if="loading"><i class="fas fa-spinner fa-spin fa-1x"></i> Running command...</span>
            <div class="row btn-group d-flex justify-content-center">
                <input type="hidden" v-model="containerID" name="containerID" id="containerID">
                <button type="button" class="btn btn-success" @click="execute('start')">Start</button>
                <button type="button" class="btn btn-primary" @click="execute('restart')">Restart</button>
                <button type="button" class="btn btn-danger" @click="execute('stop')">Stop</button>
                <button type="button" class="btn btn-dark" @click="execute('rm')">Remove</button>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        name: 'ActionContainerModal',
        data() {
            return {
                loading: false
            }
        },
        props: {
            containerID: String,
            containerName: String
        },
        methods: {
            execute(action) {
                this.loading = true

                let data = {
                    containerID: this.containerID,
                    action: action
                }

                this.axios.post('/api/docker/container/execute', data)
                .then(response => {
                    location.reload()
                })
                .catch(error => {
                    this.type = 'danger'
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
    width: 80px;
}
</style>
