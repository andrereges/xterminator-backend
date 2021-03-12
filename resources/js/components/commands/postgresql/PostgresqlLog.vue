<template>
<div class="container">
    <flash-message :type="type" :message="message"></flash-message>
    <div class="row" v-if="loading"><i class="fas fa-spinner fa-spin fa-2x"></i> Running command...</div>
    <div class="form-group">
        <label for="nameFile">Log file name</label>
        <input
            class="form-control"
            type="text"
            v-model="nameFile"
            name="nameFile"
            id="nameFile"
            placeholder="Enter a name for the file"
        >
    </div>
    <div class="form-group">
        <label for="seletor">Selectors*</label>
        <select
            v-model="seletorsModel"
            class="form-control"
            name="seletor"
            id="seletor"
            multiple
        >
            <option
                v-for="seletor in seletors"
                :key="seletor.id"
                :value="seletor.id"
            >
                {{ seletor.label }}
            </option>
        </select>
    </div>

    <div class="form-group">
        <button type="button" class="btn btn-success" @click="save(false)" data-toggle="modal" data-target="#actionModal">Flash Log</button>

        <button type="button" class="btn btn-danger btn-log" @click="clear()">Clear Logs</button>
        <button type="button" class="btn btn-primary btn-log" @click="save(true)">Save</button>
    </div>

    <table class="table table-striped table-bordered text-center" style="width:100%">
        <thead>
            <tr class="container-name">
                <th>Log Files</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="log in logs" :key="log.name">
                <td class="w-25 container-name">{{ log.name }}</td>
                <td class="w-25">
                    <div>
                        <button  type="button" class="btn" @click="view(log.name)" data-toggle="modal" data-target="#actionModal">
                           <i class="fas fa-eye"></i>
                        </button>
                        <button  type="button" class="btn" @click="remove(log.name)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr v-if="logs.length === 0">
                <td colspan="2">No register</td>
            </tr>
        </tbody>
    </table>
     <view-log-modal :logView="logView" />
</div>
</template>

<script>
    import ViewLogModal from './ViewLogModal.vue'
    import FlashMessage from '../../FlashMessage';

    export default {
        name: 'PostgresqlLog',
        components: { FlashMessage, ViewLogModal },
        data() {
            return {
                seletors: [
                    {
                        "id": 'SELECT',
                        "label": 'SELECT'
                    },
                    {
                        "id": 'INSERT',
                        "label": 'INSERT'
                    },
                     {
                        "id": 'UPDATE',
                        "label": 'UPDATE'
                    },
                    {
                        "id": 'DELETE',
                        "label": 'DELETE'
                    },
                    {
                        "id": 'ALTER',
                        "label": 'ALTER'
                    },
                    {
                        "id": 'COMMIT',
                        "label": 'COMMIT'
                    },
                    {
                        "id": 'rollback',
                        "label": 'ROLLBACK'
                    },
                    {
                        "id": 'SET',
                        "label": 'SET'
                    }
                ],
                seletorsModel: [
                    'SELECT',
                    'INSERT',
                    'UPDATE',
                    'DELETE'
                ],
                nameFile: '',
                type: '',
                message: '',
                loading: false,
                logs: [],
                logView: ''
            }
        },
        mounted() {
            this.getLogs()
        },
        methods: {
            save(save) {
                this.loading = true

                const data = {
                    nameFile: this.nameFile,
                    selectors: this.seletorsModel,
                    save: save
                }

                this.axios.post('/api/postgresql/log/create', data)
                .then(response => {
                    if (save) {
                        this.type = 'success';
                        this.message = response.data
                        this.getLogs()

                        return
                    }

                    this.logView = response.data
                })
                .catch(error => {
                    this.type = 'danger';
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
                .finally(() => {
                    this.nameFile = ''
                    this.loading = false
                })
            },
            getLogs() {
                this.axios.get('/api/postgresql/logs')
                .then(response => {
                    this.logs = response.data
                })
                .catch(error => {
                    this.type = 'danger'
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
            },
            view(filename) {
                this.axios.post('/api/postgresql/log/view', {filename: filename})
                .then(response => {
                    this.logView = response.data
                })
                .catch(error => {
                    this.type = 'danger'
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
            },
            remove(filename) {
                this.axios.post('/api/postgresql/log/remove', {filename: filename})
                .then(response => {
                    this.type = 'success'
                    this.message = response.data

                    this.getLogs()
                })
                .catch(error => {
                    this.type = 'danger';
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
            },
            clear() {
                this.axios.post('/api/postgresql/log/clear')
                .then(response => {
                    this.type = 'success'
                    this.message = response.data
                })
                .catch(error => {
                    this.type = 'danger';
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                })
            }
        }
    }
</script>

<style scoped>
.btn-log {
    float: right;
    margin-right: 5px;
}
</style>
