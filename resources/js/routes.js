import DockerContainer from './components/commands/docker/DockerContainer.vue';
import GRPDeploy from './components/commands/grp/GRPDeploy.vue';
import GRPMigration from './components/commands/grp/GRPMigration.vue';
import PostgresqlLog from './components/commands/postgresql/PostgresqlLog.vue';
import NotFound from './components/NotFound.vue';

export const routes = [
    {
        name: 'docker-container',
        path: 'docker/container',
        component: DockerContainer
    },
    {
        name: 'grp-deploy',
        path: 'grp/deploy',
        component: GRPDeploy
    },
    {
        name: 'grp3-doctrine-migration',
        path: '/grp/migration',
        component: GRPMigration
    },
    {
        name: 'postgresql-log',
        path: '/postgresql/log',
        component: PostgresqlLog
    },
    {
        name: 'NotFound',
        path: '/page-not-found',
        component: NotFound
    },
    { path: '*', redirect: '/page-not-found' }
];
