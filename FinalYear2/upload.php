<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report</title>
    <link rel="stylesheet" href="stylesheet.css">
</head>
<body>
<section>
    <h1>Report</h1>
</section>
</body>
</html>

<?php


    $text = $_POST['fragment'];

        $required = array(

            array(
                'tag' => 'html',
                'score' => 5,
                'error' => 'Your HTML document is invalid due to the missing HTML tag',
            ),

            array(
                'tag' => 'head',
                'score' => 2.5,
                'error' => 'A head tag is needed.',
            ),

            array (
                'tag' => 'body',
                'score' => 5,
                'error' => 'body tag is needed',
            ),

            array (
                'tag' => 'title',
                'score' => 5,
                'error' => 'title tag needed'
            ),

            array (
                'tag-attribute' => 'lang',
                'score' => 2.5,
                'error' => 'language tags are useful'
            ),

            array (
                'tag-attribute' => '!DOCTYPE',
                'score' => 2.5,
                'error' => 'This document will not run due to missing Doctype tag'
            ),

            array (
                'tag-attribute' => 'html',
                'score' => 2.5,
                'error' => 'missing html attribute after DOCTYPE tag, should be as follows: !DOCTYPE html'
            ),

            array (
                'tag' => 'title',
                'score' => 5,
                'error' => 'missing title tag'
            ),

            array (
                    'tag' => 'main',
                'score' => 5,
                'error' => 'no main tag'
            ),

            array (
                    'style' => 'main',
                'score' => 5,
                'error' => 'no style tag so the CSS will not work'
            ),

        );

        $required_css = array(

                array (
                        'selector' => 'body',
                    'property' => 'background-color',
                    'score' => 2.5,
                    'error' => 'No Background color, one way to make websites more interactive is by having background colours that grab users attention'
                ),

            array (
                    'selector' => 'body',
                'property' => 'font-size',
                'score' => 2.5,
                'error' => 'It is always a good idea to change the font-size of your text so it is not too small to read and makes your website more accessible'
            ),

            array (
                    'selector' => 'main',
                'property' => 'display',
                'score' => 5,
                'error' => 'Display is typically used to help organise the layout of your website, for example display could be flex, or grid if you are using a grid box'
            ),
        );
        $score = 0;
        $errors = array();

        foreach ($required as $requirement) {
            if (isset($requirement['tag'])) {
                $regex = '/<' . $requirement['tag'] . '.*<\/' . $requirement['tag'] . '>/s';
                if (preg_match($regex, $text)) {
                    $score += $requirement['score'];
                } else {
                    $errors[] = $requirement['error'];
                }
            } elseif (isset($requirement['tag-attribute'])) {
                $regex = '/<.*' . $requirement['tag-attribute'] . '.*>/s';
                if (preg_match($regex, $text)) {
                    $score += $requirement['score'];
                } else {
                    $errors[] = $requirement['error'];
                }
            }
        }

        foreach ($required_css as $requirement) {
            $select = isset($requirement['selector']) ? $requirement['selector'] : '';
            $property = $requirement['property'];
            $regex = '/' . $select . '.*' . $property . '.*;/s';
            if(preg_match($regex, $text)) {
                $score += $requirement['score'];
            } else {
                $errors[] = $requirement['error'];
            }
        }

        $total = array_reduce($required, function ($carry, $item) {
            return $carry + $item['score'];
        }, 0);
        $percentage = round($score / $total * 100, 2);

        echo "<div id='score'>Score: $score / $total ($percentage%)\n</div>";

    if (count($errors) > 0) {
        echo "<div id='errortxt'>Errors:\n</div>";
    } foreach($errors as $error) {
    echo "<div id='errormsg'>- $error\n</div>";
    }

    if ($percentage > 100) {
        echo "<div id='percenmsg'>Congratulations, perfect score</div>";
    } elseif ($percentage > 90) {
        echo "<div id='percenmsg'>Almost all correct, keep an eye out for missing closing tags, and the indentation of your code</div>";
    } elseif ($percentage > 70) {
        echo "<div id='percenmsg'>Keep practicing, Common errors including missing indentation, closing tags missing, or empty tags, be sure to check over the work for any of these missing things</div>";
    }