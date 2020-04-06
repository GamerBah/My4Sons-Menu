<template>
    <v-container fluid>
        <v-data-iterator id="itemList" :items="items" hide-default-footer>
            <template v-slot:default="props">
                <v-row>
                    <v-col v-for="item in items" :key="item.name" cols="12" xs="12" sm="6" md="4" lg="2">
                        <AdminItem :item="item"
                                   v-on:remove-item="removeItem($event)"
                                   v-on:update-item="$emit('update-item', $event)" />
                    </v-col>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>
<script>
    import AdminItem from "./AdminItem";

    export default {
        components: {
            AdminItem,
        },
        props     : {
            items: Array,
        },
        methods   : {
            removeItem(item) {
                this.items.splice(this.items.indexOf(item), 1);
            },
        }
    };
</script>
