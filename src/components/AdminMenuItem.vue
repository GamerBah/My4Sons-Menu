<template>
    <div>
        <v-hover v-slot:default="{ hover }">

            <v-card :elevation="hover ? 12 : 2" v-on:click.stop="showDialog" :color="statusColor(item.status)">
                <v-card-title class="t1">{{ item.name }}</v-card-title>

                <v-divider></v-divider>

                <v-list dense>
                    <v-list-item>
                        <v-list-item-content class="t3">Price:</v-list-item-content>
                        <v-list-item-content class="align-end t3">${{ item.price }}</v-list-item-content>
                    </v-list-item>

                    <v-list-item>
                        <v-list-item-content class="t3">Status:</v-list-item-content>
                        <v-list-item-content class="align-end t3">{{ statusMessage(item.status) }}
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-card>

        </v-hover>
        <v-dialog v-model="dialog" persistent max-width="290">
            <v-card>
                <v-card-title class="t1" style="font-size: xx-large">
                    <v-text-field class="t4" v-model="editor.name" label="Item Name" :placeholder="item.name"/>
                </v-card-title>
                <v-divider/>

                <v-card-text>
                    <v-list two-line disabled>
                        <v-list-item-group v-model="item">
                            <v-list-item v-for="sub in item.subItems" :key="sub.name">
                                <v-list-item-content>
                                    <v-list-item-title class="t3">{{ sub.name }}</v-list-item-title>
                                    <v-list-item-subtitle class="t2" style="color: green">${{ sub.price }}
                                    </v-list-item-subtitle>
                                    <v-divider/>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                </v-card-text>

                <v-card-actions class="justify-center">
                    <v-btn color="secondary" large @click="checkEditor" class="t4">Cancel</v-btn>
                    <v-spacer/>
                    <v-btn color="success" large @click="saveChanges(item)" class="t4">Save Changes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="cancel" ref="cancelDialog" max-width="380px">
            <v-card>
                <v-card-text>
                    <v-content>
                        <p class="text-center t4" style="font-size: large">Any unsaved changes will be lost!</p>
                        <br/>
                        <p class="text-center t4" style="font-size: large">Are you sure?</p>
                    </v-content>
                </v-card-text>
                <v-divider/>
                <v-card-actions class="justify-center">
                    <v-btn class="ma-5 px-10 t4" color="error" @click="cancel = false; dialog = true">No</v-btn>
                    <v-btn class="ma-5 px-10 t4" color="success" @click="resetEditor">Yes</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        data: () => ({
            dialog: false,
            editor: {
                name: "",
                price: 0,
                status: 0,
            },
            cancel: false,
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
            },
            checkEditor() {
                if (this.editor.name !== "" || this.editor.price !== 0 || this.editor.status !== 0) {
                    this.dialog = false;
                    this.cancel = true;
                } else {
                    this.resetEditor();
                }
            },
            resetEditor() {
                this.editor = {
                    name: "",
                    price: 0,
                    status: 0,
                };
                this.cancel = false;
                this.dialog = false;
            },
            saveChanges(item) {
                this.dialog = false;
                if (this.editor.name !== "") {
                    item.name = this.editor.name;
                }
                if (this.editor.price !== 0) {
                    item.price = this.editor.price;
                }
                item.status = this.editor.status;
                axios.post("http://localhost:8018/public/save-items.php", JSON.stringify({
                                                                                             name: item.name,
                                                                                             price: item.price,
                                                                                             status: item.status
                                                                                         }));
            }
        }
    }
</script>
