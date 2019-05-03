<?php
include_once('config.php');
// Include functions for application
include_once('functions.php');

//Display full name on the browser tab
$title = $user->get('firstName').' '.$user->get('lastName');

// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get info from from the form as variables
    $watchlistName = $_POST['name'];

    //Create new user and save to database
    $sql = file_get_contents('sql/insertWathlist.sql');
    $params = array(
        'name' => $watchlistName,
        'userid' => $user->get('id')
    );

    $statement = $database->prepare($sql);
    $statement->execute($params);
}
?>

<?php include('includes/navbar.php') ?>
<div class="container">
    <hr>
    <div class="row">
        <div class="col">
            <h1 class="display-3">Hello <?php echo $user->get('firstName') ?>!</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <input type="submit" class="btn btn-primary" id ="modalButton" data-toggle="modal" data-target="#watchlistModal" value="Create a new Watchlist" />
        </div>
        <br/>
        <br/>
    </div>
    <div class="row">
        <div class="col">
            <?php if(!empty($watchlists)): ?>
            <hr>
            <p class="display-4">Watchlists</p>
            <?php foreach($watchlists as $list): ?>
            <?php
            $movieList = $user->getWatchlistItems($list['id']);
            $imgURL = "";
            if(!empty($movieList))
            {
                $movie = getMovie($movieList[0]['movieid'],$API_KEY);
                $imgURL =  $baseURL . $movie['poster_path'];
            }
            else
            {
                $imgURL ='images/film-solid.svg';
            }
            ?>
            <hr id="<?php echo $list['id']?>HR">
            <div class="row" id="<?php echo $list['id']?>">
                <div class="col-2">
                    <a href="watchlist.php?id=<?php echo $list['id']?>"><img src="<?php echo $imgURL?>" class="img-fluid rounded" alt="<?php echo $list['name']?> Poster"></a>
                </div>
                <div class="col-10">
                    <span class="close" onclick="deleteWatchList(<?php echo $list['id'] ?>)">&times;</span>
                    <a href="watchlist.php?id=<?php echo $list['id']?>"><h1 class="display-4"><?php echo $list['name'] ?></h1></a>
                </div>
            </div>            
            <?php endforeach;?>
            <?php endif;?>
        </div>
        <div class="col">
            <?php if(!empty($reviews)): ?>
            <hr>
            <p class="display-4">Reviews</p>
            <?php foreach($reviews as $review): ?>
            <?php 
            $movie = getMovie($review['movieid'],$API_KEY);
            ?>
            <hr id="review<?php echo $review['id']?>HR">
            <div class="row" id="review<?php echo $review['id']?>">
                <div class="col-2">
                    <a href="movie.php?id=<?php echo $movie['id']?>"><img src="<?php echo $baseURL . $movie['poster_path']?>" class="img-fluid rounded" alt="<?php echo $movie['title']?> Poster"></a>
                </div>
                <div class="col-10">
                    <span class="close" onclick="deleteReview(<?php echo $review['id'] ?>)">&times;</span>
                    <a href="movie.php?id=<?php echo $movie['id']?>"><h1 class="display-4"><?php echo  $review['value'] ?></h1></a>
                </div>
            </div>          
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="watchlistModal" tabindex="-1" role="dialog" aria-labelledby="watchlistModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add new watchlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <div class="form-group">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Watchist Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <input type="submit" class="btn btn-primary" value="Add" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php') ?>

<script>

    function deleteWatchList(watchlistID)
    {
        var url = 'deleteWatchList.php?listID='+watchlistID;
        console.log(url);
        $.ajax({
            url : url,
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',            
            success : function(data) {              
                $('#'+watchlistID).hide();
                $('#'+watchlistID+'HR').hide();
            },
            error : function(request,error)
            {
                console.log("Request: "+JSON.stringify(request));
            }
        });

    }
    
    function deleteReview(reviewID)
    {
        var url = 'deleteReview.php?reviewID='+reviewID;
        console.log(url);
        $.ajax({
            url : url,
            dataType: 'text',
            type: 'post',
            contentType: 'application/x-www-form-urlencoded',            
            success : function(data) {              
                $('#review'+reviewID).hide();
                $('#review'+reviewID+'HR').hide();
            },
            error : function(request,error)
            {
                console.log("Request: "+JSON.stringify(request));
            }
        });

    }

</script>