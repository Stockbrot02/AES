<?php
session_start();
$_userid = $_SESSION["UserID"];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>

<body>


    <header class="bg-dark sticky-top text-white sticky-top shadow lg-3 mb-2" id="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex justify-content-center flex-grow-1">
                    <h1>AES</h1> <br>
                    <?php echo "User id: " . $_userid ?>
                </div>
                <div>
                    <!-- Logout Button -->
                    <form action="../index.php?operation=logout" method="post" class="d-inline">
                        <button class="btn btn-danger logout-btn"><i class="material-icons" id="logoutIcon">logout</i>Abmelden</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navigationbar">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" id="burgerMenu" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="nav nav-pills nav-fill flex-grow-1 justify-content-between text-center">
                        <li class="nav-item">
                            <h5><a class="nav-link active" id="activatedNavbarItem" href="konto.php">ERFASSEN</a></h5>
                        </li>
                        <li class="nav-item">
                            <h5><a class="nav-link " href="view/main.php">AUSWERTEN</a></h5>
                        </li>
                        <li class="nav-item">
                            <h5><a class="nav-link" href="kontakt.php">Platzhalter</a></h5>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div id="inputForm">
            <!-- Expense Input Form -->
            <form v-on:submit.prevent="addExpense">
                <h1>Ausgaben</h1>
                <label for="" class="form-label">Wert (€)</label>
                <input type="text" required class="form-control" v-model="inputValue">
                <label for="" class="form-label">Kategorie</label>
                <select name="" id="" required class="form-select" v-model="inputCategory">
                    <option value="Auto">Auto</option>
                    <option value="Einkaufen">Einkaufen</option>
                    <option value="Essensbestellungen">Essensbestellungen</option>
                    <option value="Feiern">Feiern</option>
                    <option value="Fitness">Fitness</option>
                    <option value="Fußball">Fußball</option>
                    <option value="Handy">Handy</option>
                    <option value="Onlinebestellungen">Onlinebestellungen</option>
                    <option value="Shoppen">Shoppen</option>
                    <option value="Tanken">Tanken</option>
                </select>
                <label for="" class="form-label">Beschreibung</label>
                <textarea name="" id="" class="form-control" v-model="inputDescription"></textarea>
                <label for="" class="form-label">Datum</label>
                <input type="date" class="form-control" v-model="inputDate" v-on:focus="openDatepicker">
                <div class="my-2" style="background-color: grey; width: 200px; display: flex">
                    <span class="material-symbols-outlined">
                        add</span>
                    <button type="submit" >Hinzufügen</button>
                </div>
            </form>
            <!-- Expense Input Form -->

            <h3>Gesamtsumme nach Kategorie</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategorie</th>
                        <th>Summe</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(totalExpense, index) in totalValueByCategory" :key="index">
                        <td>{{totalExpense.Kategorie}}</td>
                        <td>{{formatValue(totalExpense.Summe)}} €</td>
                    </tr>
                </tbody>
            </table>
            <h4>Liste der Ausgaben</h4>
            <br>
            <table class="table">
                <thead>
                    <th>Wert</th>
                    <th>Kategorie</th>
                    <th>Datum</th>
                    <th>Beschreibung</th>
                    <th>#</th>
                </thead>
                <tbody>
                    <tr v-for="(expense, index) in paginatedExpenses" :key="index">
                        <td>{{ formatValue(expense.Value) }}</td>
                        <td>{{ expense.Category }}</td>
                        <td>{{ expense.CreateDate }}</td>
                        <!-- <td>{{ truncateDescription(expense.Description, 30) }}</td> -->
                        <td id="expenseDescription" v-on:click="showFullDescription(expense.Description)">
                            {{truncateDescription(expense.Description, 30)}}
                        </td>
                        <td>{{ expense.UserID }}</td>
                    </tr>
                </tbody>
            </table>
            <!-- <ul>
                <li v-for="(item, index) in expenseList" :key="index" style="list-style-type: none">
                    <div class="card">
                        <div class="card-body">
                            <p><b>Wert: </b>{{ formatValue(item.Value)}} €</p>
                            <p><b>Kategorie: </b>{{item.Category}}</p>
                            <p><b>Datum: </b>{{item.CreateDate}}</p>
                            <p><b>Beschreibung: </b>{{item.Description}}</p>
                            <p><b>Id: </b>{{item.UserID}}</p>
                            <button v-on:click="showEditModal(index)">Bearbeiten</button>
                            <button v-on:click="showDeleteModal(index)">Löschen</button>
                        </div>
                    </div>
                </li>
            </ul> -->

            <!-- Modal to delete expense -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">EINTRAG LÖSCHEN</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><b>Wert: </b> {{ currentItem ? currentItem.Wert : '' }}</p>
                            <p><b>Kategorie: </b> {{ currentItem ? currentItem.Kategorie : '' }}</p>
                            <p><b>Datum: </b> {{ currentItem ? currentItem.Datum : '' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="button" class="btn btn-danger" v-on:click="confirmDeleteItem">Löschen</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal to delete expense -->

            <!-- Modal to edit expense -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">EINTRAG BEARBEITEN</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="editValue" class="form-label">Wert</label>
                            <input type="text" id="editValue" class="form-control" v-model="editValue">
                            <label for="editCategory" class="form-label">Kategorie</label>
                            <select id="editCategory" class="form-select" v-model="editCategory">
                                <option value="Auto">Auto</option>
                                <option value="Tanken">Tanken</option>
                                <option value="Essensbestellungen">Essensbestellungen</option>
                                <option value="Einkaufen">Einkaufen</option>
                                <option value="Feiern">Feiern</option>
                                <option value="Shoppen">Shoppen</option>
                                <option value="Onlinebestellungen">Onlinebestellungen</option>
                                <option value="Fitness">Fitness</option>
                                <option value="Handy">Handy</option>
                            </select>
                            <label for="editDate" class="form-label">Datum</label>
                            <input type="date" id="editDate" class="form-control" v-model="editDate" v-on:focus="openDatepicker">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="button" class="btn btn-primary" v-on:click="saveEditItem">Speichern</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal to edit expense -->

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item" :class="{ disabled: currentPage === 1 }">
                        <a class="page-link" href="#" aria-label="Previous" v-on:click.prevent="prevPage">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: currentPage === page }">
                        <a class="page-link" href="#" v-on:click.prevent="goToPage(page)">{{ page }}</a>
                    </li>
                    <li class="page-item" :class="{ disabled: currentPage === totalPages }">
                        <a class="page-link" href="#" aria-label="Next" v-on:click.prevent="nextPage">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- Pagination -->
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

    <!-- <script src="handleInputForm.js" type="module"></script> -->
    <script src="..\public\javascript\inputFormAddExpense.js" type="module"></script>
    <!-- <script src="inputFormDeleteExpense.js" type="module"></script>
    <script src="inputFormEditExpense.js" type="module"></script> -->


    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>



</html>