<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar> <img
                    src="data:image/png;base64,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"
                    alt="John"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline" style="font-weight: bold;">Tambah Pengiriman</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-card>
    </v-main>
</template>

<script>

</script>

<style>
.text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
    font-size: 40px;
    font-style: italic;
}
</style>