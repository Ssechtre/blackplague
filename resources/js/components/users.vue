<template>
    <div>
        <h2>USERS</h2>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="text-success">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Points</th>
                        <th scope="col">Branch</th>
                        <th scope="col">Date Created</th>
                    </tr>
                </thead>
                <tbody v-for="user in users" :key="user.id">
                    <tr>
                        <th scope="row">{{ user.id }}</th>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.points }}</td>
                        <td>{{ user.branch }}</td>
                        <td>{{ user.created_at }}</td>
                    </tr>
                </tbody>
            </table>
            <nav class="pagination">
                <ul class="pagination">
                    <li :class="[{disabled: !prev_page_url}]"
                    class="page-item">
                    <a href="#" class="page-link" @click="fetchUsers(prev_page_url)">Previous</a>
                    </li>
                    <li :class="[{disabled: !next_page_url}]"
                    class="page-item">
                    <a href="#" class="page-link" @click="fetchUsers(next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    // props: ['data'],
    data(){
        return {
            users: [],
            user: {
                id: '',
                name: '',
                email: '',
                branch: '',
                phone: '',
                address: '',
                govt_id_type: '',
                govt_id_number: '',
                points: '',
            },
            user_id: '',
            pagination: {},
            edit: false,
            next_page_url: '',
            prev_page_url: '',
        }
    },

    mounted() {
        // console.log(this.data);
    },

    created() {
        this.fetchUsers();
    },

    methods: {
        fetchUsers(page_url) {
            let vm = this;
            page_url = page_url || '/api/vue'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.users = res.data;
                    vm.makePagination(res.next_page_url, res.prev_page_url);
                })
                .catch(err => console.log(err));
        },

        makePagination(meta, links) {
            let next = meta;
            let prev = links;

            this.next_page_url = next;
            this.prev_page_url = prev;
        }
    }
}
</script>