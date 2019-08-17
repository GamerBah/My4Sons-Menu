<template>
    <div>
        <v-hover v-slot:default="{ hover }">

            <v-card :elevation="hover ? 12 : 2" v-on:click.stop="showDialog" :color="statusColor(item.status)">
                <v-card-title class="subheading font-weight-bold t1">{{ item.name }}</v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item>
                        <v-list-item-content>Price:</v-list-item-content>
                        <v-list-item-content class="align-end">${{ item.price }}</v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-content>Status:</v-list-item-content>
                        <v-list-item-content class="align-end">{{ statusMessage(item.status) }}
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>

        </v-hover>
        <v-dialog v-model="dialog" max-width="290">
            <v-card>
                <v-card-title class="headline">{{ item.name }}</v-card-title>
                <v-divider/>

                <v-card-text>
                    <v-list two-line disabled>
                        <v-list-item-group v-model="item">
                            <v-list-item v-for="sub in item.subItems" :key="sub.name">
                                <v-list-item-content>
                                    <v-list-item-title>{{ sub.name }}</v-list-item-title>
                                    <v-list-item-subtitle style="color: green">${{ sub.price }}</v-list-item-subtitle>
                                    <v-divider/>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn dark large block @click="dialog = false">
                        Close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
        }),
        props: {
            item: Object
        },
        methods: {
            statusMessage: function (id) {
                return id === 0 ? "In Stock!" : id === 1 ? "Running Low!" : "Sold Out!";
            },
            showDialog: function () {
                this.dialog = true;
            },
            statusColor: function (id) {
                return id === 0 ? "green" : id === 1 ? "orange" : "red";
            }
        }
    }
</script>
