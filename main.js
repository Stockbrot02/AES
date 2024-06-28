const inputForm = Vue.createApp({
    data() {
        return {
            inputID: null,
            inputValue: null,
            inputCategory: null,
            inputDate: null,
            ausgabenListe: [],
            currentIndex: null,
            currentItem: null
        }
    },
    methods: {
        addItem() {
            let today = new Date();
            let formattedDate = ('0' + today.getDate()).slice(-2) + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear();
            let item = {
                Wert: this.inputValue,
                Kategorie: this.inputCategory,
                Datum: this.inputDate ? this.formatDate(this.inputDate) : formattedDate
            }
            this.ausgabenListe.push(item)
            this.inputValue = null
            this.inputCategory = null
            this.inputDate = null
        },
        //Format date (YYYY-MM-DD) --> (DD.MM.YYYY)
        formatDate(date) {
            let d = new Date(date);
            let day = ('0' + d.getDate()).slice(-2);
            let month = ('0' + (d.getMonth() + 1)).slice(-2);
            let year = d.getFullYear();
            return `${day}.${month}.${year}`;
        },
        showDeleteModal(index) {
            this.currentIndex = index;
            this.currentItem = this.ausgabenListe[index];
            // Open modal
            $('#deleteModal').modal('show');
        },
        confirmDeleteItem() {
            if (this.currentIndex !== null && this.currentIndex >= 0 && this.currentIndex < this.ausgabenListe.length) {
                let deletedItem = this.ausgabenListe.splice(this.currentIndex, 1)[0];
                this.currentIndex = null;
                this.currentItem = null;
            }
            // Close modal
            $('#deleteModal').modal('hide');
        }
    }
});
inputForm.mount("#inputForm")
