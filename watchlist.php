<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

$watchlistID = get('id');

if(isset($user))
{
    $list = $user->getWatchlist($watchlistID);
    $movieList = $user->getWatchlistItems($watchlistID);
    $title = $list[0]['name'];
}
else
{
    header('location: index.php');
}

?>

<?php include('includes/navbar.php') ?>
<div class="container">
    <hr>
    <div class="row">
        <div class="col">
            <h1 class="display-3"><?php echo $list[0]['name'] ?></h1>
        </div>
    </div>
    <?php if(!empty($movieList)): ?>
    <?php foreach($movieList as $item): ?>
    <?php $movie = getMovie($item['movieid'],$API_KEY);?>
    <hr id="<?php echo $movie['id']?>HR">
    <div class="row" id="<?php echo $movie['id']?>">
        <div class="col-2">
            <a href="movie.php?id=<?php echo $movie['id']?>"><img src="<?php echo $baseURL . $movie['poster_path']?>" class="img-fluid rounded" alt="<?php echo $movie['title']?> Poster"></a>
        </div>
        <div class="col-10">
            <span class="close" onclick="deleteMovie(<?php echo $movie['id'] ?>)">&times;</span>
            <a href="movie.php?id=<?php echo $movie['id']?>"><h1 class="display-4"><?php echo $movie['title'] ?></h1><small id="release_date"><?php echo $movie['release_date']?></small></a>
            <p><?php echo $movie['overview'] ?></p>
        </div>
    </div>
    <?php endforeach; ?>
    <?php else: ?>
        <p class="lead">Search for movies and start adding!</p>
    <?php endif; ?>
</div>

<?php include('includes/footer.php') ?>

<script>

    function deleteMovie(movieID)
    {
        var url = 'deleteFromWatchlist.php?listID=<?php echo $watchlistID ?>' + '&movieID='+movieID;
        console.log(url);
        $.ajax({
            url : url,
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',            
            success : function(data) {              
                console.log('Data: '+data);
                $('#'+movieID).hide();
                $('#'+movieID+'HR').hide();
                console.log("Deleted: "+ movieID);
            },
            error : function(request,error)
            {
                    console.log("Request: "+request);
            }
            });
            
        }

</script>