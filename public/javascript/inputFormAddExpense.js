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
            totalValueByCategory: [],
            expensePerPage: 10, // amount of expenses per Page
            currentPage: 1,
            windowWidth: window.innerWidth
            // currentIndex: null,
            // currentItem: null,
            // editValue: '',
            // editCategory: '',
            // editDate: ''
        }
    },
    computed: {
        // calculate amount of expenses per Page
        paginatedExpenses() {
            const start = (this.currentPage - 1) * this.expensePerPage;
            const end = start + this.expensePerPage;
            return this.expenseList.slice(start, end);
        },
        // calculate total number of sites
        totalPages() {
            return Math.ceil(this.expenseList.length / this.expensePerPage);
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
                .then(response => {
                    console.log("Raw response:", response);
                    if (!response.ok) {
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
        formatValue(value) {
            return value.replace(".", ",");
        },
        // load summarized expense values by category
        fetchTotalExpensesByCategory() {
            fetch('../load_totalExpenseByCategory.php')
                .then(response => response.json())
                .then(data => {
                    this.totalValueByCategory = data;
                })
                .catch(error => console.error("Error fetching total expense value by category: ", error));
        },
        goToPage(pageNumber) {
            this.currentPage = pageNumber;
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        // truncate description on smaller screensize
        truncateDescription(description, length) {
            if (this.windowWidth <= 768) {
                if (!description) {
                    return "";
                }
                if (description.length > length) {
                    return description.substring(0, length) + "...";
                }
                return description;
            }
            return description;

        },
        // show full description on click
        showFullDescription(description) {
            if (this.windowWidth <= 768) {
                if (description !== "") {
                    alert("Komplette Beschreibung:  \n\n" + description);
                }
            }
        },
        // update the window width on resize
        updateWindowWidth() {
            this.windowWidth = window.innerWidth;
        }
    },
    mounted() {
        this.fetchExpenses();
        this.fetchTotalExpensesByCategory();
        window.addEventListener("resize", this.updateWindowWidth);
    },
    beforeUnmount() {
        window.removeEventListener("resize", this.updateWindowWidth);
    },
});

inputForm.mount("#inputForm");
