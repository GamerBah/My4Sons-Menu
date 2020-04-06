<template>
    <div>
        <v-hover v-slot:default="{ hover }">

            <v-card :elevation="hover ? 12 : 2" @click="dialog = true" :color="statusColor(item.status)">
                <v-card-title class="t1 large">{{ item.name }}</v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item>
                        <v-list-item-content class="t3 medium">Starting at</v-list-item-content>
                        <v-list-item-content class="align-end t3 medium">${{ startingPrice }}</v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-content class="t3 medium">Status:</v-list-item-content>
                        <v-list-item-content class="align-end t3 medium">{{ item.status }}
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>

        </v-hover>
        <HomeItemMenu v-on:toggle-dialog="dialog = false" :home-item-dialog="dialog" :home-item-menu="item" />
    </div>
</template>

<script>
    import HomeItemMenu from "./HomeItemMenu"

    export default {
        components: {
            HomeItemMenu,
        },
        data      : () => ({
            dialog: false,
        }),
        props     : {
            item: Object
        },
        methods   : {
            statusColor: function (status) {
                return status === "In Stock" ? "green" : status === "Running Low" ? "orange" : "red";
            }
        },
        computed  : {
            startingPrice() {
                let array = this.item.subItems;
                let prices = [];
                for (let i = 0; i < array.length; i++) {
                    prices[i] = array[i].price;
                }
                prices.sort(function (a, b) {
                    return a - b;
                });
                return prices[0];
            }
        }
    }
</script>
