<?php
// Hitlovers Wishlist - Sangønske formular med ntfy.sh
header('Content-Type: text/html; charset=utf-8');

// Konfiguration - ntfy topic
$ntfyTopic = 'hitlovers.dk-wishlist';
$ntfyUrl = 'https://ntfy.sh/' . $ntfyTopic;

// Fejlmeddelelser og succes
$errors = [];
$success = false;

// Tjek om formularen er indsendt
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize inputs
    $artist = isset($_POST['artist']) ? trim(htmlspecialchars($_POST['artist'], ENT_QUOTES, 'UTF-8')) : '';
    $song = isset($_POST['song']) ? trim(htmlspecialchars($_POST['song'], ENT_QUOTES, 'UTF-8')) : '';
    $name = isset($_POST['name']) ? trim(htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8')) : '';
    $message = isset($_POST['message']) ? trim(htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8')) : '';
    
    // Validering
    if (empty($artist)) {
        $errors[] = 'Kunstnernavn er påkrævet';
    }
    
    if (empty($song)) {
        $errors[] = 'Sangtitel er påkrævet';
    }
    
    if (empty($name)) {
        $errors[] = 'Dit navn er påkrævet';
    }
    
    // Hvis ingen fejl, send ntfy-besked
    if (empty($errors)) {
        // Byg besked
        $ntfyMessage = "🎵 Ny sanganmodning fra hitlovers.dk/wishlist \n\n" .
                       "🎤 Kunstner: $artist\n" .
                       "🎶 Sang: $song\n" .
                       "👤 Fra: $name\n" .
                       "💬 Besked: " . ($message ?: 'Ingen besked') . "\n\n" .
                       "⏰ Tid: " . date('d/m/Y H:i:s');

        // Send til ntfy.sh
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ntfyUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ntfyMessage);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: text/plain',
            'Title: 🎵 Ny sanganmodning - Hitlovers',
            'Priority: high',
            'Tags: music,song,request'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response !== false) {
            $success = true;
        } else {
            $errors[] = 'Der opstod en fejl under afsendelsen. Prøv venligst igen senere.';
        }
    }
}

// Vis resultat
if ($success) {
    // Redirect til tak-side med modal trigger
    header('Location: index.html?success=1&showModal=1');
    exit;
} elseif (!empty($errors)) {
    // Vis fejl
    echo "
    <!DOCTYPE html>
    <html lang='da'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Fejl - Hitlovers Wishlist</title>
        <link rel='stylesheet' href='styles.css'>
        <link href='https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700;900&family=Pacifico&display=swap' rel='stylesheet'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    </head>
    <body>
        <div class='container'>
            <header class='header'>
                <h1 class='logo'>Hitlovers <span><i class='fas fa-heart'></i> Wishlist</span></h1>
            </header>
            
            <main style='text-align: center; padding: 60px 0;'>
                <div style='background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border-radius: 12px; padding: 40px; max-width: 600px; margin: 0 auto; border: 1px solid rgba(255, 255, 255, 0.1);'>
                    <div style='font-size: 4rem; margin-bottom: 20px; color: #e94560;'>
                        <i class='fas fa-exclamation-triangle'></i>
                    </div>
                    <h2 style='color: white; margin-bottom: 20px;'>Der opstod en fejl</h2>
                    <p style='color: #bdc3c7; margin-bottom: 20px;'>Venligst rett følgende fejl:</p>
                    <ul style='text-align: left; display: inline-block; color: #e94560; list-style: none;'>";
                    foreach ($errors as $error) {
                        echo "<li style='padding: 8px 0; border-bottom: 1px solid rgba(233, 69, 96, 0.2);'><i class='fas fa-times-circle' style='margin-right: 8px;'></i> {$error}</li>";
                    }
                    echo "
                    </ul>
                    <p style='margin-top: 30px; color: #7f8c8d;'>
                        <a href='javascript:history.back()' class='btn btn-primary' style='display: inline-block;'>
                            <i class='fas fa-arrow-left'></i> Tilbage og prøv igen
                        </a>
                    </p>
                </div>
            </main>
        </div>
    </body>
    </html>
    ";
} else {
    // Redirect tilbage hvis ingen POST
    header('Location: index.html');
    exit;
}
?>
