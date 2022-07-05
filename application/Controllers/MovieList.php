<?php

class MovieList
{
    private $message;

    public static function index()
    {
        $movies = (new Movie())->all();
        $view = new View();
        function filter(&$value)
        {
            $value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
        }

        array_walk_recursive($movies, "filter");
        $content = $view->generate_html('Movie/list.php', ['movies' => $movies]);
        echo $view->generate_html('wrapper.php', ['title' => 'Movies', 'content' => $content, 'js_sort' => true]);
    }

    public static function info()
    {
        $separetedLink = explode('/', $_SERVER['PATH_INFO']);
        $id = $separetedLink[2];
        $movieArray = (new Movie())->find('id', $id);
        $movie = $movieArray[0];
        function filter(&$value)
        {
            $value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
        }

        array_walk_recursive($movie, "filter");
        $view = new View();
        $content = $view->generate_html('Movie/view.php', ['movie' => $movie]);
        echo $view->generate_html('wrapper.php', ['title' => $movie['title'], 'content' => $content]);

    }

    public static function addForm()
    {
        if (!$_SESSION['loggedIn']) {
            header('Location: /');
        }
        $view = new View();
        $content = $view->generate_html('Movie/create.php', []);
        echo $view->generate_html('wrapper.php', ['title' => 'Add movie', 'content' => $content]);
    }

    public static function create($inputs)
    {
        if (!$_SESSION['loggedIn']) {
            header('Location: /');
        }
        $title = $inputs['title'];
        $year = $inputs['year'];
        $format = $inputs['format'];
        $actors = $inputs['actors'];

        $data = array();
        array_push($data, null);
        array_push($data, $title);
        array_push($data, $year);
        array_push($data, $format);
        array_push($data, $actors);

        if (!$movie = (new Movie())->find('title', $data[1])) {
            $movie = new Movie();
            $movie->insert($data);
            $newArray = $movie->lastid();
            $lastInsertedMovie = $newArray[0];
            return response(array('status' => 'success', 'id' => $lastInsertedMovie['LAST_INSERT_ID()'], 'message' => 'Movie created'));

        } else {
            return response(array('status' => 'danger', 'message' => 'Movie not created(title already exists)'));
        }
    }

    static public function saveFromFile($file)
    {
        if (!$_SESSION['loggedIn']) {
            header('Location: /');
        }
        $path = 'public/uploads/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $path);
        $info = new SplFileInfo($path);

        if ($info->getExtension() != 'txt') {
            return response(array('status' => 'danger', 'message' => 'Please use .txt files'));

        }
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
                    unset($separatedLine[0]);
                    $title = '';
                    if (count($separatedLine) > 1) {
                        $title = implode(':', $separatedLine);
                    } else {
                        $title = $separatedLine[1];
                    }
                    array_push($data, $title);
                    break;
                case 'Release Year':
                    unset($separatedLine[0]);
                    $year = '';
                    if (count($separatedLine) > 1) {
                        $year = implode(':', $separatedLine);
                    } else {
                        $year = $separatedLine[1];
                    }
                    array_push($data, $year);
                    break;
                case 'Format':
                    $format = $separatedLine[1];
                    array_push($data, $format);
                    break;
                case 'Stars':
                    unset($separatedLine[0]);
                    $actors = '';
                    if (count($separatedLine) > 1) {
                        $actors = implode(':', $separatedLine);
                    } else {
                        $actors = $separatedLine[1];
                    }
                    array_push($data, $actors);
                    break;
                default:
                    $i--;
                    break;
            }
            $i++;
            if ($i % 4 == 0) {
                if (isset($data[1])) {
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
        }
        if ($insertedMovies == 0 && $skippedMovies == 0) {
            return response(array('status' => 'danger', 'message' => 'Please use file with movies info'));

        }
        return response(array('status' => 'success', 'message' => 'Inserted count of movies: ' . $insertedMovies . '.</br> Skipped count of movies: ' . $skippedMovies . ' (Because title already exist)'));
    }

    public static function delete($id)
    {
        if (!$_SESSION['loggedIn']) {
            header('Location: /');
        }
        foreach ($id as $key => $value) {
            (new Movie())->delete('id', $value);
        }
        return response(array('status' => 'success', 'message' => 'Deleted: ' . count($id)));
    }

    public static function findByTitle($inputs)
    {

        $message = 'Nothing to show' . ' Request : ' . htmlspecialchars($inputs['search']);

        $quer = new Movie();

        $movies = $quer->findlike($inputs['type'], $inputs['search']);
        if ($movies != null) {
            $message = 'Finded by ' . $inputs['type'] . ' Request : ' . $inputs['search'];
        }
        function filter(&$value)
        {
            $value = htmlspecialchars($value, ENT_NOQUOTES, 'UTF-8');
        }
        array_walk_recursive($movies, "filter");
        $view = new View();
        $content = $view->generate_html('Movie/list.php', ['movies' => $movies, 'message' => $message, 'js_sort' => true]);
        echo $view->generate_html('wrapper.php', ['title' => 'Search', 'content' => $content]);

    }


}