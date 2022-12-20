<template>
    <div class="dashboard">
        <v-navigation-drawer class="fullheight" width="256" v-model="drawer" absolute temporary color="grey lighten-5">
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">KELOMPOK C</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav>
                <v-list-item
                    v-for="item in items"
                    :key="item.title"
                    link
                    color="light-blue darken-4"
                    tag="router-link"
                    :to="item.to"
                >
                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar color="#d66700" dark>
            <v-app-bar-nav-icon
                @click="drawer = true"
                color="white" justify="space-around"></v-app-bar-nav-icon>
                <v-list-item-title class="title">KELOMPOK C</v-list-item-title>
                <v-btn color="white" text @click="cancelUpdate">Keluar</v-btn>
            <VSpacer/>    
        </v-app-bar>
        <div class="fullheight pa-5">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
        name: "DashboardIndex",
        data() {
            return {
                drawer: false,
                group: null,
                items: [
                    { title: "Home", to:"/home" },
                    { title: "Buah", to:"/buah" },
                    { title: "Tambah Pengiriman", to:"/add" },
                    { title: "Cek Pengiriman", to:"/cek" },
                    { title: "Hubungi Kami", to:"/hub" },
                    { title: "Profil User", to:"/prof" },
                    // { title: "Keluar", to:"/keluar" },
                ],
            };
        },
    };
</script>
<style scoped>
    .fullheight {
        min-height: 100vh !important;
    }
</style>