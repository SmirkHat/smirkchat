<!DOCTYPE html>
<html lang="cs" data-bs-core="smirkhat">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmirkChat</title>
    <link rel="stylesheet" href="../assets/css/halfmoon.min.css">
    <link rel="stylesheet" href="../assets/css/halfmoon.elegant.css?<?php echo filemtime('/var/www/smirkhat/assets/css/halfmoon.elegant.css') ?>">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/markdown-it/dist/markdown-it.min.js"></script> <!-- Include markdown-it.js -->
    <style>
        .response-content {
            white-space: pre-wrap;
        }
    </style>
</head>

<body>
    <main class="container d-flex flex-column my-5 gap-3">
        <h1 class="text-center display-2">SmirkChat</h1><br><br>
        <div class="alert alert-danger border-0 rounded-0 d-flex align-items-center" role="alert">
            <i class="fa-light fa-exclamation-circle text-danger-emphasis me-2"></i>
            <div><strong>Upozornění!</strong> Tato umělá inteligence je stále pouze experimentální a bude obsahovat chyby. Nevhodné výrazy a chování nahlašujte na chat@smirkhat.org.</div>
        </div>
        <textarea class="form-control" id="prompt" rows="4" cols="50" placeholder="Zeptejte se na cokoliv..."></textarea>
        <button type="button" class="btn btn-secondary btn-sm" onclick="sendPrompt()">Odeslat</button>

        <div id="response" class="response-content" style="margin-top: 20px;"></div>
        <button id="generateMore" class="btn btn-primary btn-sm" style="display: none;" onclick="generateMore()">Vygenerovat dál</button>


    </main>
</body>

</html>
