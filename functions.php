<?php

//Get movies using the TMDB API
function getUpcomingMovies($API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/movie/upcoming?api_key=' . $API_KEY . '&language=en-US&page=1&region=US');
    
    $response = json_decode($response,true);
    
    return $response['results'];
}

function getPopularMovies($API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/movie/popular?api_key='.$API_KEY.'&language=en-US&page=1&region=US');
    
    $response = json_decode($response,true);
    
    return $response['results'];
}

function get($key)
{
	if(isset($_GET[$key]))
	{
		return $_GET[$key];
	}
	else
	{
		return "";
	}
}

//Functions to get movie details
function getMovie($movieID,$API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/movie/'. $movieID .'?api_key='. $API_KEY .'&language=en-US');
    
    $response = json_decode($response,true);
    
    return $response;
}

function getVideo($movieID,$API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/movie/'.$movieID.'/videos?api_key='.$API_KEY.'&language=en-US');
    
    $response = json_decode($response,true);
    
    return $response['results'];
}
    


function getMovieCredits($movieID,$API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/movie/'.$movieID.'/credits?api_key='.$API_KEY);
    
    $response = json_decode($response,true);
    
    return $response;
}

//Functions for person page
function getPerson($personID,$API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/person/'.$personID.'?api_key='.$API_KEY.'&language=en-US');
    
    $response = json_decode($response,true);
    
    return $response;
}


function getPersonCredits($personID,$API_KEY)
{
    $response = file_get_contents('https://api.themoviedb.org/3/person/'.$personID.'/credits?api_key='.$API_KEY);
    
    $response = json_decode($response,true);
    
    return $response;
}


//Query function

function searchMovies($searchTerm, $API_KEY)
{
    $searchTerm = str_replace(' ', '%20', $searchTerm);
    
    $response = file_get_contents('https://api.themoviedb.org/3/search/movie?api_key='.$API_KEY.'&language=en-US&query='.$searchTerm.'&page=1&include_adult=false');
    
    $response = json_decode($response,true);
    
    return $response['results'];
}

?>