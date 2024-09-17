<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Mapas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <main class="container">
        <h1>Formulários e Arrays</h1>
        <form action="" method="POST">
            <?php for($i = 1; $i <= 10 ; $i++): ?>
                <div class="row mb-1">
                    <div class="col-4">
                        <input class="form-control" type="text" name="nomes[]" id="" placeholder="Valor <?=$i?>">
                    <!--colchetes [] sinaliza que ao ler os dados devem ser agrupados em um array-->
                    </div>
                </div>           
            <?php endfor; ?>
            <div class="row mt-2">
                <div class="col">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </div>
        </form>
        
        <!--Resposta do exercicio -->
        <?php
            if ($_SERVER['REQUEST_METHOD']== "POST"){
                try{
                $valores = $_POST['nomes'];

                foreach($valores as $chave => $valor)
                    echo "<p>$chave: $valor </p>";
                } catch (Exception $e){
                    echo $e->getMessage();
                }
            }
        ?>
    </main>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>