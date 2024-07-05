<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Deck</title>


  
  <style>
    /* Styles généraux */
    body {
      background-image: url("https://assets.codepen.io/780593/hobbit.jpg");
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }

    .container {
      width: 420px;
      background: transparent;
      border: 2px solid rgba(255, 255, 255, .2);
      backdrop-filter: blur(20px);
      color: white;
      border-radius: 10px;
      padding: 30px 40px;
    }

    .container h1 {
      font-size: 36px;
      text-align: center;
    }

    .container .form-group {
      width: 100%;
      margin: 30px 0;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      background: transparent;
      padding: 10px;
      border: 2px solid rgba(255, 255, 255, .2);
      border-radius: 50px;
      box-sizing: border-box;
      color: white;
    }

    .form-group input[type="file"] {
      padding: 0;
    }

    label {
      font-weight: bold;
      display: block;
      margin-bottom: 5px;
    }

    textarea {
      resize: vertical;
    }

    button {
      width: 100%;
      height: 45px;
      background: white;
      border: none;
      outline: none;
      border-radius: 40px;
      box-shadow: 0 0 10px rgba(0, 0, 0, .1);
      cursor: pointer;
      font-size: 16px;
      color: #333;
      font-weight: 600;
      margin-top: 50px;
    }

    button:hover {
      background-color: green;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Create Deck</h1>
    <form action="deck_treatment.php" method="post" enctype="multipart/form-data">
      <!-- Groupe de formulaire pour le titre -->
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" required>
      </div>
      <!-- Groupe de formulaire pour la description -->
      <div class="form-group">
        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required></textarea>
      </div>
      <!-- Groupe de formulaire pour l'image -->
      <div class="form-group">
      <label for="image">Sélectionner une image :</label><br>
      <input type="file" id="image" name="image" accept="image/jpeg, image/png, image/gif" required><br><br>
      </div>
      <!-- Bouton de soumission du formulaire -->
      <button type="submit">Create Deck</button>
    </form>
  </div>
</body>
</html>
