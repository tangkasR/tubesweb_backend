<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar> <img
                        src="https://thumbs.dreamstime.com/b/cute-panda-bear-cartoon-chef-vectorcooking-cookie-sweet-bakery-cute-panda-bear-cartoon-chef-vector-cooking-cookiesweet-bakery-216614619.jpg"
                        alt="John"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">Buah</v-list-item-title>
                    <v-list-item-subtitle>200710792</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-card-title>
                <v-text-field v-model="search" append-icon="mdi-magnify" label="Search" outlined hide details
                    style="margin-top: 30px"></v-text-field>
                <v-spacer></v-spacer>
                <v-btn color="primary" dark @click="dialog = true"> Tambah </v-btn>
            </v-card-title>
        </v-card>
        <v-card>
            <v-data-table :headers="headers" :items="buahs" :search="search" item-key="name" class="elevation-1">
                <template v-slot:[`item.actions`]="{ item }">
                    <v-btn class="ma-2" outlined small color="error" @click="dialogEdit = true; itemContent = item; editItem(item)">
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                    <v-btn @click="deleteItem(item)" class="ma-2" outlined small color="success">
                        <v-icon> mdi-trash-can-outline</v-icon>
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog transition="dialog-top-transition" v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-toolbar color="brown darken-1" dark class="headline">Tambah Pesanan</v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="formBuah.name" label="Name" required></v-text-field>
                        <v-text-field v-model="formBuah.stok" label="Stok" suffix="buah" required></v-text-field>
                        <v-text-field v-model="formBuah.harga" label="Harga" prefix="$" required></v-text-field>
                        <v-select v-model="formBuah.kondisi" :items="[`Segar`, `Sangat Baik`, 'Hampir Busuk']" label="Kondisi" required></v-select>
                        <v-combobox
                            v-model="formBuah.penyimpanan" :items="[`Kulkas`, `Suhu Rendah`, `Luar Ruangan`, 'Lembab']" multiple
                            label="Penyimpanan" required 
                        ></v-combobox>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="save"> Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-dialog transition="dialog-bottom-transition" v-model="dialogEdit" persistent max-width="600px">
            <v-card>
                <v-toolbar color="brown darken-1" dark class="headline">Edit Pesanan</v-toolbar>
                <v-card-text>
                    <v-container>
                        <v-text-field v-model="formBuahEdit.name" label="Name" required></v-text-field>
                        <v-text-field v-model="formBuahEdit.stok" label="Stok" suffix="buah" required></v-text-field>
                        <v-text-field v-model="formBuahEdit.harga" label="Harga" prefix="$" required></v-text-field>
                        <v-select v-model="formBuahEdit.kondisi" :items="[`Segar`, `Sangat Baik`, 'Hampir Busuk']" label="Kondisi" required></v-select>
                        <v-combobox
                            v-model="formBuahEdit.penyimpanan" :items="[`Kulkas`, `Suhu Rendah`, `Luar Ruangan`, 'Lembab']" 
                            label="Penyimpanan" required 
                        ></v-combobox>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelUpdate"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="saveUpdate"> Save </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-main>
</template>
<script>
export default {
    name: "BuahList",
    data() {
        return {
            search: null,
            dialog: false,
            timeout: 1000,
            dialogEdit: false,
            itemContent: [],
            indexItem: null,
            headers: [
                {
                    text: "Name",
                    align: "start",
                    sortable: true,
                    value: "name",
                },
                { text: "Stok", value: "stok" },
                { text: "Harga", value: "harga" },
                { text: "Kondisi", value: "kondisi" },
                { text: "Penyimpanan", value: "penyimpanan" },
                { text: "Actions", value: "actions" },
            ],
            selectedIndex: -1,
            buahs: [
                {
                    name: "Mangga",
                    stok: 10,
                    harga: "10000",
                    kondisi: "Sangat Baik",
                    penyimpanan: "Kulkas,Suhu Rendah",
                },
                {
                    name: "Apel",
                    stok: 22,
                    harga: "10000",
                    kondisi: "Sangat Baik",
                    penyimpanan: "Kulkas",
                },
                {
                    name: "Jeruk",
                    stok: 25,
                    harga: "10000",
                    kondisi: "Sangat Baik",
                    penyimpanan: "Kulkas",
                },
            ],
            formBuah: {
                name: null,
                stok: null,
                harga: null,
                kondisi: null,
                penyimpanan: null,
            },
            formBuahEdit: {
                name: null,
                stok: null,
                harga: null,
                kondisi: null,
                penyimpanan: null,
            },
        };
    },
    methods: {
        save() {
            this.buahs.push(this.formBuah);
            this.resetForm();
            this.dialog = false;
        },
        cancel() {
            this.resetForm();
            this.dialog = false;
        },
        saveUpdate() {
            Object.assign(this.buahs[this.selectedIndex], this.formBuahEdit);
            this.resetForm();
            this.dialogEdit = false;
        },
        cancelUpdate() {
            this.selectedIndex = -1;
            this.resetForm();
            this.dialogEdit = false;
        },
        resetForm() {
            this.formBuah = {
                name: null,
                stok: null,
                harga: null,
                kondisi: null,
                penyimpanan: null,
            };
            this.formBuahEdit = {
                name: null,
                stok: null,
                harga: null,
                kondisi: null,
                penyimpanan: null,
            };
        },
        deleteItem(item){
            this.$confirm("Are you sure to delete this?").then(() => {
                const temp = this.buahs.indexOf(item)
                if(temp > -1){
                    this.buahs.splice(temp, 1)
                }
            });
        },
        editItem(item) {
            this.selectedIndex = this.buahs.indexOf(item);
            this.formBuahEdit = Object.assign({}, item);
            this.dialogEdit = true;
        },
    },
};
</script>
<style>
.text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
    font-size: 40px;
    font-style: italic;
}
</style>