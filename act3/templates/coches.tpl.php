<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actividad 3 - Coches con imagen</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    body {
      margin: 0;
      padding: 2rem;
      background-color: #2c2c2c;
      color: white;
      font-family: "Poppins", sans-serif;
    }

    h1 {
      text-align: center;
      margin: 0;
      margin-bottom: 2rem;
    }

    main {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .coche {
      background-color: #373737;
      border-radius: 1rem;
      padding: 1rem;
      flex-grow: 1;
      img {
        border-radius: 1rem;
        height: 230px;
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
      }
      h2 {
        margin: 0;
      }
      ul {
        padding: 0 0 0 1rem;
        margin: 0;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Coches muy reales</h1>
  </header>
  <main>
    <?php echo $output??"" ?>
  </main>
</body>
</html>