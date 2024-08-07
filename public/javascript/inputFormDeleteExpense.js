export default {
    methods: {
        showDeleteModal(index) {
            this.currentIndex = index;
            this.currentItem = this.ausgabenListe[index];
            let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        },
        confirmDeleteItem() {
            if (this.currentIndex !== null && this.currentIndex >= 0 && this.currentIndex < this.ausgabenListe.length) {
                let deletedItem = this.ausgabenListe.splice(this.currentIndex, 1)[0];
                this.currentIndex = null;
                this.currentItem = null;
            }
            let deleteModal = bootstrap.Modal.getInstance(document.getElementById('deleteModal'));
            deleteModal.hide();
        }
    }
};
