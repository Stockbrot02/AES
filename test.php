<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formular mit Vue.js</title>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div id="app">
        <h1>Neuen Datensatz hinzufügen</h1>
        <form @submit.prevent="addRecord">
            <label for="firstname">Vorname:</label>
            <input type="text" id="firstname" v-model="firstname" required>
            <br>
            <label for="lastname">Nachname:</label>
            <input type="text" id="lastname" v-model="lastname" required>
            <br>
            <button type="submit">Hinzufügen</button>
        </form>
        
        <div v-if="responseMessage">{{ responseMessage }}</div>
        
        <h2>Gespeicherte Datensätze</h2>
        <ul>
            <li v-for="user in users" :key="user.firstname + user.lastname">
                {{ user.name }} {{ user.surname }}
            </li>
        </ul>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                firstname: '',
                lastname: '',
                responseMessage: '',
                users: []
            },
            methods: {
                addRecord() {
                    axios.post('add_record.php', {
                        firstname: this.firstname,
                        lastname: this.lastname
                    })
                    .then(response => {
                        this.responseMessage = response.data;
                        this.firstname = '';
                        this.lastname = '';
                        this.fetchRecords(); // Holen Sie die neuen Datensätze
                    })
                    .catch(error => {
                        console.error(error);
                    });
                },
                fetchRecords() {
                    axios.get('get_records.php')
                    .then(response => {
                        this.users = response.data;
                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
            },
            mounted() {
                this.fetchRecords(); // Holen Sie die Datensätze beim Laden der Seite
            }
        });
    </script>
</body>
</html>
