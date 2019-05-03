<?php

include('config.php');
// Include functions for application
include('functions.php');


//Get person ID and details
$personID = get('id');

//Get movie properties
$person = getPerson($personID,$API_KEY);
$credits = getPersonCredits($personID,$API_KEY);
$title = $person['name'];

if(isset($credits))
{
    $cast = $credits['cast'];
    $crew = $credits['crew'];
}

?>

<?php include('includes/navbar.php') ?>
<style>
</style>
<div class="container">
<div class="row">
    <hr>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
        <?php if(isset($person['profile_path'])) : ?>
        <div class="col-md-10">
            <img src="<?php echo $baseURL . $person['profile_path'] ?>" class="img-fluid rounded" alt="<?php echo $person['name'] ?> Poster">
        </div>
        <?php endif; ?>
    </div>
    <div class="col-md-8">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="display-2 float-right"><?php echo $person['name'] ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p class="lead float-right"><?php echo $person['known_for_department'] ?></p>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <p class="lead"><?php echo $person['biography'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <?php if(isset($person['birthday'])): ?>
                    <div class="col-md-4">
                        <p class="lead">Date of Birth: </p>
                    </div>
                    <div class="col-md-8">
                        <p class="lead" id="birthday"><?php echo $person['birthday'] ?></p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <?php if(isset($crew)): ?>
                <div class="col-md-6">
                    <table>
                        <thead class="crewHeader">
                        <tr>
                            <th colspan="2" class="display-4">Crew Credits</th>
                        </tr>
                        </thead>
                        <?php foreach($crew as $crewMember): ?>
                        <?php if(isset($crewMember['job']) && isset($crewMember['title'])): ?>
                        <tbody>
                        <tr>
                            <td class="lead"><a href="movie.php?id=<?php echo $crewMember['id'] ?>"><?php echo $crewMember['title'] ?></a></td>
                            <td class="lead"><?php echo $crewMember['job'] ?></td>
                        </tr>
                        </tbody>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
                <?php if(isset($cast)): ?>
                <div class="col-md-6">
                    <table>
                        <thead class="castHeader">
                        <tr>
                            <th colspan="2" class="display-4">Cast Credits</th>
                        </tr>
                        </thead>
                        <?php foreach($cast as $castMember): ?>
                        <?php if(isset($castMember['title']) && isset($castMember['character'])): ?>
                        <tbody>
                        <tr>
                            <td class="lead"><a href="movie.php?id=<?php echo $castMember['id'] ?>"><?php echo $castMember['title'] ?></a></td>
                            <td class="lead"><?php echo $castMember['character'] ?></td>
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
<script>
    $(document).ready(function () {
        var date = new Date($('#birthday').text());
        $('#birthday').text(date.toDateString());
        //$('.castHeader').closest('table').find('tbody').toggle();
        //$('.crewHeader').closest('table').find('tbody').toggle();
    });

    $(document).on('click', '.crewHeader', function () {
    $(this).closest('table').find('tbody').toggle();
});

$(document).on('click', '.castHeader', function () {
    $(this).closest('table').find('tbody').toggle();
});
</script>


<?php include('includes/footer.php') ?>