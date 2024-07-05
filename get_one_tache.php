<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi de tache</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container-fluid {
            margin-top: 20px;
        }
        .btn-group {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #343a40;
            color: white;
        }
        .card-title {
            margin-bottom: 0;
        }
        .alert {
            margin-bottom: 20px;
        }
        th, td {
            text-align: center;
        }
        .btn-group .btn {
            margin-right: 10px;
        }
        @media (max-width: 768px) {
            .btn-group .btn {
                margin-bottom: 10px;
                display: block;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-start">
            <div class="col-md-6">
                <div class="btn-group" role="group" aria-label="Actions">
                    <a href="update_form.php" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                    <a href="delete_form.php" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                        <i class="fas fa-trash-alt"></i> Supprimer
                    </a>
                    <a href="dashboard.php" class="btn btn-secondary ml-2" onclick="window.history.back();">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Suivi de tache</h3>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success" role="alert">
                            <?php
                            // Afficher le message récupéré depuis le formulaire
                            if (isset($msg)) {
                                echo $msg;
                            }
                            ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Titre</th>
                                        <th scope="col">ID tache</th>
                                        <th scope="col">Statut</th>
                                        <th scope="col">Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once 'Session.php';
                                    use App\Session;

                                    $session = new Session();
                                    date_default_timezone_set('Europe/Paris');
                                    // Vérifier si l'utilisateur est connecté
                                    $isconnected = $session->isConnected();
                                    $token_name = "user_token";
                                    // Vérifier si le jeton est toujours valide
                                    if ($isconnected && isset($_COOKIE['user_token'])) {
                                        $user_token = $_COOKIE['user_token'];

                                        try {
                                            // Connexion à la base de données avec PDO
                                            $pdo = new PDO("mysql:host=localhost;dbname=tpo", "root", "");
                                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                            // Récupérer l'ID de l'utilisateur actuel
                                            $userId = $session->getCurrentUserID();

                                            // Requêter la base de données pour récupérer les tâches assignées à l'utilisateur actuel
                                            $stmt = $pdo->prepare("SELECT * FROM tasks WHERE assigned_to = :userId");
                                            $stmt->bindParam(':userId', $userId);
                                            $stmt->execute();
                                            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                            // Afficher les tâches récupérées depuis la base de données
                                            foreach ($tasks as $task) {
                                                echo "<tr>";
                                                echo "<td>" . $task['title'] . "</td>";
                                                echo "<td>" . $task['id'] . "</td>";
                                                echo "<td>" . $task['status'] . "</td>";
                                                echo "<td>" . $task['description'] . "</td>";
                                                echo "<td>";
                                                echo "<div class='btn-group' role='group' aria-label='Actions'>";
                                                // Ajoutez ici les boutons d'action (Modifier, Supprimer, etc.)
                                                echo "</div>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } catch (PDOException $e) {
                                            echo "Erreur : " . $e->getMessage();
                                        }
                                    } else {
                                        header("location: index.php");
                                        exit;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteIntervention(id) {
            if (confirm("Êtes-vous sûr de vouloir supprimer cette intervention ?")) {
                // Mettre en œuvre la logique de suppression ici
                console.log("Suppression de l'intervention avec l'ID:", id);
            }
        }
    </script>
</body>
</html>
