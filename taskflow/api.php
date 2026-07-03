<?php
// api.php — Backend PHP qui communique avec MySQL
// Gère les 4 opérations : lire, ajouter, modifier, supprimer

// Ces headers permettent à React (sur le même serveur) d'appeler ce fichier
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Répondre aux requêtes OPTIONS (pré-vérification CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// --- CONNEXION À MYSQL ---
// Sur XAMPP, l'utilisateur est "root" et le mot de passe est vide par défaut
$conn = new mysqli('localhost', 'root', '', 'taskflow_db');

// Si la connexion échoue, on retourne une erreur
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Connexion MySQL échouée']);
    exit;
}

// On récupère la méthode HTTP (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// L'id peut être passé dans l'URL : api.php?id=3
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

// --- SELON LA MÉTHODE HTTP ---

// GET → récupérer toutes les tâches
if ($method === 'GET') {
    $result = $conn->query('SELECT * FROM tasks ORDER BY created_at DESC');
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($tasks);
}

// POST → ajouter une nouvelle tâche
else if ($method === 'POST') {
    // On lit le JSON envoyé par React dans le body de la requête
    $data = json_decode(file_get_contents('php://input'), true);

    $title    = $data['title'] ?? '';
    $priority = $data['priority'] ?? 'medium';

    if (empty($title)) {
        http_response_code(400);
        echo json_encode(['error' => 'Le titre est requis']);
        exit;
    }

    // Requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare('INSERT INTO tasks (title, priority) VALUES (?, ?)');
    $stmt->bind_param('ss', $title, $priority);
    $stmt->execute();

    // On retourne la tâche créée pour que React puisse l'afficher
    echo json_encode([
        'id'        => $conn->insert_id,
        'title'     => $title,
        'priority'  => $priority,
        'completed' => 0
    ]);
}

// PUT → modifier une tâche (cocher/décocher)
else if ($method === 'PUT' && $id) {
    $data      = json_decode(file_get_contents('php://input'), true);
    $completed = (int)$data['completed'];

    $stmt = $conn->prepare('UPDATE tasks SET completed = ? WHERE id = ?');
    $stmt->bind_param('ii', $completed, $id);
    $stmt->execute();

    echo json_encode(['success' => true]);
}

// DELETE → supprimer une tâche
else if ($method === 'DELETE' && $id) {
    $stmt = $conn->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();

    echo json_encode(['success' => true]);
}

$conn->close();
?>
