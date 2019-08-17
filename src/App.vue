<template>
    <div id="app">
        <v-app>
            <v-app-bar app>
                <v-toolbar-title class="headline text-uppercase">
                    <span class="t1">MY 4 SONS BBQ</span>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn text color="primary" target="_blank" href="https://www.facebook.com/My4SonsBBQ/">
                        <v-icon style="font-size: xx-large">mdi-facebook-box</v-icon>
                        <span class="t2" style="margin-left: 5px">Facebook</span>
                    </v-btn>
                    <v-divider vertical inset/>
                    <v-btn text color="success" target="_blank" href="https://goo.gl/maps/LL4RGieJHAHXW8cz5">
                        <v-icon style="font-size: xx-large">mdi-google-maps</v-icon>
                        <span class="t2" style="margin-left: 5px">Maps</span>
                    </v-btn>
                </v-toolbar-items>
            </v-app-bar>
            <router-view :items="items"/>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: 'App',
        data: () => ({
            items: [],
        }),
        created() {
            axios.get("items.json").then((response) => {
                this.items = response.data;
            });
        },
    };
</script>
