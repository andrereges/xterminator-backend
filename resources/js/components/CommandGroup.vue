<template>
<div>
    <flash-message :type="type" :message="message"></flash-message>
    <div style="border: 5px ridge grey; border-radius: 15px; padding: 15px;">
        <div class="form-group">
            <label for="application">Applications*</label>
            <select
                v-model="application"
                class="form-control"
                name="application"
                id="application"
                @change="populateGroupCommand()"
            >
                <option
                    v-for="application in applications"
                    :key="application.id"
                    :value="application.id"
                >
                    {{ application.label }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="commandGroup">Group Commands*</label>
            <select
                v-model="commandGroup"
                class="form-control"
                name="commandGroup"
                id="commandGroup"
                @change="populateCommand()"
            >
                <option
                    v-for="commandGroup in commandGroups"
                    :key="commandGroup.id"
                    :value="commandGroup.id"
                >
                    {{ commandGroup.label }}
                </option>
            </select>
        </div>
        <div class="form-group">
            <label for="command">Commands*</label>
            <select
                v-model="command"
                class="form-control"
                name="command"
                id="command"
                @change="goRoute()"
            >
                <option
                    v-for="command in commands"
                    :key="command.id"
                    :value="command.id"
                >
                    {{ command.label }}
                </option>
            </select>
        </div>
    </div>
</div>
</template>

<script>
    import FlashMessage from './FlashMessage';

    export default {
        name: 'CommandGroup',
        components: { FlashMessage },
        data() {
            return {
                application: '',
                applications: [],
                commandGroup: '',
                commandGroups: [],
                command: '',
                commands: [],
                type: '',
                message: ''
            }
        },
        mounted() {
            this.populateApplication()
            this.populateCommandGroup()

            // Provisório
            this.commandGroup = 'postgresql'
            this.populateCommand()
            this.command = 'log'
            this.$router.push({ name: `${this.commandGroup}-${this.command}` });
        },
        methods: {
            populateApplication() {
                this.applications = [
                    {
                        "id" : "grp3",
                        "label": "GRP3"
                    },
                    {
                        "id" : "grp2",
                        "label": "GRP2"
                    },
                    {
                        "id" : "vision",
                        "label": "Vision"
                    }
                ];
            },
            populateCommandGroup() {
                this.commandGroups = [
                    {
                        "id" : "docker",
                        "label": "Docker"
                    },
                    {
                        "id" : "git",
                        "label": "GIT"
                    },
                    {
                        "id" : "devops",
                        "label": "DevOps"
                    },
                    {
                        "id" : "database",
                        "label": "Database"
                    }
                ];

                this.goRoute();
            },
            populateCommand() {
                switch (this.commandGroup) {
                    case 'docker':
                        this.commands = [
                            {
                                "id" : "container",
                                "label": "Container"
                            }
                        ];
                        break;
                    case 'devops':
                        this.commands = [
                            {
                                "id" : "deploy",
                                "label": "Deploy"
                            },
                            {
                                "id" : "install",
                                "label": "Installation"
                            },
                            {
                                "id" : "migration",
                                "label": "Migration"
                            },
                            {
                                "id" : "parameters",
                                "label": "Parameters"
                            }
                        ];
                        break;
                    case 'database':
                        this.commands = [
                            {
                                "id" : "backup",
                                "label": "Backup"
                            },
                            {
                                "id" : "log",
                                "label": "Pretty LOG"
                            },
                        ];
                        break;
                    default:
                        this.commands = [];
                        break;
                }
            },
            goRoute() {
                this.type = ''
                this.message = ''
                let routeName = ''

                if (this.application && this.commandGroup && this.command) {
                    routeName = `${this.application}-${this.commandGroup}-${this.command}`
                } else {
                    routeName = 'home'
                }

                this.$router.push({ name: routeName })
                .catch(error => {
                    this.type = 'danger'
                    this.message = `Code ${error.response.status} - ${error.response.data}`;
                })
            }
        }
    }
</script>

<style scoped>
#img-brand {
    height: 50px;
    width: 50px;
}
#titleApp {
    font-size: 28px;
    font-weight: bold;
    color: white;
    font-family: "Times New Roman", Times, serif;
}
#versionApp {
    font-size: 16px;
    font-weight: bold;
    color: white;
    font-family: "Times New Roman", Times, serif;
}
</style>
