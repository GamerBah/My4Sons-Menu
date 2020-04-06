<template>
    <v-dialog v-model="homeItemDialog" persistent max-width="290">
        <v-card>
            <v-card-title class="t4 medium">{{ homeItemMenu.name }}</v-card-title>
            <v-divider />

            <v-card-text>
                <v-list two-line disabled
                        v-if="homeItemMenu.subItems.length > 0"
                        class="mt-5 grey lighten-5 elevation-3">
                    <v-list-item-group v-model="homeItemMenu">
                        <v-list-item v-for="sub in homeItemMenu.subItems" :key="sub.name">
                            <v-list-item-content>
                                <v-list-item-title class="t3 medium">{{ sub.name }}</v-list-item-title>
                                <v-list-item-subtitle class="t2 small" style="color: green">${{ sub.price }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
                <p v-else class="mx-2 mt-5 t3 small grey--text">
                    Nothing here? Hmm.
                    <br>Something's probably wrong. Oh well!
                    <br>- Son #2</p>
            </v-card-text>

            <v-divider />

            <v-card-actions>
                <v-container>
                    <v-row no-gutters>
                        <v-col class="ma-2">
                            <v-btn block color="secondary" large @click="$emit('toggle-dialog')" class="t4 medium">
                                Close
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
    export default {
        props: {
            homeItemDialog: Boolean,
            homeItemMenu  : Object,
        },
    }
</script>
