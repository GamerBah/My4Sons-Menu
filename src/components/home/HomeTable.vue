<template>
    <v-container fluid>
        <v-data-iterator :items="items" hide-default-footer>
            <template v-slot:default="props">
                <v-row>
                    <v-col v-for="item in items" :key="item.name" cols="12" xs="12" sm="6" md="4" lg="2">
                        <HomeItem :item="item" />
                    </v-col>
                </v-row>
            </template>
        </v-data-iterator>
    </v-container>
</template>
<script>
    import HomeItem from "./HomeItem";

    export default {
        components: {
            HomeItem,
        },
        props: {
            items: Array,
        },
    };
</script>
