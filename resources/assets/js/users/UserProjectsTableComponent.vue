<template>
    <div v-if="done">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Project name</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="project in projects.data">
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="mr-2"><i class="far fa-bookmark"></i></div>
                            <div>
                                <a class="text-dark" style="font-weight: 600;" :href="'/projects/' + project.id">{{ project.profile.name }} / {{ project.name }}</a>
                                <div><small>{{ project.description }}</small></div>
                            </div>
                            <div class="ml-auto text-right">
                                <span class="mr-2"><i class="fas fa-folder"></i> {{ project.groups_count }}</span>
                                <span class="mr-2"><i class="fas fa-code-merge"></i> {{ project.mr_count }}</span>
                                <span><i class="fas fa-bug"></i> {{ project.issues_count }}</span>
                                <div><small>updated {{ project.created_at.date | moment }}</small></div>
                            </div>
                        </div>
                        
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from 'axios'
    import emojione from 'emojione'
    export default {
        mounted () {
            console.log('Component ProfilesTable mounted.')
        },
        props: ['userId'],
        data () {
            return {
                done: false,
                projects: {
                    data: []
                },
                errors: []
            }
        },
        created () {
            this.$parent.$emit('pageLoader', true)
            axios.get('/api/users/' + this.userId + '/projects')
            .then(response => {
                this.projects = response.data
                this.$parent.$emit('pageLoader', false)
                this.done = true
            })
            .catch(e => {
                this.errors.push(e)
            })
        }
    }
</script>