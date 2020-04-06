<template>
    <div id="app">
        <v-app>
            <v-app-bar app>
                <v-toolbar-title>
                    <span class="t1 xxlarge">MY 4 SONS BBQ</span>
                </v-toolbar-title>
                <span class="mx-10 t3 small hidden-xs-only" v-if="!$route.matched.some(({ name }) => name === 'admin')">Refreshing in {{ timer }} seconds</span>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn text color="primary" target="_blank" href="https://www.facebook.com/My4SonsBBQ/">
                        <v-icon class="xxlarge">mdi-facebook-box</v-icon>
                        <span class="t2 medium hidden-sm-and-down" style="margin-left: 5px">Facebook</span>
                    </v-btn>
                    <v-divider vertical inset />
                    <v-btn text color="success" target="_blank" href="https://goo.gl/maps/LL4RGieJHAHXW8cz5">
                        <v-icon class="xxlarge">mdi-google-maps</v-icon>
                        <span class="t2 medium hidden-sm-and-down" style="margin-left: 5px">Maps</span>
                    </v-btn>
                </v-toolbar-items>
            </v-app-bar>
            <router-view :items="items"
                         v-on:add-item="addItem($event)"
                         v-on:update-item="updateItem($event)"></router-view>
        </v-app>
    </div>
</template>

<script>
    export default {
        name   : 'App',
        data   : () => ({
            items: [],
            timer: 60,
        }),
        methods: {
            grabList() {
                axios.get("get-items.php").then((response) => {
                    this.items = response.data;
                });
            },
            addItem(object) {
                this.items.push(object);
            },
            updateItem(object) {
                this.items.splice(this.items.indexOf(object.old), 1, object.item);
            }
        },
        created() {
            this.grabList();
            setInterval(() => {
                if (this.timer > 0) {
                    this.timer--;
                } else {
                    this.timer = 60;
                }
            }, 1000);
            setInterval(function () {
                if (!this.$route.matched.some(({name}) => name === 'admin')) {
                    this.grabList();
                }
            }, 60000);
        },
    };
</script>
