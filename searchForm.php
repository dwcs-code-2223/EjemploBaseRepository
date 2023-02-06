<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Búsqueda</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    </head>
    <body class="container-fluid">
        <h1>Búsqueda de autores y libros </h1><!-- comment -->
        <p> Introduzca las palabras clave </p>
        <form class='form-control'>
            <div class="input-group">
                <input name="search" type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                <button type="submit" class="btn btn-outline-primary">search</button>
            </div>
        </form>
    </body>
    <?php
    if (isset($_GET["search"])):
        require_once 'BookRepository.php';
        require_once 'MyPDO.php';
        $book_repo = new BookRepository();
        $cadena = $_GET["search"];
        $resultado = $book_repo->buscarPorAutorOTituloPalabras($cadena);
        if (count($resultado) > 0):
            ?>
            <p>Resultados de la búsqueda </p>
            <ul>
                <?php foreach ($resultado as $key => $value) : ?>
                    <li> <?= $resultado[$key]["title"] ?> <?= $resultado[$key]["name"] ?></li>


                <?php endforeach; ?>

            </ul>

            <?php else:
            ?>
            <div class='alert alert-info'>No se han encontrado resultados</div><?php
        endif;
    endif;
    ?>

</html>
