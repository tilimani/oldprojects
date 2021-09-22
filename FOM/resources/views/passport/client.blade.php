<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('css/app.css?version=1') }}" rel="stylesheet">
    <title>Clientes</title>
</head>
<body>
    <div class="container mx-auto p-5">
        <form class="needs-validation" action="{{ url('/oauth/clients') }}" method="post" novalidate>
            @csrf
            <div class="form-group mb-2">
                <label for="name">Token name</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="Name-addon">Aa-Zz</span>
                    </div>
                    <input class="form-control" placeholder="Name" type="text" aria-label="Name" name="name" id="name" aria-describedby="Name-addon" required>
                </div>
                <small id="nameHelpBlock" class="form-text text-muted">
                    Name of the token, you will nedd to save it in order to implement on your own application.
                </small>
            </div>
            <div class="form-group mb-2">
                <label for="redirect">Token URL Redirect</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="Redirect-addon">http://yourCallback.go</span>
                    </div>
                    <input class="form-control" placeholder="Redirect" type="url" aria-label="Redirect" name="redirect" id="redirect" aria-describedby="Redirect-addon" required>
                </div>
                <small id="redirectHelpBlock" class="form-text text-muted">
                    Redirect of the token, you will nedd to save it in order to implement in your own application.
                </small>
            </div>
            <button type="submit" class="btn btn-primary btn-lg mb-5">Send</button>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>NOMBRE</td>
                    <td>REDIRECT</td>
                    <td>SECRET</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{$client->id}}</td>
                        <td>{{$client->name}}</td>
                        <td>{{$client->redirect}}</td>
                        <td>{{$client->secret}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

    <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
                }, false);
            });
            }, false);
            })();
    </script>
</body>
</html>
