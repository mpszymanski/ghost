<template>
    <div>
        <v-select multiple :filterable="false" :options="options" v-model="selected" @search="onSearch">
            <template slot="no-options">
                type to search users..
            </template>
        </v-select>
        <input type="hidden" :name="name" :value="selected_string">
    </div>
</template>

<script>
export default {
    props: ['url', 'name'],
    computed: {
        selected_string () {
            return this.selected.map((nick) => {
                let match = nick.match(/<([A-Za-z0-9@\.]*)>/)
                return match[1]
            }).join(',')
        }
    },
    data() {
        return {
            options: [],
            selected: []
        }
    },
    methods: {
        onSearch(search, loading) {
            loading(true);
            this.search(loading, search, this);
        },
        search: _.debounce((loading, search, vm) => {
            fetch(
                `${vm.url}?q=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350)
    }
}
</script>