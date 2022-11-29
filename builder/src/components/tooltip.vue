<template>
    <v-tooltip top>
        <template v-slot:activator="{ on, attrs }">
            <span v-bind="attrs" v-on="on">{{title ? title : '?'}}</span>
        </template>
        <slot name="content"></slot>
    </v-tooltip>
</template>
<script>

export default {
    props: {
        title: String
    }
}
</script>