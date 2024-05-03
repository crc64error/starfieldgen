<?php
header('Content-Type: image/svg+xml');

$width = 2560;
$height = 2560;
$numStars = rand(2500, 6000);
$numGalaxies = rand(30, 130);

$colors = [
    'rgb(189, 207, 194)',
    'rgb(240, 226, 187)',
    'rgb(246, 196, 107)',
    'rgb(86, 48, 9)',
    'RGB(117, 134, 145)',
    'rgb(147, 163, 152)',
    'rgb(200, 149, 83)',
    'rgb(78, 110, 135)'
];

function getRandomDarkColor() {
    $colors = ['rgba(13,5,6,0.2)', 'rgba(3,8,2,0.2)', 'rgba(3,5,11,0.2)'];
    return $colors[array_rand($colors)];
}

function generateRandomPath($width, $height) {
    $startX = rand(0, $width);
    $startY = rand(0, $height);
    $curviness = [rand(50, 150), rand(50, 150), rand(50, 150), rand(50, 150)];
    $path = "M $startX $startY ";
    for ($i = 0; $i < 3; $i++) {
        $control1X = rand(0, $width);
        $control1Y = rand(0, $height);
        $control2X = rand(0, $width);
        $control2Y = rand(0, $height);
        $endX = rand(0, $width);
        $endY = rand(0, $height);
        $path .= "C $control1X $control1Y, $control2X $control2Y, $endX $endY ";
    }
    return $path;
}

echo '<svg width="' . $width . '" height="' . $height . '" xmlns="http://www.w3.org/2000/svg">';

// Generate gradients for galaxies
foreach ($colors as $index => $color) {
    echo "<defs>
        <radialGradient id='galaxyGradient$index' cx='50%' cy='50%' r='50%' fx='50%' fy='50%'>
        <stop offset='0%' style='stop-color:white; stop-opacity:0.9' />
        <stop offset='100%' style='stop-color:$color; stop-opacity:0.1' />
        </radialGradient>
        </defs>";
}

// Generate background nebulae
for ($i = 0; $i < 20; $i++) {
    $path = generateRandomPath($width, $height);
    $color = getRandomDarkColor();
    echo "<path d='$path' fill='$color' fill-opacity='0.01' filter='url(#softenFilter)'/>";
}

// Generate opaque layer
echo "<rect x='0' y='0' width='$width' height='$height' fill='black' fill-opacity='0.95'/>";

// Generate stars
for ($i = 0; $i < $numStars; $i++) {
    $x = rand(0, $width);
    $y = rand(0, $height);
    $radius = rand(5, 20) / 10;  // Stars size
    $opacity = rand(50, 100) / 100;
    echo "<circle cx='$x' cy='$y' r='$radius' fill='white' fill-opacity='$opacity'/>";
}

// Generate galaxies
for ($i = 0; $i < $numGalaxies; $i++) {
    $safe_width = $width - 32;
    $safe_height = $height - 32;
    // Adjust so that a galaxy is never generated near the edge of the render screen
    // The next stage of this will be to continue the generation on the other side of the screen. Which is possible.
    $x = rand(32, $safe_width);
    $y = rand(32, $safe_height);
    $gradientIndex = rand(0, count($colors) - 1);
    $radius = rand(10, 30);  // Galaxy size
    // $blur = rand(5, 10);     // Blur amount
    echo "<circle cx='$x' cy='$y' r='$radius' fill='url(#galaxyGradient$gradientIndex)' filter='url(#blurFilter)'/>";
    // For troubleshooting only    filter='url(#blurFilter)'
    // echo "<script>console.log('Galaxy $i: x=$x, y=$y, radius=$radius, colorIndex=$gradientIndex');</script>";
}

echo '<defs>';
echo '    <filter id="blurFilter"><feGaussianBlur stdDeviation="3"/></filter>';
echo '    <filter id="softenFilter">';
echo '        <feTurbulence baseFrequency="0.001" numOctaves="3" result="turbulence"/>';
echo '        <feComponentTransfer>';
echo '            <feFuncA type="linear" slope="0.1"/> <!-- Adjusts the opacity; slope less than 1 reduces it -->';
echo '        </feComponentTransfer>';
echo '    </filter>';
echo '</defs>';

echo '</svg>';
?>
