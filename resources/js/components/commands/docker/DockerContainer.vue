<template>
<form @submit.prevent="executeAction()">
<flash-message :type="type" :message="message"></flash-message>
<div>
    <div class="row">
        <div class="form-group col-2 text-left">
            <select
                v-model="filterStatus"
                class="form-control"
                name="filterStatus"
                id="filterStatus">
                <option
                    v-for="status in statuses"
                    :key="status.id"
                    :value="status.id"
                >
                    {{ status.label }}
                </option>
            </select>
        </div>
        <div class="form-group col-8 text-left">
            <input
                class="form-control"
                type="text"
                v-model="filterName"
                name="filterName"
                id="filterName"
                placeholder="Filter by container name"
            >
        </div>
    </div>

    <action-container-modal :containerID="containerID" :containerName="containerName" />
    <table class="table table-striped table-bordered text-center" style="width:100%">
        <thead>
            <tr class="container-name">
                <th>Containers</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="container in filteredContainers" :key="container.id">
                <td class="w-25 container-name">{{ container.name }}</td>
                <td class="w-25">
                    <div>
                        <button @click="openModal(container)" type="button" class="btn" data-toggle="modal" data-target="#actionModal" data-whatever="@fat">
                            <i class="fas fa-file-code fa-2x"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <tr colspan="2" v-if="loading">
                <td colspan="2">
                    <i class="fas fa-spinner fa-spin fa-2x"></i> Loading...
                </td>
            </tr>
            <tr v-if="!containers.length && !loading">
                <td colspan="2">No register</td>
            </tr>
        </tbody>
    </table>
</div>
</form>
</template>

<script>
    import ActionContainerModal from './ActionContainerModal.vue'
    import FlashMessage from '../../FlashMessage';

    export default {
        name: 'DockerContainer',
        components: { ActionContainerModal, FlashMessage },
        data() {
            return {
                containers: [],
                statuses: [
                    {
                        "id": 'true',
                        "label": 'Actives'
                    },
                    {
                        "id": 'false',
                        "label": 'Inactives'
                    },
                    {
                        "id": 'all',
                        "label": 'All'
                    },
                ],
                filterStatus: 'true',
                filterName: '',
                containerID: '',
                containerName: '',
                type: '',
                message: '',
                loading: false,
            }
        },
        created() {
            this.getContainers()
        },
        computed: {
            filteredContainers() {
                if (this.containers) {
                    let containers = this.containers

                    if (this.filterName) {
                        containers = containers.filter((container) =>
                            container.name.indexOf(this.filterName) !== -1
                        )
                    }

                    if(this.filterStatus && this.filterStatus !== 'all') {
                        containers = containers.filter((container) =>
                            container.status.indexOf(this.filterStatus) !== -1
                        )
                    }

                    return containers;
                }

                return [];
            }
        },
        methods: {
            getContainers() {
                this.loading = true

                this.axios.get('/api/docker/containers')
                .then(response => {
                    this.containers = response.data
                    this.loading = false
                })
                .catch(error => {
                    this.type = 'danger'
                    this.message = `Code ${error.response.status} - ${error.response.data}`
                    this.loading = false
                })
            },
            openModal(container) {
                this.containerID = container.id
                this.containerName = container.name
            }
        }
    }
</script>

<style scoped>
.container-name {
    font-size: 18px;
}
th {
    color: red;
    font-weight: bold;
}
</style>
