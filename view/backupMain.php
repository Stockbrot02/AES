<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\public\css\style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body>


    <header class="bg-dark sticky-top text-white sticky-top shadow lg-3 mb-2" id="header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex justify-content-center flex-grow-1">
                    <a href="../index.php" id="companyNameTitle">
                        <h1>AES</h1>
                    </a>
                </div>
                <div>
                    <!-- Logout Button -->
                    <form action="../index.php?operation=logout" method="post" class="d-inline">
                        <button class="btn btn-danger logout-btn">
                            <i class="material-icons" id="logoutIcon">logout</i>Abmelden
                        </button>
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
                            <h5><a class="nav-link" href="konto.php">ERFASSEN</a></h5>
                        </li>
                        <li class="nav-item">
                            <h5><a class="nav-link active" id="activatedNavbarItem" href="solarmodule.php">AUSWERTEN</a></h5>
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
            <form v-on:submit.prevent="addItem">
                <h1>Ausgaben</h1>
                <label for="" class="form-label">Wert (€)</label>
                <input type="text" required class="form-control" v-model="inputValue">
                <label for="" class="form-label">Kategorie</label>
                <select name="" id="" class="form-select" v-model="inputCategory">
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
                <label for="" class="form-label">Datum</label>
                <input type="date" class="form-control" v-model="inputDate" v-on:focus="openDatepicker">
                <button type="submit" class="my-3">Hinzufügen</button>
            </form>

            <h4>Liste der Ausgaben</h4>
            <br>
            <ul>
                <li v-for="(item, index) in ausgabenListe" :key="index" style="list-style-type: none">
                    <div class="card">
                        <div class="card-body">
                            <p>{{item.Wert}} €</p>
                            <p>{{item.Kategorie}}</p>
                            <p>{{item.Datum}}</p>
                            <button v-on:click="showDeleteModal(index)">Löschen</button>
                            <button v-on:click="showEditModal(index)">Bearbeiten</button>
                        </div>
                    </div>
                </li>
            </ul>

            <!-- Modal to delete expanse -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">EINTRAG LÖSCHEN</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Wert: {{ currentItem ? currentItem.Wert : '' }}</p>
                            <p>Kategorie: {{ currentItem ? currentItem.Kategorie : '' }}</p>
                            <p>Datum: {{ currentItem ? currentItem.Datum : '' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abbrechen</button>
                            <button type="button" class="btn btn-danger" v-on:click="confirmDeleteItem">Löschen</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal to edit expanse -->
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
        </div>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>

    <!-- <script src="handleInputForm.js" type="module"></script> -->
    <script src="..\public\javascript\inputFormAddExpanse.js" type="module"></script>
    <!-- <script src="inputFormDeleteExpanse.js" type="module"></script>
    <script src="inputFormEditExpanse.js" type="module"></script> -->


    <!-- Bootstrap JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>



</html>