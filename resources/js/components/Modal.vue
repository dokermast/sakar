<template>
    <div class="popup">
        <span>Modal</span>
        <div v-if="modalContent" class="popup-content">
            {{modalContent}}
        </div>
        <button class="modal-default-button" @click="modalClose">Close</button>
    </div>
</template>

<script>
    export default {
        name: "modal",
        props: {
            modalContent: {
                default: ''
            }
        },
        data() {
            return {
            }
        },
        methods: {
            modalClose(){
                this.$emit('modalClose');
            },
        }
    }
</script>

<style scoped>
    .popup {
        padding: 16px;
        position: fixed;
        left: 40%;
        top: 40%;
        width: 300px;
        background: rgba(253, 39, 0, 0.35);
        box-shadow: 0 0 17px 0 #e7e7e7;
        z-index: 1;


    }
</style>
