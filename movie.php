
<?php
include('config.php');
// Include functions for application
include('functions.php');

//Get movie ID and details
$movieID = get('id');

//Get movie properties
$movie = getMovie($movieID,$API_KEY);
$video = getVideo($movieID,$API_KEY);
$credits = getMovieCredits($movieID,$API_KEY);
$title = $movie['title'];
if(isset($credits))
{
    $cast = $credits['cast'];
    $crew = $credits['crew'];
}

if(isset($user))
{
    $alreadyInList = array();
    $review = $user->getReviewForMovie($movieID);
    $userWatchlists = $user->getWatchlistsForMovie($movieID);

    //Create new array if the movie is already in any of the lists
    foreach($userWatchlists as $item)
    {
        array_push($alreadyInList,$item['id']);
    }

}


// If form submitted:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get info from from the form as variables
    $action = $_POST['actionForm'];

    if($action == 'review')
    {
        $value = $_POST['rating'];
        //Create new user and save to database
        if(!empty($review))
        {
            $sql = file_get_contents('sql/updateReview.sql');
            $params = array(
                'id' => $review[0]['id'],
                'userid' => $user->get('id'),
                'movieid' => $movieID,
                'value' => $value);
        }
        else
        {
            $sql = file_get_contents('sql/insertReview.sql');
            $params = array(
                'movieid' => $movieID,
                'userid' => $user->get('id'),
                'value' => $value);           
        }
        $statement = $database->prepare($sql);
        $statement->execute($params);

    }

    if($action == 'watchlist')
    {
        $list = $_POST['watchlists'];

        foreach($list as $item)
        {
            $sql = file_get_contents('sql/deleteFromWatchlist.sql');
            $params = array(
                'watchlistID' => $item,
                'movieID' => $movieID
            );

            $statement = $database->prepare($sql);
            $statement->execute($params);

            $sql = file_get_contents('sql/addToWatchlist.sql');
            $params = array(
                'movieid' => $movieID,
                'watchlistid' => $item);

            $statement = $database->prepare($sql);
            $statement->execute($params);
        }
    }

}


?>

<?php include('includes/navbar.php') ?>
<div class="container">

    <style>
        .jumbotron {
            background-image: url(<?php echo $baseURL . $movie['backdrop_path'] ?>);
            background-size: cover;
            padding-top: 20%;
            padding-bottom: 20%;
        }

    </style>

    <div class="row">
        <hr>
    </div>
    <?php if(isset($movie['backdrop_path'])): ?>
    <div class="jumbotron"></div>
    <?php  endif; ?>
    <hr>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-10">
                <img src="<?php echo $baseURL . $movie['poster_path'] ?>" class="img-fluid rounded" alt="<?php echo $baseURL . $movie['title'] ?> Poster">
                <hr>
                <?php if(isset($user)):?>
                <div class="row">
                    <div class="col">
                        <input type="submit" class="btn btn-default" id ="modalButton" data-toggle="modal" data-target="#watchlistModal" value="Add Watchlist" />
                    </div>
                    <div class="col">
                        <?php if(!empty($review)):?>
                        <input type="submit" class="btn btn-default" id ="modalButton" data-toggle="modal" data-target="#reviewsModal" value="Edit Review" />
                        <?php else: ?>
                        <input type="submit" class="btn btn-default" id ="modalButton" data-toggle="modal" data-target="#reviewsModal" value="Review" />
                        <?php endif; ?>
                    </div>                    
                </div>
                <hr>
                <?php endif; ?>
                <div class="row">
                    <?php if(isset($video)): ?>
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $video[0]['key'] ?>"
                            allowfullscreen></iframe>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="col-md-12">

                <div class="row">
                    <div class="col-md-12">
                        <h1 class="display-2 float-right"><?php echo $movie['title'] ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead float-right"><?php echo $movie['tagline'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="lead"><?php echo $movie['overview'] ?></p>
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-md-7">
                            <p class="lead">Release Date: </p>
                        </div>
                        <div class="col-md-4">
                            <p class="lead" id="release_date"><?php echo $movie['release_date'] ?></p>
                        </div>
                    </div>
                </div>


                <div class="row">

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <br>
                    </div>
                </div>
                <div class="row">
                    <?php if(isset($crew)) : ?>
                    <div class="col-md-6">
                        <table>
                            <thead class="crewHeader">
                                <tr>
                                    <th colspan="2" id="crewTitle" class="display-4">Crew</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($crew as $crewMember): ?>
                                <?php if(isset($crewMember['job']) && isset($crewMember['name'])): ?>
                                <tr>
                                    <td class="lead"><?php echo $crewMember['job'] ?></td>
                                    <td class="lead"><a href="person.php?id=<?php echo $crewMember['id'] ?>"><?php echo $crewMember['name'] ?></a></td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($cast)) : ?>
                    <div class="col-md-6">
                        <table>
                            <thead class="castHeader">
                                <tr>
                                    <th colspan="2" id="castTitle" class="display-4">Cast</th>
                                </tr>
                            </thead>
                            <?php foreach($cast as $castMember): ?>
                            <?php if(isset($castMember['character']) && isset($castMember['name'])): ?>
                            <tbody>
                                <tr>
                                    <td class="lead"><?php echo $castMember['character'] ?></td>
                                    <td class="lead"><a href="person.php?id=<?php echo $castMember['id'] ?>"><?php echo $castMember['name'] ?></a></td>
                                </tr>
                            </tbody>
                            <?php endif; ?>
                            <?php endforeach; ?>

                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal -->
<div class="modal fade" id="watchlistModal" tabindex="-1" role="dialog" aria-labelledby="watchlistModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="watchlistModalLabel">Add <?php echo $movie['title']?> to watchlist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="watchlistForm" name="actionForm" value="watchlist">
                    <div class="form-group">
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <?php foreach($watchlists as $list):?>
                                <?php if(in_array($list['id'], $alreadyInList)): ?>
                                <input class="form-check-input" type="checkbox" name="watchlists[]" value="<?php echo $list['id'] ?>" checked/>
                                <?php else: ?>
                                <input class="form-check-input" type="checkbox" name="watchlists[]" value="<?php echo $list['id'] ?>" />
                                <?php endif; ?>
                                <label class="form-check-label" for="watchlistCheck"><?php echo $list['name']?></label>
                                <br/>

                                <?php endforeach; ?>
                            </div>
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

<div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="reviewsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reviewsModalLabel">Review <?php echo $movie['title']?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="watchlistForm" name="actionForm" value="review">
                    <div class="form-group row">
                        <label for="review-number-input" class="col-2 col-form-label">Rating</label>
                        <div class="col-10">
                            <?php if(empty($review)): ?>
                            <input class="form-control" name="rating" type="number" placeholder="Enter Rating (1-10)" id="review-number-input" min="1" max="10">
                            <?php else: ?>
                            <input class="form-control" name="rating" type="number" value="<?php echo $review[0]['value'] ?>" id="review-number-input" min="1" max="10">                            
                            <?php endif;?>
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


<script>

    $(document).ready(function () {
        toggleCrewHeader();
        toggleCastHeader();
    });

    $(document).on('click', '.crewHeader', function () {
        toggleCrewHeader();
    });

    $(document).on('click', '.castHeader', function () {
        toggleCastHeader();
    });


    function toggleCastHeader()
    {
        if($('#castTitle').text()=="Cast")
        {
            $('#castTitle').text("Show Cast");
        }
        else
        {
            $('#castTitle').text("Cast");
        }
        $('.castHeader').closest('table').find('tbody').toggle();
    }

    function toggleCrewHeader()
    {
        if($('#crewTitle').text()=="Crew")
        {
            $('#crewTitle').text("Show Crew");
        }
        else
        {
            $('#crewTitle').text("Crew");
        }
        $('.crewHeader').closest('table').find('tbody').toggle();
    }


</script>
<?php include('includes/footer.php') ?>
