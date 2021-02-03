<?php

ob_start('ob_gzhandler');

define('__ROOT__', __DIR__ . '/..');

require_once __ROOT__ . '/vendor/autoload.php';

header('Pragma: public');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: GET, OPTIONS');
header('Access-Control-Max-Age: 1814400');
header('Access-Control-Allow-Headers: Content-Type, Accept, X-Requested-With, remember-me');
header('Cache-Control: max-age=1814400');

$input  = new \Utils\Input;
$avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();

if ($input->format === 'svg') {
    header('Content-type: image/svg+xml');

    echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="' . $input->size . 'px" height="' . $input->size . 'px" viewBox="0 0 ' . $input->size . ' ' . $input->size . '" version="1.1"><' . ($input->rounded ? 'circle' : 'rect') . ' fill="#' . trim(!($input->background) ? $input->background : colorByName($input->name), '#') . '" cx="' . ($input->size / 2) . '" width="' . $input->size . '" height="' . $input->size . '" cy="' . ($input->size / 2) . '" r="' . ($input->size / 2) . '"/><text x="50%" y="50%" style="color: #' . trim($input->color, '#') . '; line-height: 1;font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', \'Roboto\', \'Oxygen\', \'Ubuntu\', \'Fira Sans\', \'Droid Sans\', \'Helvetica Neue\', sans-serif;" alignment-baseline="middle" text-anchor="middle" font-size="' . round($input->size * $input->fontSize) . '" font-weight="' . ($input->bold ? 600 : 400) . '" dy=".1em" dominant-baseline="middle" fill="#' . trim($input->color, '#') . '">' . $avatar->name($input->name)
        ->length($input->length)
        ->keepCase(!$input->uppercase)
        ->getInitials() . '</text></svg>';

    return;
} else {
    header('Content-type: image/png');
}

if (!isset($_GET['no-cache']) && file_exists(__ROOT__ . "/cache/{$input->cacheKey}.png")) {
    if (isset($_GET['debug'])) {
        $file = fopen(__ROOT__ . "/cache/{$input->cacheKey}.png", 'rb');
        fpassthru($file);
    } else {
        header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', filemtime(__ROOT__ . "/cache/{$input->cacheKey}.png") + 1814400));
        header('X-Accel-Redirect: ' . "/cache/{$input->cacheKey}.png"); // If this part is causing you trouble, remove it and uncomment the two following lines:
    }

    exit;
}

header('Expires: ' . gmdate('D, d M Y H:i:s \G\M\T', time() + 1814400));

$image = $avatar->name($input->name)
    ->length($input->length)
    ->fontSize($input->fontSize)
    ->size($input->size)
    ->background($input->background)
    ->color($input->color)
    ->smooth()
    ->allowSpecialCharacters(false)
    ->autoFont()
    ->keepCase(!$input->uppercase)
    ->rounded($input->rounded);

if ($input->bold) {
    $image = $image->preferBold();
}

$image = $image->generate();

$image->save(__ROOT__ . "/cache/{$input->cacheKey}.png", 100);

if (isset($_GET['debug'])) {
    echo $image->stream('png', 100);
} else {
    header('X-Accel-Redirect: ' . "/cache/{$input->cacheKey}.png");
}


function colorByName(string $name)
{

    switch (strtoupper($name[0])) {
        case "A":
            return "DC143C";
            break;
        case "B":
            return "CD5C5C";
            break;
        case "C":
            return "FFB6C1";
            break;
        case "D":
            return "C71585";
            break;
        case "E":
            return "FF7F50";
            break;
        case "F":
            return "FF4500";
            break;
        case "G":
            return "FFA500";
            break;
        case "H":
            return "FFD700";
            break;
        case "I":
            return "BDB76B";
            break;
        case "J":
            return "DDA0DD";
            break;
        case "K":
            return "7FFFD4";
            break;
        case "L":
            return "7CFC00";
            break;
        case "M":
            return "483D8B";
            break;
        case "N":
            return "ADFF2F";
            break;
        case "O":
            return "008000";
            break;
        case "P":
            return "66CDAA";
            break;
        case "Q":
            return "008B8B";
            break;
        case "R":
            return "006400";
            break;
        case "S":
            return "4682B4";
            break;
        case "T":
            return "87CEFA";
            break;
        case "U":
            return "2F4F4F";
            break;
        case "V":
            return "FF00FF";
            break;
        case "W":
            return "6B8E23";
            break;
        case "X":
            return "48D1CC";
            break;
        case "Y":
            return "F0E68C";
            break;
        case "Z":
            return "FA8072";
            break;

        default:
            return "808080";
            break;
    }
}

exit;