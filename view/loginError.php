<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>

    <style>
        body {
            /* font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; */
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            margin-top: 100px;
            width: 30%;
        }

        .card {
            margin-top: 30px;
            /*delete border of bootstrap card class*/
            border: none;
            height: 400px;
            /*set individual border*/
            border-top: 5px solid #279b4f;
            box-shadow: 3px 0px 14px -1px rgba(51, 51, 51, 1);
            -webkit-box-shadow: 3px 0px 14px -1px rgba(51, 51, 51, 1);
            -moz-box-shadow: 3px 0px 14px -1px rgba(51, 51, 51, 1);
        }

        .loginUsernameInput {
            border-bottom: 1px solid black;
            border-radius: 0;
        }

        .loginPasswordInput {
            border-bottom: 1px solid black;
            border-radius: 0;
        }

        .loginBtn {
            background-color: #279b4f;
            border: none;
            width: 50%;
        }


        .card-body .form-control:focus {
            border: 2px solid black;
            box-shadow: none;
        }

        .loginBtn:hover {
            background-color: #1f7a3f;
        }

        @media (max-width: 1024px) {
            .container {
                width: 500px;
            }
        }
    </style>

    <div class="container">
        <h1 class="text-center">NHAMOS</h1>
        <div class="card">
            <div class="card-header text-center">
                <h3>Bei Ihrem Konto anmelden</h3>
            </div>
            <div class="card-body">
                <form action="index.php?operation=login" class="needs-validation was-validated" method="post" novalidate>
                    <div class="mb-1">
                        <label for="loginEmail" class="form-label">E-Mail</label>
                        <input type="text" id="loginEmail" name="loginEmail" class="form-control loginUsernameInput" placeholder="" required>
                        <div class="invalid-feedback">
                            <p>Bitte geben Sie eine gültige E-Mail-Adresse ein.</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="loginPassword" class="form-label">Passwort</label>
                        <input type="password" id="loginPassword" name="loginPassword" class="form-control loginPasswordInput" required>
                        <div class="invalid-feedback">
                            Bitte geben Sie ein gültiges Passwort ein.
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary loginBtn">Anmelden</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="#">Impressum</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>