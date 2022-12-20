import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

function importComponent(path){
    return () => import(`./components/${path}.vue`);
}

const router = new VueRouter({
    mode: "history",
    routes: [
        // {
        //     path: "/",
        //     name: "user",
        //     component: importComponent("WelcomeLayout"),
        //     children: [
        //         {
        //             path: "/",
        //             name: "Root",
        //             component: importComponent("WelcomePage"),
        //         },
        //         {
        //             path: "/log",
        //             name: "Login",
        //             component: importComponent("LoginPage"),
        //         },
        //         {
        //             path: "/reg",
        //             name: "Reg",
        //             component: importComponent("RegisterPage"),
        //         },
        //     ],
        // },
        {
            path: "/",
            name: "user",
            component: importComponent("DashboardLayout"),
            children: [
                {
                    path: "/home",
                    name: "Home",
                    component: importComponent("HomePage"),
                },
                {
                    path: "/buah",
                    name: "Buah",
                    component: importComponent("BuahList"),
                },
                {
                    path: "/add",
                    name: "Tambah Pengiriman",
                    component: importComponent("TambahPengiriman"),
                },
                {
                    path: "/cek",
                    name: "Cek Pengiriman",
                    component: importComponent("CekPengiriman"),
                },
                {
                    path: "/hub",
                    name: "Hubungi Kami",
                    component: importComponent("HubungiKami"),
                },
                {
                    path: "/prof",
                    name: "Profil User",
                    component: importComponent("ProfilUser"),
                },
            ],
        },
    ],
});

export default router;