// import inputFormEditExpense from './inputFormEditExpense.js';
// import inputFormDeleteExpense from './inputFormDeleteExpense.js';

const inputForm = Vue.createApp({
    data() {
        return {
            inputID: null,
            inputValue: '',
            inputCategory: '',
            inputDate: '',
            inputDescription: '',
            expenseList: [],
            totalValueByCategory: []
            // currentIndex: null,
            // currentItem: null,
            // editValue: '',
            // editCategory: '',
            // editDate: ''
        }
    },
    methods: {
        // ...inputFormEditExpense.methods, //include methods to edit expenses 
        // ...inputFormDeleteExpense.methods, //include mehtods to delete expenses
        // addItem() {
        //     let today = new Date();
        //     let formattedDate = ('0' + today.getDate()).slice(-2) + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear();
        //     let item = {
        //         Wert: this.inputValue,
        //         Kategorie: this.inputCategory,
        //         Datum: this.inputDate ? this.formatDate(this.inputDate) : formattedDate
        //     }
        //     this.expenseList.push(item);
        //     this.inputValue = null;
        //     this.inputCategory = null;
        //     this.inputDate = null;
        addExpense() {
            const data = new URLSearchParams();
            let formattedDate = this.inputDate ? this.formatDate(this.inputDate) : this.getCurrentDateFormatted();

            data.append('value', this.inputValue);
            data.append('category', this.inputCategory);
            data.append('date', this.inputDate);
            data.append('date', formattedDate);
            data.append('description', this.inputDescription);

            console.log("Sending data:", {
                value: this.inputValue,
                category: this.inputCategory,
                date: this.inputDate,
                description: this.inputDescription
            });

            fetch('../add_expense.php', {
                method: 'POST',
                body: data
            })
                // .then(response => response.json())
                .then(response =>{
                    console.log("Raw response:", response);
                    if (!response.ok){
                        throw new Error("Network response was not ok " + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Parsed JSON: ", data);
                    if (data.message === 'Eintrag erfolgreich hinzugefügt') {
                        this.fetchExpenses(); // update list of single expenses
                        this.fetchTotalExpensesByCategory(); // update list of summarised expenses
                        this.inputValue = '';
                        this.inputCategory = '';
                        this.inputDate = '';
                        this.inputDescription = '';
                    }
                    else {
                        console.error(data.message);
                    }
                })
                .catch(error => console.error('Error', error));
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
        },
        getCurrentDateFormatted() {
            const today = new Date();
            return ('0' + today.getDate()).slice(-2) + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear();
        },
        // load single expense values
        fetchExpenses() {
            fetch('../load_expenses.php')
                .then(response => response.json())
                .then(data => {
                    this.expenseList = data;
                })
                .catch(error => console.error("Error fetching expenses:", error));
        },
        // Format value 'xx.xx' to -> 'xx,xx'
        formatValue(value){
            return value.replace(".", ",");
        },
        // load summarized expense values by category
        fetchTotalExpensesByCategory(){
            fetch('../load_totalExpenseByCategory.php')
                .then(response => response.json())
                .then(data =>{
                    this.totalValueByCategory = data;
                })
                .catch(error => console.error("Error fetching total expense value by category: ", error));
        }
    },
    mounted() {
        this.fetchExpenses();
        this.fetchTotalExpensesByCategory();
    }
});

inputForm.mount("#inputForm");
