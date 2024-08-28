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
        <textarea class="form-control" id="prompt" rows="4" cols="50" placeholder="Zeptejte se na cokoliv...">What is your name?</textarea>
        <button type="button" class="btn btn-secondary btn-sm" onclick="sendPrompt()">Odeslat</button>

        <div id="response" class="response-content" style="margin-top: 20px;"></div>
        <button id="generateMore" class="btn btn-primary btn-sm" style="display: none;" onclick="generateMore()">Generate More</button>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize markdown-it
                const md = window.markdownit();

                // Store the conversation state
                let conversationContext = '';
                let lastResponseLength = 0;

                function sendPrompt() {
                    var prompt = document.getElementById('prompt').value;
                    var responseElement = document.getElementById('response');
                    var generateMoreButton = document.getElementById('generateMore');
                    var xhr = new XMLHttpRequest();

                    // Show loading indicator
                    responseElement.innerHTML = "<div class='spinner-border' role='status'><span class='visually-hidden'>Načítání...</span></div>";
                    generateMoreButton.style.display = "none";

                    xhr.open('POST', 'api.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    console.log(response); // For debugging

                                    if (response.choices && response.choices.length > 0) {
                                        var content = response.choices[0].message.content;
                                        console.log('Markdown content:', content); // Debug Markdown content

                                        var htmlContent = md.render(content); // Convert Markdown to HTML

                                        responseElement.innerHTML = htmlContent;

                                        // Store response content for continuation
                                        conversationContext = content;

                                        // Set the threshold to show the Generate More button
                                        const responseThreshold = 1000; // Adjust as needed
                                        if (content.length > responseThreshold) {
                                            lastResponseLength = content.length;
                                            generateMoreButton.style.display = "block";
                                        }
                                    } else {
                                        responseElement.innerText = "Nastala chyba.";
                                    }
                                } catch (e) {
                                    responseElement.innerText = "Chyba: " + e.message;
                                }
                            } else {
                                responseElement.innerText = "Chyba: " + xhr.status;
                            }
                        }
                    };
                    xhr.send('prompt=' + encodeURIComponent(prompt));
                }

                function generateMore() {
                    var responseElement = document.getElementById('response');
                    var generateMoreButton = document.getElementById('generateMore');
                    var xhr = new XMLHttpRequest();

                    // Show loading indicator
                    responseElement.innerHTML = "<div class='spinner-border' role='status'><span class='visually-hidden'>Načítání...</span></div>";
                    generateMoreButton.style.display = "none";

                    // Send follow-up request to get more content
                    xhr.open('POST', 'api.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                try {
                                    var response = JSON.parse(xhr.responseText);
                                    console.log(response); // For debugging

                                    if (response.choices && response.choices.length > 0) {
                                        var content = response.choices[0].message.content;
                                        console.log('Additional Markdown content:', content); // Debug additional Markdown content

                                        var htmlContent = md.render(content); // Convert Markdown to HTML

                                        // Append new content to the existing content
                                        responseElement.innerHTML += htmlContent;

                                        // Update the conversation context
                                        conversationContext += content;

                                        // Update the button visibility based on new content length
                                        if (content.length > 1000) { // Adjust the threshold if needed
                                            generateMoreButton.style.display = "block";
                                        }
                                    } else {
                                        responseElement.innerText = "Nastala chyba.";
                                    }
                                } catch (e) {
                                    responseElement.innerText = "Chyba: " + e.message;
                                }
                            } else {
                                responseElement.innerText = "Chyba: " + xhr.status;
                            }
                        }
                    };
                    xhr.send('prompt=' + encodeURIComponent(conversationContext));
                }

                // Make the sendPrompt and generateMore functions globally accessible
                window.sendPrompt = sendPrompt;
                window.generateMore = generateMore;
            });
        </script>
    </main>
</body>

</html>
