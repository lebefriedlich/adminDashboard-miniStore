<style>
    body {
        background: linear-gradient(135deg, #3498db, #8e44ad);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        margin: 0;
    }

    .card {
        width: 350px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .card-header {
        background-color: #34495e;
        color: #ecf0f1;
        border-radius: 10px 10px 0 0;
    }

    .btn-primary {
        background-color: #3498db;
        border: none;
        width: 100%;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }
</style>
</head>

<body>

    <div class="card">
        <div class="card-header text-center">
            <h3 class="mb-0">Login</h3>
        </div>
        <?php Flasher::flash(); ?>
        <div class="card-body">
            <form action="<?php BASEURL; ?>login/login" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>