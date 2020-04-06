<template>
    <div>
        <v-dialog v-model="createDialog" persistent max-width="400">
            <v-stepper alt-labels v-model="step">
                <v-stepper-header>
                    <v-stepper-step step="1" :complete="step > 1">Item Name</v-stepper-step>

                    <v-divider />

                    <v-stepper-step step="2" :complete="step > 2">Sub-Items</v-stepper-step>

                    <v-divider />

                    <v-stepper-step step="3" :complete="step > 3">Attributes</v-stepper-step>
                </v-stepper-header>

                <v-stepper-items>
                    <v-stepper-content step="1">
                        <v-card>
                            <v-layout text-center wrap>
                                <v-flex>
                                    <p class="t3 medium">
                                        First, the item needs a name!
                                    </p>
                                    <v-divider />
                                    <v-text-field outlined solo class="mt-5 t4 medium"
                                                  v-model="editor.name"
                                                  label="Item Name"
                                                  placeholder="Item Name"
                                                  style="margin-bottom: -15px" />
                                </v-flex>
                            </v-layout>

                            <v-divider />

                            <v-card-actions class="mt-3">
                                <v-row no-gutters>
                                    <v-col class="mx-2">
                                        <v-btn block color="secondary" @click="resetAll" class="t4 medium">Back</v-btn>
                                    </v-col>
                                    <v-col class="mx-2">
                                        <v-btn block color="primary"
                                               :disabled="editor.name === ''"
                                               @click="step = 2"
                                               class="t4 medium">
                                            Next
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>
                        </v-card>
                    </v-stepper-content>

                    <v-stepper-content step="2">
                        <v-card>
                            <v-flex text-center wrap>
                                <p class="t3 medium">
                                    Now, add some sub-items! Each item needs a name and a price.
                                </p>
                                <v-divider />
                                <v-list v-if="subItems.length > 0"
                                        two-line
                                        class="mx-2 mt-5 elevation-3 grey lighten-5">
                                    <v-list-item-group>
                                        <v-list-item v-for="sub in subItems" :key="sub.name" @click="editSubItem(sub)">
                                            <v-list-item-content>
                                                <v-list-item-title class="t3 medium">{{ sub.name }}</v-list-item-title>
                                                <v-list-item-subtitle class="t2 small" style="color: green">
                                                    ${{sub.price }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>
                                    </v-list-item-group>
                                </v-list>
                                <p v-else class="mx-2 mt-5 t3 small grey--text">Click + to add a sub-item</p>
                                <v-container>
                                    <v-row no-gutters>
                                        <v-col>
                                            <v-btn block
                                                   color="info"
                                                   outlined
                                                   class="my-5 elevation-1 t4 xxlarge"
                                                   @click="edit = true">+
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-flex>
                            <v-divider />
                            <v-card-actions class="mt-3">
                                <v-row no-gutters>
                                    <v-col class="mx-2">
                                        <v-btn block color="secondary" @click="step = 1" class="t4 medium">Back</v-btn>
                                    </v-col>
                                    <v-col class="mx-2">
                                        <v-btn block color="primary"
                                               :disabled="subItems.length === 0"
                                               @click="step = 3"
                                               class="t4 medium">
                                            Next
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>
                        </v-card>
                    </v-stepper-content>

                    <v-stepper-content step="3">
                        <v-card>
                            <v-flex mb-4>
                                <p class="t3 large">Special Days</p>
                                <p class="t3 small">The menu will show that this item is only available on the selected
                                                    days</p>
                                <v-select v-model="editor.specials"
                                          :items="weekdays"
                                          placeholder="None"
                                          multiple
                                          outlined
                                          solo style="margin-bottom: -15px" />
                            </v-flex>
                            <v-divider />
                            <v-card-actions class="mt-3">
                                <v-row no-gutters>
                                    <v-col class="mx-2">
                                        <v-btn block color="secondary" @click="step = 2" class="t4 medium">Back</v-btn>
                                    </v-col>
                                    <v-col class="mx-2">
                                        <v-btn block color="success" @click="finishItem" class="t4 medium">Finish
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-card-actions>
                        </v-card>
                    </v-stepper-content>

                </v-stepper-items>

            </v-stepper>
        </v-dialog>

        <v-dialog v-model="edit" persistent max-width="290" transition="scroll-y-transition">
            <v-card>
                <v-card-title class="t4 medium">Adding Sub-Item</v-card-title>
                <v-divider />
                <v-card-text class="mt-5" style="margin-bottom: -15px">
                    <v-text-field outlined label="Name" v-model="sub.name" style="margin-bottom: -10px" />
                    <v-text-field outlined
                                  label="Price"
                                  prefix="$"
                                  v-model.number="sub.price"
                                  style="margin-bottom: -10px" />
                </v-card-text>
                <v-divider />
                <v-card-actions>
                    <v-row no-gutters>
                        <v-col class="ma-2">
                            <v-btn v-if="index === -1" block color="secondary" @click="resetEditor" class="t4 medium">
                                Cancel
                            </v-btn>
                            <v-btn v-else color="error" block @click="removeSubItem" class="t4 medium">Remove</v-btn>
                        </v-col>
                        <v-col class="ma-2">
                            <v-btn v-if="index !== -1"
                                   block
                                   color="success"
                                   :disabled="validEditor"
                                   @click="addSubItem"
                                   class="t4 medium">Save
                            </v-btn>
                            <v-btn v-else
                                   block
                                   color="success"
                                   :disabled="validEditor"
                                   @click="addSubItem"
                                   class="t4 medium">Add Item
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        props   : {
            createDialog: Boolean,
        },
        data    : () => ({
            editor  : {
                name    : "",
                specials: [],
            },
            step    : 1,
            cancel  : false,
            edit    : false,
            subItems: [],
            sub     : {
                name : "",
                price: "",
            },
            index   : -1,
            weekdays: ["Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        }),
        methods : {
            editSubItem(item) {
                this.index = this.subItems.indexOf(item);
                this.sub = this.subItems[this.index];
                this.edit = true;
            },
            addSubItem() {
                let subPrice = this.sub.price === "" ? 0 : this.sub.price;
                this.subItems[this.index === -1 ? this.subItems.length : this.index] = {
                    name : this.sub.name,
                    price: subPrice.toFixed(2)
                };
                this.subItems.sort(function (a, b) {
                    return a.price - b.price;
                });
                this.edit = false;
                this.resetEditor();
            },
            removeSubItem() {
                this.subItems.splice(this.index, 1);
                this.resetEditor();
            },
            finishItem() {
                /*axios.post("add-item.php", JSON.stringify({
                                                              name: this.editor.name,
                                                              status: "In Stock",
                                                              subItems: this.subItems,
                                                              specials: this.editor.specials,
                                                          }));*/
                this.$emit("add-item", {
                    name    : this.editor.name,
                    status  : "In Stock",
                    subItems: this.subItems,
                    specials: this.editor.specials,
                });
                this.resetAll();
            },
            resetAll() {
                this.$emit("toggle-creation", false);
                this.editor.name = "";
                this.step = 1;
                this.subItems = [];
                this.resetEditor();
            },
            resetEditor() {
                this.edit = false;
                this.sub.name = "";
                this.sub.price = "";
                this.index = -1;
            }
        },
        computed: {
            validEditor() {
                return this.sub.name === "" || this.sub.price === "";
            },
        }
    }
</script>
