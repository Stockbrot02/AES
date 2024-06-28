export default {
    methods: {
        showEditModal(index) {
            this.currentIndex = index;
            this.currentItem = this.ausgabenListe[index];
            this.editValue = this.currentItem.Wert;
            this.editCategory = this.currentItem.Kategorie;
            this.editDate = this.formatDateForEdit(this.currentItem.Datum);
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        },
        formatDateForEdit(date) {
            let parts = date.split('.');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        },
        saveEditItem() {
            if (this.currentIndex !== null && this.currentIndex >= 0 && this.currentIndex < this.ausgabenListe.length) {
                this.ausgabenListe[this.currentIndex].Wert = this.editValue;
                this.ausgabenListe[this.currentIndex].Kategorie = this.editCategory;
                this.ausgabenListe[this.currentIndex].Datum = this.formatDate(this.editDate);
                this.currentIndex = null;
                this.currentItem = null;
                this.editValue = null;
                this.editCategory = null;
                this.editDate = null;
            }
            let editModal = bootstrap.Modal.getInstance(document.getElementById('editModal'));
            editModal.hide();
        }
    }
};
