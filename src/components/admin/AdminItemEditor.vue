<template>
    <div>
        <v-dialog v-model="itemEditorDialog" persistent max-width="290">
            <v-card>
                <v-card-title class="t4 medium">Editing Sub-Item</v-card-title>
                <v-divider />
                <v-card-text class="mt-5" style="margin-bottom: -25px">
                    <v-text-field outlined
                                  ref="nameInput"
                                  label="Name"
                                  :placeholder="editorItem.name"
                                  v-model="editor.name" />
                    <v-text-field outlined ref="priceInput"
                                  label="Price"
                                  prefix="$"
                                  :placeholder="editorItem.price"
                                  v-model.number="editor.price" />
                </v-card-text>
                <v-divider />
                <v-card-actions>
                    <v-container>
                        <v-row no-gutters>
                            <v-col class="ma-2">
                                <v-btn block color="secondary" large @click="checkEditor" class="t4 medium">Cancel
                                </v-btn>
                            </v-col>
                            <v-col class="ma-2">
                                <v-btn block color="error" large @click="removeSubItem" class="t4 medium">Delete</v-btn>
                            </v-col>
                        </v-row>
                        <v-row no-gutters>
                            <v-col class="ma-2">
                                <v-btn block
                                       color="success"
                                       :disabled="editor.name === '' && editor.price === ''"
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
        </v-dialog>

        <Confirmation :cancel-confirmation="cancel"
                      v-on:continue-edit="continueEdit"
                      v-on:cancel-changes="cancelChanges" />

    </div>
</template>

<script>
    import Confirmation from "./Confirmation";

    export default {
        components: {
            Confirmation,
        },
        props     : {
            baseItem        : Object,
            editorItem      : Object,
            itemEditorDialog: Boolean,
        },
        data      : function () {
            return {
                editor: {
                    name : "",
                    price: "",
                },
                cancel: false,
            }
        },
        methods   : {
            checkEditor() {
                if (this.editor.name !== "" || this.editor.price !== "") {
                    this.$emit("toggle-editor", false);
                    this.cancel = true;
                } else {
                    this.cancelChanges();
                }
            },
            cancelChanges() {
                this.editor = {
                    name : "",
                    price: "",
                };
                this.cancel = false;
                this.$emit("toggle-editor", false);
                this.$emit("toggle-dialog", true);
            },
            saveChanges() {
                let subName = this.editor.name === "" ? this.editorItem.name : this.editor.name;
                let subPrice = this.editor.price === "" ? this.editorItem.price : this.editor.price;
                let index = this.baseItem.subItems.indexOf(this.editorItem);
                this.$emit("update-sub-item", {index: index, item: {name: subName, price: subPrice.toFixed(2)}});
                /*axios.post("edit-subitem.php", JSON.stringify({
                                                                  name: this.baseItem.name,
                                                                  status: this.baseItem.status,
                                                                  origin: this.editorItem.name,
                                                                  subName: subName,
                                                                  subPrice: subPrice.toFixed(2),
                                                              }));*/
                this.cancelChanges();
            },
            continueEdit() {
                this.cancel = false;
                this.$emit("toggle-editor", true);
            },
            removeSubItem() {
                let array = this.baseItem.subItems;
                array.splice(array.indexOf(this.editorItem), 1);
                /*axios.post("remove-subitem.php", JSON.stringify({
                                                                    name: this.baseItem.name,
                                                                    status: this.baseItem.status,
                                                                    subName: this.editorItem.name
                                                                }));*/
                this.cancelChanges();
            },
        },
    }
</script>
