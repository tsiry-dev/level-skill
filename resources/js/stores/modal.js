import { defineStore } from "pinia";

export const useModalStore = defineStore('modal',{
    state () {
        return {
            isActive: false
        }
    },

    actions: {
        toggleModal() {
            this.isActiveModal = !this.isActiveModal;
        }
    }
});
