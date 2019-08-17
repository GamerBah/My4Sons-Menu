<template>
    <div id="app">
        <v-content>
            <v-container>
                <v-layout text-center wrap>

                    <v-flex mb-4>
                        <p class="t3">
                            This is dynamic! When we we're running low on
                            <br>something in the restaurant, that'll be shown right here! </p>
                        <v-divider inset/>
                    </v-flex>

                    <MenuTable :items="items"/>

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
                    <v-btn color="secondary" icon v-on:click="checkCookie">
                        <v-icon v-on="on">mdi-login</v-icon>
                    </v-btn>
                </template>
                <span class="t2">Login to Editor</span>
            </v-tooltip>
        </v-footer>

        <v-dialog v-model="login" ref="loginDialog" max-width="380px" v-on:click:outside="formReset">
            <v-card>
                <v-card-title>
                    <v-layout justify-center>
                        <span class="headline">
                            <v-icon>mdi-key</v-icon>
                            Login</span>
                    </v-layout>
                </v-card-title>
                <v-divider/>
                <v-card-text>
                    <v-form v-model="valid" ref="loginForm">
                        <v-container>
                            <v-text-field clearable prepend-icon="mdi-account-box"
                                          v-model="username"
                                          :rules="formRules"
                                          label="Username"
                                          required/>
                            <v-text-field prepend-icon="mdi-lock"
                                          v-model="password"
                                          :rules="formRules"
                                          type="password"
                                          label="Password"
                                          required/>
                        </v-container>
                    </v-form>
                </v-card-text>
                <v-divider/>
                <v-card-actions class="justify-center">
                    <v-btn class="ma-5 px-10 t4" color="secondary" @click="formReset">Close</v-btn>
                    <v-btn class="ma-5 px-10 t4" color="success" :disabled="!valid" @click="attemptLogin">Login</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-snackbar v-model="snackbar" color="error">
            <span class="align-center">Incorrect Username or Password</span>
        </v-snackbar>
    </div>
</template>

<script>
    import axios from 'axios';
    import MenuTable from "../components/MenuTable";

    export default {
        components: {
            MenuTable,
        },
        data: () => ({
            login: false,
            valid: false,
            snackbar: false,
            username: "",
            password: "",
            formRules: [
                v => !!v || '',
            ],
        }),
        props: {
            items: Array,
        },
        methods: {
            checkCookie() {
                axios.get("http://localhost:8018/public/validate.php")
                     .then((response) => {
                         if (response.data === 0) {
                             // Auth Cookie Present
                             console.log("Cookie!");
                             this.toAdmin();
                         } else {
                             this.login = true;
                         }
                     })
                     .catch((err) => console.log(err));
            },
            attemptLogin() {
                axios.post("http://localhost:8018/public/login.php", {
                    a: this.username,
                    b: this.password,
                }).then((response) => {
                    if (response.data === 0) {
                        // Correct Username/Password
                        this.login = false;
                        this.toAdmin();
                    } else {
                        // Incorrect Username/Password
                        this.snackbar = true;
                        this.password = "";
                    }
                }).catch(function (err) {
                    console.log(err);
                });
            },
            formReset() {
                this.login = false;
                this.$refs.loginForm.reset();
                this.login = false;
            },
            toAdmin() {
                this.$router.push("/admin")
            }
        },
    };
</script>
