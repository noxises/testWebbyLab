<?php

class MovieList
{
    private $message;

    public static function index()
    {
        $movies = (new Movie())->all();
        $view = new View();
        $content = $view->generate_html('Movie/list.php', ['movies' => $movies]);
        echo $view->generate_html('wrapper.php', ['title' => 'Movies', 'content' => $content, 'js_sort' => true]);
    }

    public static function info()
    {
        $separetedLink = explode('/', $_SERVER['PATH_INFO']);
        $id = $separetedLink[2];
        $movieArray = (new Movie())->find('id', $id);
        $movie = $movieArray[0];
        $view = new View();
        $content = $view->generate_html('Movie/view.php', ['movie' => $movie]);
        echo $view->generate_html('wrapper.php', ['title' => $movie['title'], 'content' => $content]);

    }

    public static function addForm()
    {
        $view = new View();
        $content = $view->generate_html('Movie/create.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Add movie', 'content' => $content]);
    }

    public static function create($inputs)
    {
        $data = array();
        array_push($data, $inputs['title']);
        array_push($data, $inputs['year']);
        array_push($data, $inputs['format']);
        array_push($data, $inputs['actors']);
        $movie = new Movie();
        $movie->insert($data);
        $newArray = $movie->lastid();
        $lastInsertedMovie = $newArray[0];
        return response(array('status' => 'success', 'id' => $lastInsertedMovie['LAST_INSERT_ID()'], 'message' => 'Created'));
    }

    static public function saveFromFile($file)
    {
        $path = 'public/uploads/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $path);
        $content = file($path, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $i = 0;
        $data = array();
        $skippedMovies = 0;
        $insertedMovies = 0;
        foreach ($content as $value) {

            $separatedLine = explode(': ', $value);
            switch ($separatedLine[0]) {
                case 'Title':
                    array_push($data, null); //add null value for id
                    $title = $separatedLine[1];
                    array_push($data, $title);
                    break;
                case 'Release Year':
                    $year = $separatedLine[1];
                    array_push($data, $year);
                    break;
                case 'Format':
                    $format = $separatedLine[1];
                    array_push($data, $format);
                    break;
                case 'Stars':
                    $actors = $separatedLine['1'];
                    array_push($data, $actors);
                    break;
                default:
                    $i--; //remove line with random symbols
                    break;
            }
            $i++;
            if ($i % 4 == 0) {
                if (!$movie = (new Movie())->find('title', $data[1])) {
                    $insertedMovies++;
                    (new Movie())->insert($data);
                } else {
                    $skippedMovies++;
                }
                $data = array();
                $i = 0;//reload film data
            }
        }
        return response(array('status' => 'success', 'message' => 'Inserted count of movies: ' . $insertedMovies . '.</br> Skipped count of movies: ' . $skippedMovies . ' (Because title already exist)'));
    }

    public static function delete($id)
    {
        foreach ($id as $key => $value) {
            (new Movie())->delete('id', $value);
        }
        return response(array('status' => 'success', 'message' => 'Deleted: ' . count($id)));
    }

    public static function findByTitle($inputs)
    {
        $message = 'Nothing to show';

        $quer = new Movie();
        $movies = $quer->findlike($inputs['type'], $inputs['search']);
        if ($movies != null) {
            $message = 'Finded by ' . $inputs['type'] . ' Request : ' . $inputs['search'];
        }
        $view = new View();
        $content = $view->generate_html('Movie/list.php', ['movies' => $movies, 'message' => $message, 'js_sort' => true]);
        echo $view->generate_html('wrapper.php', ['title' => 'Search', 'content' => $content]);

    }


}