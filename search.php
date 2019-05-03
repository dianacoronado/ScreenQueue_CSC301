<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

$searchTerm = get('q');

$movies = searchMovies($searchTerm,$API_KEY);

?>

<?php include('includes/navbar.php') ?>
<div class="container">

<?php foreach($movies as $movie): ?>
<hr>
<div class="row">
    <div class="col-2">
        <a href="movie.php?id=<?php echo $movie['id']?>"><img src="<?php echo $baseURL . $movie['poster_path']?>" class="img-fluid rounded" alt="<?php echo $movie['title']?> Poster"></a>
    </div>
    <div class="col-10">
        <a href="movie.php?id=<?php echo $movie['id']?>"><h1 class="display-4"><?php echo $movie['title'] ?></h1><small id="release_date"><?php echo $movie['release_date']?></small></a>
        <p><?php echo $movie['overview'] ?></p>
    </div>
</div>
<?php endforeach; ?>
</div>

<?php include('includes/footer.php') ?>