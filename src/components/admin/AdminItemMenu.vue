<template>
    <div>
        <v-dialog v-model="adminItemMenuDialog" persistent max-width="290">
            <v-tabs v-model="tab" centered>
                <v-tab :key="1" :href="`#tab-1`">
                    Item
                </v-tab>
                <v-tab :key="2" :href="`#tab-2`">
                    Attributes
                </v-tab>

                <v-tab-item :key="1" :value="'tab-1'">
                    <v-card>
                        <v-card-title class="t4 medium" style="margin-bottom: -15px">
                            <v-text-field outlined class="mt-2 t4 medium"
                                          v-model="editor.name"
                                          label="Item Name"
                                          :placeholder="adminItemMenu.name" />
                        </v-card-title>
                        <v-divider />

                        <v-card-text>
                            <v-flex text-center wrap>
                                <v-list v-if="adminItemMenu.subItems.length > 0"
                                        two-line
                                        class="mt-5 grey lighten-5 elevation-3">
                                    <v-list-item-group>
                                        <v-list-item v-for="sub in adminItemMenu.subItems" :key="sub.name"
                                                     @click=" subItem = sub;
                                                        baseItem = adminItemMenu;
                                                        edit = true;
                                                        $emit('toggle-dialog', false)">
                                            <v-list-item-content>
                                                <v-list-item-title class="t3 medium">{{ sub.name }}</v-list-item-title>
                                                <v-list-item-subtitle class="t2 small" style="color: green">${{
                                                                                                            sub.price }}
                                                </v-list-item-subtitle>
                                            </v-list-item-content>
                                        </v-list-item>

                                        <AdminItemEditor :editor-item="subItem"
                                                         :base-item="baseItem"
                                                         :item-editor-dialog="edit"
                                                         v-on:toggle-editor="edit = $event"
                                                         v-on:toggle-dialog="$emit('toggle-dialog', true)"
                                                         v-on:update-sub-item="updateSubItem($event)" />

                                    </v-list-item-group>
                                </v-list>
                                <p v-else class="mx-2 mt-5 t3 small grey--text">Click + to add a sub-item</p>
                                <v-container>
                                    <v-row no-gutters>
                                        <v-col>
                                            <v-btn block
                                                   color="info"
                                                   outlined
                                                   class="mt-5 elevation-1 t4 xxlarge"
                                                   @click="createSubItem = true">+
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-flex>
                        </v-card-text>

                        <v-divider />

                        <v-card-actions>
                            <v-container>
                                <v-row no-gutters>
                                    <v-col class="ma-2">
                                        <v-btn block color="secondary" large @click="checkEditor" class="t4 medium">
                                            Cancel
                                        </v-btn>
                                    </v-col>
                                    <v-col class="ma-2">
                                        <v-btn block color="error" large @click="removeItem" class="t4 medium">Delete
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col class="ma-2">
                                        <v-btn block
                                               color="success"
                                               :disabled="!editorCheck"
                                               large
                                               @click="saveChanges"
                                               class="t4 medium">Save
                                                                 Changes
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-actions>
                    </v-card>
                </v-tab-item>

                <v-tab-item :key="2" :value="'tab-2'">
                    <v-card>
                        <v-card-text>
                            <v-flex>
                                <p class="t3 large">Status</p>
                                <v-select v-model="editor.status"
                                          :items="statuses"
                                          :placeholder="adminItemMenu.status"
                                          outlined
                                          solo style="margin-bottom: -15px" />
                                <p class="mt-5 t3 large">Special Days</p>
                                <p class="t3 small">The menu will show that this item is only available on the selected
                                                    days</p>
                                <v-select v-model="editor.specials"
                                          :items="weekdays"
                                          placeholder="None"
                                          multiple
                                          outlined
                                          solo style="margin-bottom: -15px" />
                            </v-flex>
                        </v-card-text>

                        <v-divider />

                        <v-card-actions>
                            <v-container>
                                <v-row no-gutters>
                                    <v-col class="ma-2">
                                        <v-btn block color="secondary" large @click="checkEditor" class="t4 medium">
                                            Cancel
                                        </v-btn>
                                    </v-col>
                                    <v-col class="ma-2">
                                        <v-btn block color="error" large @click="removeItem" class="t4 medium">Delete
                                        </v-btn>
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col class="ma-2">
                                        <v-btn block
                                               color="success"
                                               :disabled="!editorCheck"
                                               large
                                               @click="saveChanges"
                                               class="t4 medium">Save
                                                                 Changes
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-actions>
                    </v-card>
                </v-tab-item>
            </v-tabs>
        </v-dialog>

        <v-dialog v-model="createSubItem" persistent max-width="290" transition="scroll-y-transition">
            <v-card>
                <v-card-title class="t4 medium">Adding Sub-Item</v-card-title>
                <v-divider />
                <v-card-text class="mt-5" style="margin-bottom: -15px">
                    <v-text-field outlined label="Name" v-model="creation.name" style="margin-bottom: -10px" />
                    <v-text-field outlined
                                  label="Price"
                                  prefix="$"
                                  v-model.number="creation.price"
                                  style="margin-bottom: -10px" />
                </v-card-text>
                <v-divider />
                <v-card-actions>
                    <v-row no-gutters>
                        <v-col class="ma-2">
                            <v-btn block color="secondary" @click="resetEditor" class="t4 medium">Cancel</v-btn>
                        </v-col>
                        <v-col class="ma-2">
                            <v-btn block
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

        <Confirmation :cancel-confirmation="cancel"
                      v-on:continue-edit="continueEdit"
                      v-on:cancel-changes="cancelChanges" />

    </div>
</template>

<script>
    import AdminItemEditor from "./AdminItemEditor";
    import Confirmation from "./Confirmation";

    export default {
        components: {
            AdminItemEditor,
            Confirmation,
        },
        props     : {
            adminItemMenu      : Object,
            adminItemMenuDialog: Boolean,
        },
        data      : function () {
            return {
                editor       : {
                    name    : this.adminItemMenu.name,
                    status  : this.adminItemMenu.status,
                    specials: this.adminItemMenu.specials,
                },
                cancel       : false,
                edit         : false,
                createSubItem: false,
                subItem      : {},
                baseItem     : {},
                creation     : {
                    name : "",
                    price: "",
                },
                tab          : null,
                statuses     : ["In Stock", "Running Low", "Sold Out"],
                weekdays     : ["Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            }
        },
        methods   : {
            checkEditor() {
                let name = this.editor.name !== this.adminItemMenu.name;
                let status = this.editor.status !== this.adminItemMenu.status;
                let specials = this.editor.specials !== this.adminItemMenu.specials;
                if (name || status || specials) {
                    this.cancel = true;
                } else {
                    this.cancelChanges();
                }
            },
            cancelChanges() {
                this.editor = {
                    name    : this.adminItemMenu.name,
                    status  : this.adminItemMenu.status,
                    specials: this.adminItemMenu.specials,
                };
                this.tab = null;
                this.cancel = false;
                this.$emit("toggle-dialog", false);
            },
            continueEdit() {
                this.cancel = false;
            },
            saveChanges() {
                let name = this.editor.name;
                let status = this.editor.status;
                let specials = this.editor.specials;
                /*axios.post("edit-item.php", JSON.stringify({
                                                               oldName: this.adminItemMenu.name,
                                                               name: name,
                                                               status: status,
                                                               specials: specials,
                                                           }));*/
                let object = {
                    old : this.adminItemMenu,
                    item: {
                        name    : name,
                        status  : status,
                        subItems: this.adminItemMenu.subItems,
                        specials: specials
                    }
                };
                this.$emit("update-item", object);
                this.$emit("toggle-dialog", false);
                this.tab = null;
                this.cancel = false;
                this.$emit("toggle-dialog", false);
            },
            removeItem() {
                this.$emit("remove-item", this.adminItemMenu);
                /*axios.post("remove-item.php", JSON.stringify({
                                                                 name: this.adminItemMenu.name,
                                                                 status: this.adminItemMenu.status,
                                                                 subItems: this.adminItemMenu.subItems
                                                             }));*/
            },
            addSubItem() {
                this.adminItemMenu.subItems[this.adminItemMenu.subItems.length] = {
                    name : this.creation.name,
                    price: this.creation.price.toFixed(2)
                };
                /*axios.post("add-subitem.php", JSON.stringify({
                                                                 name: this.adminItemMenu.name,
                                                                 status: this.adminItemMenu.status,
                                                                 subItem: this.creation
                                                             }));*/
                this.adminItemMenu.subItems.sort(function (a, b) {
                    return a.price - b.price;
                });
                this.resetEditor();
            },
            updateSubItem(object) {
                this.adminItemMenu.subItems[object.index] = object.item;
                this.adminItemMenu.subItems.sort(function (a, b) {
                    return a.price - b.price;
                });
            },
            resetEditor() {
                this.createSubItem = false;
                this.creation.name = "";
                this.creation.price = "";
            }
        },
        computed  : {
            validEditor() {
                return this.creation.name === "" || this.creation.price === "";
            },
            editorCheck() {
                let name = this.editor.name !== this.adminItemMenu.name;
                let status = this.editor.status !== this.adminItemMenu.status;
                let specials = this.editor.specials !== this.adminItemMenu.specials;
                return name || status || specials;
            },
        }
    }
</script>
