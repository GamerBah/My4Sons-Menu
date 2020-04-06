<template>
    <div id="app">
        <v-content>
            <v-container>
                <v-layout text-center wrap>
                    <v-row class="mt-5" no-gutters>
                        <v-col />
                        <v-col cols="8">
                            <v-btn block x-large outlined class="t4 medium" color="success" @click="create = true">Add
                                                                                                                   New
                                                                                                                   Menu
                                                                                                                   Item
                            </v-btn>
                        </v-col>
                        <v-col />
                    </v-row>

                    <AdminTable ref="table" :items="items" v-on:update-item="$emit('update-item', $event)" />

                </v-layout>
            </v-container>
        </v-content>

        <v-footer fixed class="grey lighten-2">
            <span class="t2 small" style="vertical-align: center;">
                &#169 {{ new Date().getFullYear() }} My 4 Sons Enterprises
            </span>
            <v-spacer/>
            <v-tooltip left transition="scale-transition" open-delay="500">
                <template v-slot:activator="{ on }">
                    <v-btn color="secondary" icon @click="logout = true">
                        <v-icon v-on="on">mdi-logout</v-icon>
                    </v-btn>
                </template>
                <span class="t2 small">Logout of Editor</span>
            </v-tooltip>
        </v-footer>

        <v-dialog v-model="logout" ref="logoutDialog" max-width="380px">
            <v-card>
                <v-card-text>
                    <v-content>
                        <p class="text-center t4 medium" style="font-size: large">Are you sure you want to logout?</p>
                    </v-content>
                </v-card-text>
                <v-divider />
                <v-card-actions class="justify-center">
                    <v-btn class="ma-5 px-10 t4 medium" color="error" @click="logout = false">No</v-btn>
                    <v-btn class="ma-5 px-10 t4 medium" color="success" to="/" @click="axios.get('logout.php')">Yes
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <CreateMenuItem :create-dialog="create"
                        v-on:toggle-creation="create = $event"
                        v-on:add-item="$emit('add-item', $event)" />

    </div>
</template>

<script>
    import AdminTable from "../components/admin/AdminTable";
    import CreateMenuItem from "../components/admin/creation/CreateMenuItem";

    export default {
        components: {
            AdminTable,
            CreateMenuItem,
        },
        data      : () => ({
            logout: false,
            create: false,
        }),
        props: {
            items: Array
        },
    };
</script>
