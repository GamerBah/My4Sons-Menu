<template>
    <div id="app">
        <v-content>
            <v-container>
                <v-layout text-center wrap>
                    <v-container fluid>
                        <v-data-iterator id="itemList" :items="items" hide-default-footer>
                            <template v-slot:default="props">
                                <v-row>
                                    <v-col v-for="item in items" :key="item.name" sm="6" md="4" lg="2">
                                        <AdminMenuItem :item="item"/>
                                    </v-col>
                                </v-row>
                            </template>
                        </v-data-iterator>
                    </v-container>
                </v-layout>
            </v-container>
        </v-content>

        <v-footer fixed class="grey lighten-2">
            <span class="t2" style="vertical-align: center;">
                &#169 {{ new Date().getFullYear() }} My 4 Sons Enterprises
            </span>
            <v-spacer/>
            <v-tooltip left transition="scale-transition" open-delay="500">
                <template v-slot:activator="{ on }">
                    <v-btn color="secondary" icon @click="logout = true">
                        <v-icon v-on="on">mdi-logout</v-icon>
                    </v-btn>
                </template>
                <span class="t2">Logout of Editor</span>
            </v-tooltip>
        </v-footer>

        <v-dialog v-model="logout" ref="logoutDialog" max-width="380px">
            <v-card>
                <v-card-text>
                    <v-content>
                        <p class="text-center t4" style="font-size: large">Are you sure you want to logout?</p>
                    </v-content>
                </v-card-text>
                <v-divider/>
                <v-card-actions class="justify-center">
                    <v-btn class="ma-5 px-10 t4" color="error" @click="logout = false">No</v-btn>
                    <v-btn class="ma-5 px-10 t4" color="success" to="/">Yes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    import AdminMenuItem from "../components/AdminMenuItem";

    export default {
        components: {
            AdminMenuItem,
        },
        data: () => ({
            logout: false,
        }),
        props: {
            items: Array
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
        },
    };
</script>
