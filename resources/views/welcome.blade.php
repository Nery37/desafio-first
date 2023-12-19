<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap Validator -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(75, 14, 154, 1) 35%, rgba(0, 212, 255, 1) 100%);
            font-family: 'Poppins', sans-serif;
        }

        form {
            border-radius: 20px;
            margin-top: 150px !important;
            width: 50% !important;
            background-color: white !important;
            padding: 50px;
        }

        .btn-primary {
            width: 100%;
            border: none;
            border-radius: 50px;
            background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(75, 14, 154, 1) 35%, rgba(0, 212, 255, 1) 100%);
        }

        .form-control {
            color: rgba(0, 0, 0, .87);
            border-bottom-color: rgba(0, 0, 0, .42);
            box-shadow: none !important;
            border: none;
            border-bottom: 1px solid;
            border-radius: 4px 4px 0 0;
        }

        .error{
            color: red;
            font-weight: bold;
        }

        h4 {
            font-size: 2rem !important;
            font-weight: 700;
        }

        .form-label {
            font-weight: 800 !important;
        }

        @media only screen and (max-width: 600px) {
            form {
                width: 100% !important;
            }
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#registrationForm").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 50
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6,
                        maxlength: 20
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: {
                        required: "Por favor, informe o nome",
                        minlength: "O nome deve ter no mínimo 3 caracteres",
                        maxlength: "O nome não pode ter mais de 50 caracteres"
                    },
                    email: {
                        required: "Por favor, informe o e-mail",
                        email: "Por favor, informe um e-mail válido"
                    },
                    password: {
                        required: "Por favor, informe a senha",
                        minlength: "A senha deve ter no mínimo 6 caracteres",
                        maxlength: "A senha não pode ter mais de 20 caracteres"
                    },
                    password_confirmation: {
                        required: "Por favor, confirme a senha",
                        equalTo: "As senhas devem coincidir"
                    }
                },
                submitHandler: function(form) {
                    registerUser();
                }
            });

            $("#registrationForm input, #registrationForm textarea").on("keyup change", function() {
                if ($("#registrationForm").valid()) {
                    $("#registerBtn").prop("disabled", false);
                } else {
                    $("#registerBtn").prop("disabled", true);
                }
            });

            $("#registerBtn").on("click", function(e) {
                e.preventDefault();
                if ($("#registrationForm").valid()) {
                    registerUser();
                }
            });
        });

        function registerUser() {
            $.ajax({
                type: 'POST',
                url: '{{ route("register") }}',
                data: {
                    name: $('input[name=name]').val(),
                    email: $('input[name=email]').val(),
                    password: $('input[name=password]').val(),
                    password_confirmation: $('input[name=password_confirmation]').val(),
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registro bem-sucedido!',
                        text: 'Você foi registrado com sucesso.',
                    });
                    $('input[name=name]').val('');
                    $('input[name=email]').val('');
                    $('input[name=password]').val('');
                    $('input[name=password_confirmation]').val('');
                    $('#registerBtn').prop('disabled', true);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro no registro',
                        text: 'Houve um erro ao processar o registro. Por favor, corrija os erros abaixo:',
                        html: formatErrors(xhr.responseJSON.errors)
                    });
                }
            });
        }

        function formatErrors(errors) {
            let errorList = '<ul>';
            $.each(errors, function(field, fieldErrors) {
                $.each(fieldErrors, function(index, error) {
                    errorList += '<li>' + error + '</li>';
                });
            });
            errorList += '</ul>';
            return errorList;
        }
    </script>

    <title>Register Form</title>
</head>

<body>
    <div class="container-fluid">
        <form class="mx-auto" id="registrationForm">
            <h4 class="text-center">Registrar</h4>
            <div class="mb-3 mt-5">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Password Confirmation</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
            </div>
            <button type="submit" class="btn btn-primary mt-5" id="registerBtn" disabled>Registrar</button>
        </form>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>
