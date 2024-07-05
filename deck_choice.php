<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Task</title>
  <style>
    /* Styles généraux */
    body {
      font-family: Arial, sans-serif;
      background-color: #343a40;
      margin: 0;
      padding: 0;
    }
    .container {
      width: 50%;
      margin: 50px auto;
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 24px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"], input[type="file"], textarea, select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    textarea {
      resize: vertical;
    }
    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }
    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Add to Collection</h1>
    <form action="choice_treatment.php" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="assigned_to">Assigned To:</label>
        <select id="nom" name="nom">
          <?php
          // Connexion à la base de données avec PDO
          $pdo = new PDO("mysql:host=localhost;dbname=projet_tech_musee", "root", "");
          $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          // Récupérer l'ID du produit à partir de l'URL
          $productId = isset($_GET['product_id']) ? $_GET['product_id'] : null;

          if ($productId) {
            echo "<input type='hidden' name='product_id' value='$productId'>";
          }

          // Récupérer la liste des utilisateurs depuis la base de données
          $stmt = $pdo->query("SELECT * FROM deck");
          $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

          // Afficher les options de la liste déroulante pour les utilisateurs
          foreach ($users as $user) {
            echo "<option value='" . $user['nom'] . "'>" . $user['nom'] . "</option>";
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label for="image">Task Image:</label>
        <input type="file" id="image" name="image">
      </div>
      <button type="submit">Create Task</button>
    </form>
  </div>
</body>
</html>
