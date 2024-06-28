import inputFormEditExpanse from './inputFormEditExpanse.js';
import inputFormDeleteExpanse from './inputFormDeleteExpanse.js';

const inputForm = Vue.createApp({
    data() {
        return {
            inputID: null,
            inputValue: null,
            inputCategory: null,
            inputDate: null,
            ausgabenListe: [],
            currentIndex: null,
            currentItem: null,
            editValue: null,
            editCategory: null,
            editDate: null
        }
    },
    methods: {
        ...inputFormEditExpanse.methods, //include methods to edit expanses 
        ...inputFormDeleteExpanse.methods, //include mehtods to delete expanses
        addItem() {
            let today = new Date();
            let formattedDate = ('0' + today.getDate()).slice(-2) + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear();
            let item = {
                Wert: this.inputValue,
                Kategorie: this.inputCategory,
                Datum: this.inputDate ? this.formatDate(this.inputDate) : formattedDate
            }
            this.ausgabenListe.push(item);
            this.inputValue = null;
            this.inputCategory = null;
            this.inputDate = null;
        },
        //Open datepicker on focus
        openDatepicker(event) {
            event.target.showPicker();
        },
        formatDate(date) {
            let d = new Date(date);
            let day = ('0' + d.getDate()).slice(-2);
            let month = ('0' + (d.getMonth() + 1)).slice(-2);
            let year = d.getFullYear();
            return `${day}.${month}.${year}`;
        }
    }
});

inputForm.mount("#inputForm");
