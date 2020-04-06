<template>
    <v-dialog v-model="cancelConfirmation" max-width="380px">
        <v-card>
            <v-card-text>
                <v-content>
                    <p class="text-center t4 medium" style="font-size: large">Any unsaved changes will be lost!</p>
                    <br />
                    <p class="text-center t4 medium" style="font-size: large">Are you sure?</p>
                </v-content>
            </v-card-text>
            <v-divider />
            <v-card-actions class="justify-center">
                <v-btn class="ma-5 px-10 t4 medium" color="error" @click="$emit('continue-edit')">No</v-btn>
                <v-btn class="ma-5 px-10 t4 medium" color="success" @click="$emit('cancel-changes')">Yes</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            cancelConfirmation: Boolean,
        }
    }
</script>
